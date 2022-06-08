<?php

namespace App\Classes;

class Helper {
   /**
    * Encode array from latin1 to utf8 recursively
    * @param $dat
    * @return array|string
    */
   public static function convert_from_latin1_to_utf8($dat) {
      if (is_string($dat)) {
         return utf8_encode($dat);
      } elseif (is_array($dat)) {
         $ret = [];
         foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

         return $ret;
      } elseif (is_object($dat)) {
         foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

         return $dat;
      } else {
         return $dat;
      }
   }

    function notification_icon($action_type) {
        switch($action_type) {
            case 'thread-reply':
                return 'resource24-reply-icon';
            case 'thread-vote':
            case 'post-vote':
                return 'resource24-vote-icon';
            case 'thread-like':
            case 'post-like':
                return 'resource24-like-icon';
            case 'warn-user':
            case 'thread-close':
            case 'first-signin-password-set':
                return 'warning24-icon';
            case 'user-follow':
                return 'followfilled24-icon';
            case 'user-avatar-change':
            case 'user-cover-change':
                return 'image24-icon';
            case 'poll-action':
                return 'poll24-icon';
            case 'poll-vote':
                return 'pollvote24-icon';
            case 'poll-option-add':
                return 'polloptionadd24-icon';
            case 'post-tick':
                return 'posttick24-icon';
            case 'thread-restore':
            case 'post-restore':
                return 'restore24-icon';
            case 'thread-open':
            case 'post-open':
                return 'open24-icon';
            case 'strike-user':
                return 'strike24-icon';
            case 'ban-user':
            case 'temporarily-ban-user':
                return 'ban24-icon';
            default:
                return 'notification24-icon';
        }
    }

    public static function mdparse($content) {
        $result = str_replace('&gt;', '>', $content); // Quote in markdown use > 
        $result = str_replace("\r\n", "  \n", $result);
        return \Markdown::parse($result);
    }

    public static function mark_report_as_reviewed($reportable_id, $reportable_type) {
        // When strike the resource owner we want to mark the report as reviewed
        $report = \App\Models\Report::where('reportable_id', $reportable_id)
            ->where('reportable_type', $reportable_type)->first();

        if($report) {
            $reports = json_decode($report->data);
            foreach($reports as $r)
                $r->reviewed = 1;
            $report->data = json_encode($reports);
            $report->reviewed = 1;
            $report->save();
        }
    }
}