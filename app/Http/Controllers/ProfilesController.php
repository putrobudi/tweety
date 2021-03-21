<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    // Laravel assumes the wild card to be the id when using Route Model Binding. For example /profiles/1
    // What if we want to use name column? 
    public function show(User $user)
    {
        return view('profiles.show', compact('user'));
    }

    public function edit(User $user)
    {
        // You can refactor this code with abort_if
        // if ($user->isNot(current_user())) {
        //     abort(404);
        // }

        // If you want to tweak this, we could instead extract this to a Policy.
        // abort_if($user->isNot(current_user()), 404);
        
        // or you can declare this in routes file using middleware.
        // $this->authorize('edit', $user);
        
        return view('profiles.edit', compact('user'));
    }
}
