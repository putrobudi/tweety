<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    // can you edit the given user?
    // Laravel will automatically register this for us. I don't know what this means..
    // maybe it has got something to do with Guessing Ability Name? I don't remember...
    public function edit(User $user, User $currentUser) /* the order of the parameter is not relevant */ {
        return $currentUser->is($user);
    }
}
