<?php

namespace App\Policies;

use App\Models\Idea;
use App\Models\User;

class IdeaPolicy
{
    /**
     * Autorisé si l'utilisateur est l'auteur ou un admin.
     */
    public function update(User $user, Idea $idea): bool
    {
        return $user->id === $idea->user_id || $user->isAdmin();
    }

    /**
     * Autorisé si l'utilisateur est l'auteur ou un admin.
     */
    public function delete(User $user, Idea $idea): bool
    {
        return $user->id === $idea->user_id || $user->isAdmin();
    }
}
