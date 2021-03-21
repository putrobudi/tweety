<?php

namespace App\Http\Controllers;

use App\Models\User;

class FollowsController extends Controller
{
    public function store(User $user) {
        // Move this to Followable.
        // if (auth()->user()->following($user)) {
        //     auth()->user()->unfollow($user);
        // } else {
        //     // have the auth'd user follow the given user
        //     auth()->user()->follow($user);
        // }

        auth()->user()->toggleFollow($user);

        return back();
    }    
}
