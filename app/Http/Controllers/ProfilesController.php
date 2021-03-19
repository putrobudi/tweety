<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    // Laravel assumes the wild card to be the id when using Route Model Binding. For example /profiles/1
    // What if we want to use name column? 
    public function show(User $user) {
        return view('profiles.show', compact('user'));
    }
}
