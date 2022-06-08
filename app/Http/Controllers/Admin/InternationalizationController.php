<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class InternationalizationController extends Controller
{
    public function index() {
        $paths = [
            [
                'path'=>'app',
                'ignoredpaths'=>[]
            ],
            [
                'path'=>'resources/views',
                'ignoredpaths'=>['admin', 'partials/admin', 'components/admin']
            ],
        ];

        return view('admin.internationalization')
            ->with(compact('paths'));
    }

    public function search_for_keys_by_paths(Request $request) {
        $paths = $request->validate(['paths'=>'required|array'])['paths'];
        $basepath = base_path();
        $keys=[];

        foreach($paths as $path) {
            $mainpath = $path[0];
            $ignoredpaths = isset($path[1]) ? $path[1] : [];
            /**
             * Run git grep to search for __('') and __("") patterns inside each subfile in the current path
             * command : git grep -oP -h "(\_\_\(\'.*?\'\))|(\_\_\(\".*?\"\))" $path <<< prefixSTRING 2>&1
             * 
             * Plase remember the command above is what works in linux servers, the following grep command is
             * using carret escaping to escape angle brackets for windows (since I'm developing on windows machine)
             */
            if(count($ignoredpaths)) {
                $exclude = "";
                foreach($ignoredpaths as $ign) {
                    $ignoredpath = base_path($mainpath . '/' . $ign);
                    if(is_file($ignoredpath))
                        $exclude .= ':!'. $mainpath . '/' . $ign . ' ';
                    elseif(is_dir($ignoredpath))
                        $exclude .= ':!'. $mainpath . '/' . $ign . '/* ';
                }

                $command = <<<DAMN_GREP
cd $basepath && git grep -oP -h "(\_\_\(\'.*?\'\))|(\_\_\(\".*?\"\))" -- $mainpath ^<^<^< prefixSTRING $exclude 2>&1
DAMN_GREP;
            }
            else
                $command = <<<DAMN_GREP
cd $basepath && git grep -oP -h "(\_\_\(\'.*?\'\))|(\_\_\(\".*?\"\))" -- $mainpath ^<^<^< prefixSTRING 2>&1
DAMN_GREP;

            exec($command, $keys);
        }

        // Remove duplicates
        $keys = array_unique($keys);
        $jsonkeys = [];
        // Remove __ () '' "" from keys
        foreach($keys as $key)
            $jsonkeys[substr($key, 4, (strlen($key) - 6))] = "";

        return [
            'keys'=>$jsonkeys,
            'count'=>count($keys)
        ];
    }

    public function search_for_keys_in_database() {
        $sources = [
            ['table'=>'ban_reasons', 'columns'=>['name', 'reason']],
            ['table'=>'categories', 'columns'=>['category', 'description'], 'conditions'=>'status_id!=3'],
            ['table'=>'category_status', 'columns'=>['status']],
            ['table'=>'closereasons', 'columns'=>['name', 'reason']],
            ['table'=>'faqs', 'columns'=>['question', 'answer'], 'conditions'=>'live=1'],
            ['table'=>'forums', 'columns'=>['forum', 'description'], 'conditions'=>'status_id!=3'],
            ['table'=>'forum_status', 'columns'=>['status']],
            ['table'=>'notifications_statements', 'columns'=>['statement']],
            ['table'=>'strike_reasons', 'columns'=>['name', 'content']],
            ['table'=>'thread_status', 'columns'=>['status']],
            ['table'=>'thread_visibility', 'columns'=>['visibility']],
            ['table'=>'warning_reasons', 'columns'=>['name', 'content']],
        ];

        $results = [];
        foreach($sources as $source) {
            $dbkeys = 
                \DB::select("SELECT " . implode(', ', $source['columns']) . " FROM " . $source['table'] . (isset($source['conditions']) ? " WHERE " . $source['conditions'] : ''));

            foreach($dbkeys as $key)
                $results = array_unique(array_merge($results, array_values(get_object_vars($key))));
            
            $jsonkeys = [];
            foreach($results as $result)
                $jsonkeys[$result] = "";
        }
        return [
            'keys'=>$jsonkeys,
            'count'=>count($jsonkeys)
        ];
    }

    public function get_lang_file_keys(Request $request) {
        $lang = $request->validate(['lang'=>['required', Rule::in(['ar', 'fr'])]])['lang'];

        // Building language json file path.
        $lang_file_path = resource_path("lang/$lang.json");
        
        // Fetch file content
        $content = File::get($lang_file_path);
        
        return $content;
    }
}
