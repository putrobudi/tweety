<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

trait Likable
{

  // Tweet::withLikes()->get() gives you all the attributes of the tweets and the number of likes dislikes.
  public function scopeWithLikes(Builder $query) {
    $query->leftJoinSub(
      'SELECT tweet_id, sum(liked) likes, sum(!liked) dislikes FROM `likes` GROUP BY tweet_id',
      'likes',
      'likes.tweet_id',
      'tweets.id'
    );
  }

  # Why put like method here not in User? Because Tweet can have likes. While we don't have user liking system.

  # There's a couple of ways to do this. 

  // What if the use $tweet->like() and also $tweet->dislike()? Then we'll have two records which likes and dislikes a tweet.
  // So let's protect this case in database and then use updateOrCreate.

  // $tweet->like(); // true
  // $tweet->dislike(); // false

  // You can merge like and dislike function into one instead of writing dislike function almost identical to like().

  // $tweet->like() this give you a clean API. You can change it to something like this which was my question all along
  // $user->like($tweet) but you end up with caught objects??? I can only understand that this is more complicated...
  // So what you might consider is accepting a user but not requiring it. Because other than a cleaner api, it gives you
  // the ability to pass in a user.
  public function like($user = null, $liked = true)
  {
    $this->likes()->updateOrCreate([
      'user_id' => $user ? $user->id : auth()->id()
    ], [
      'liked' => $liked
    ]);
  }

  // if we have a tweet model i want to be able to do something like this: $tweet->dislike() or $tweet->like() 
  public function dislike($user = null)
  {
    // in a bigger code try to use something more explicit than using false. Because it can be hard to know what false does.
    // but here it's very clear.
    return $this->like($user, false);
  }

  # It's nice to know if a user liked a particular tweet
  // you could have it on User model $user->liked($tweet), or on the tweet model
  // $tweet->isLikedBy($user)

  public function isLikedBy(User $user)
  {
    # couple of way to do it
    // The issue with this code is that if you're going in a loop and for each loop you're checking that user
    // liked that particular tweets, you'd end up with the N+1 problem. 
    // $this->likes()->where('user_id', $user->id)->exists();
    # what if instead we can grab it off a user. User can access their likes. 
    // And if we eager load it (?) then for every single tweet we're not loading a brand new database query. We're loading
    // from existing collection. This probably fine in a lot of cases but for high volume, probably need to switch to something
    // like Redis. For demo, it's okay if it's loaded into a collection. Image if a user liked a million different things, you'd
    // have to change this...
    return (bool) $user->likes->where('tweet_id', $this->id)->where('liked', true)->count();
  }

  // You can seperate isDislikedBy like this or you can merge with isLikedBy just like the like and dislike function.
  public function isDislikedBy(User $user)
  {
    return (bool) $user->likes
      ->where('tweet_id', $this->id)
      ->where('liked', false)
      ->count();
  }


  public function likes()
  {
    // if you want to be little more fancy, you could set a polymorphic relationship. This allows many things to be liked.
    // e.g you can like a tweet or a user or a blog post. But in our case, we're only ever gonna like the tweets. 
    return $this->hasMany(Like::class);
  }
}
