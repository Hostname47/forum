<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqsPolicy
{
    use HandlesAuthorization;

    const RATE_LIMIT = 8;

    public function store(User $user) {
        if($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));

        if($user->faqs()->today()->count() >= self::RATE_LIMIT) {
            $user->log_authbreak('faqs-daily-limit-reached');
            return $this->deny(__('You reach your limited number of questions to ask per day') . ' (' . self::RATE_LIMIT . ' ' . __('questions') . ')');
        }

        return true;
    }

    public function update_faq(User $user) {
        if(!$user->has_permission('update-faq'))
            return $this->deny("You don't have permission to update faqs. This action has been sent to site owners for review");

        return true;
    }

    public function delete_faq(User $user) {
        if(!$user->has_permission('delete-faq'))
            return $this->deny("You don't have permission to update faqs. This action has been sent to site owners for review");

        return true;
    }

    public function update_faqs_priorities(User $user) {
        if(!$user->has_permission('update-faqs-priorities'))
            return $this->deny("You don't have permission to update faqs priorities. This action has been sent to site owners for review");

        return true;
    }
}
