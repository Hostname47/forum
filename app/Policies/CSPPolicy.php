<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Csp\Policies\Policy;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;


class CSPPolicy extends Policy
{
    use HandlesAuthorization;

    public function configure()
    {
        $this
            ->addDirective(Directive::BASE, Keyword::SELF)
            ->addDirective(Directive::CONNECT, [
                // We hard coded the app url in routes for now because env doesn't read value from env file
                'self',
                'ws://127.0.0.1:6001',
                'wss://127.0.0.1:6001',
                'ws://ws-eu.pusher.com:6001',
                'wss://ws-eu.pusher.com:6001',
            ])
            ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
            // ->addDirective(Directive::IMG, [
            //     Keyword::SELF,
            //     'data:',
            //     'blob:'
            // ])
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective(Directive::SCRIPT, [
                Keyword::SELF,
                'code.jquery.com',
                'cdn.jsdelivr.net',
                'cdnjs.cloudflare.com'
            ])
            ->addDirective(Directive::OBJECT, Keyword::NONE);
    }
}
