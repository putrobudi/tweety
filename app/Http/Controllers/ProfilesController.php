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
        // return view('profiles.show', compact('user'));
        return view('profiles.show', [
            'user' => $user,
            'tweets' => $user->tweets()->withLikes()->paginate(50)
        ]);
        // The point where you keep loading tweets, you might want to extract this to a repository or a helper method
        // on your model. It's something to be aware of.
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

    public function update(User $user)
    {

        // dd(request('avatar'));
        // you can throw this validation into form request class and type method on the parameter.
        $attributes = request()->validate([
            'username' => ['string', 'required', 'max:255', 'alpha_dash', Rule::unique('users')->ignore($user)], /* ignore current username on unique check */
            'name' => ['string', 'required', 'max:255'],
            'avatar' => ['file'],
            'email' => ['string', 'required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'password' => ['string', 'required', 'min:8', 'max:255', 'confirmed'] /* this will check for attribute password_confirmation */
        ]);

        // this will store the image and then return a path to where the image is stored. 
        // And that is what we will save to the database by adding that to $attribute array before updating.
        // Well now the image is stored in storage/app/avatars. And you want to move that to storage/public folder. So,
        // change that in config/filesystems and then symlink it to the public folder. Use artisan storage:link
        // because the avatar is optional, you'd only want to store the avatar if user uploads them.
        if (request('avatar')) {
            $attributes['avatar'] = request('avatar')->store('avatars');
        }

        $user->update($attributes);

        return redirect($user->path());
    }
}
