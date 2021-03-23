<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    public function update(User $user) {

        // dd(request('avatar'));
        // you can throw this validation into form request class and type method on the parameter.
       $attributes = request()->validate([
           'username' => ['string', 'required', 'max:255', 'alpha_dash', Rule::unique('users')->ignore($user)], /* ignore current username on unique check */
           'name' => ['string', 'required', 'max:255'],
           'avatar' => ['required', 'file'],
           'email' => ['string', 'required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
           'password' => ['string', 'required', 'min:8', 'max:255', 'confirmed'] /* this will check for attribute password_confirmation */
       ]);
      
       // this will store the image and then return a path to where the image is stored. 
       // And that is what we will save to the database by adding that to $attribute array before updating.
       // Well now the image is stored in storage/app/avatars. And you want to move that to storage/public folder. So,
       // change that in config/filesystems and then symlink it to the public folder. Use artisan storage:link
       $attributes['avatar'] = request('avatar')->store('avatars');

       $user->update($attributes);

       return redirect($user->path());
    }
}
