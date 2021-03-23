<?php

namespace App\Models;

trait Followable
{

  // Method to create a new relationship
  // When you create a relationship with this method and you don't assign withTimeStamps() on the follows() method,
  // The timestamps column will be empty.
  public function follow(User $user)
  {
    return $this->follows()->save($user);
  }

  public function toggleFollow(User $user)
  {
    // You can simplify this conditional code with Laravel's toggle method. 
    // if ($this->following($user)) {
    //   return $this->unfollow($user);
    // }
    // // have the auth'd user follow the given user
    // return $this->follow($user);
    return $this->follows()->toggle($user);
  }

  public function unfollow(User $user)
  {
    return $this->follows()->detach($user);
  }

  public function follows()
  {
    // Because we're not following Laravel's pivot table naming convention, then we have to specify the 
    // custom table name as the second parameter. And because we're using a custom table name, 
    // we'll have to specify the foreign pivot key and related pivot key. 
    // It has to be in order. You cannot swap related pivot key and foreign pivot key.
    return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id');
  }

  public function following(User $user)
  {
    // Whenever you had roughly 3 or more related methods on a model like this,
    // it's good to extract it to traits.

    // The downside here is you're fetching a collection $this->follows. This fetches an entire collection of followed users.
    // What if you call 3000 users? That'd be calling 3000 Collections of users.
    // return $this->follows->contains($user);

    return $this->follows()
      ->where('following_user_id', $user->id)
      ->exists();
  }
}
