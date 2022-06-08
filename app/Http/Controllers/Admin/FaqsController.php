<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\FAQ;
use App\View\Components\Admin\Faq\FaqComponent;

class FaqsController extends Controller
{
    public function index() {
        $live_faqs = FAQ::with('user')->where('live', 1)->orderBy('priority')->get();
        $unverified_faqs = FAQ::with('user')->where('live', 0)->orderBy('created_at', 'desc')->take(8)->get();
        
        $unverified_faqs_count = FAQ::where('live', 0)->count();
        $has_more_unverified = $unverified_faqs_count > $unverified_faqs->count();

        return view('admin.manage-faqs')
            ->with(compact('live_faqs'))
            ->with(compact('unverified_faqs'))
            ->with(compact('has_more_unverified'))
            ->with(compact('unverified_faqs_count'))
        ;
    }

    public function update(Request $request) {
        $data = $request->validate([
            'faq_id'=>'required|exists:faqs,id',
            'question'=>'sometimes|min:1|max:2000',
            'answer'=>'sometimes|min:1|max:20000',
            'live'=>['sometimes', Rule::in([0, 1])]
        ]);

        $this->authorize('update_faq', [FAQ::class]);

        $faq = FAQ::find($data['faq_id']);

        if(isset($data['live']))
            if($data['live']==1) {
                $data['desc'] = '--';
                \Session::flash('message', 'FAQ <span class="blue">"' . $faq->questionslice . '"</span> is live now. (Don\'t forget to handle i18n)');
            } else
                \Session::flash('message', 'FAQ <span class="blue">"' . $faq->questionslice . '"</span> is idle now and hidden from users in faqs page. (Don\'t forget to handle i18n)');
        
        unset($data['faq_id']);
        $faq->update($data);
    }

    public function delete(Request $request) {
        $faqid = $request->validate(['faq_id'=>'required|exists:faqs,id'])['faq_id'];
        $this->authorize('delete_faq', [FAQ::class]);
        
        FAQ::find($faqid)->delete();
    }

    public function update_faqs_priorities(Request $request) {
        $data = $request->validate([
            'faqs_ids.*'=>'required|exists:faqs,id',
            'faqs_priorities.*'=>'required|numeric',
        ]);
        $this->authorize('update_faqs_priorities', [FAQ::class]);

        $i = 0;
        foreach($data['faqs_ids'] as $fid) {
            FAQ::find($fid)->update(['priority'=>$data['faqs_priorities'][$i]]);
            $i++;
        }
    }

    public function fetch_more_faqs(Request $request) {
        $data = $request->validate([
            'skip'=>'required|numeric|max:100',
            'take'=>'required|numeric|max:100',
            'type'=>['required', Rule::in(['live', 'unverified'])]
        ]);

        $state = $data['type'] == 'live' ? 1 : 0;
        $faqs = FAQ::with(['user'])->where('live', $state)->orderBy('created_at', 'desc')->skip($data['skip'])->take(intval($data['take']) + 1)->get();
        $hasmore = ($faqs->count() > intval($data['take'])) ? true : false;
        $faqs = $faqs->take(intval($data['take']));

        $payload = "";
        foreach($faqs as $faq) {
            $faq_component = (new FaqComponent($faq));
            $faq_component = $faq_component->render(get_object_vars($faq_component))->render();
            $payload .= $faq_component;
        }

        return [
            'payload'=>$payload,
            'count'=>$faqs->count(),
            'hasmore'=>$hasmore
        ];
    }
}
