<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable, Followable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  // These are the attributes that can be mass assigned.
  // protected $fillable = [
  //   'username',
  //   'name',
  //   'email',
  //   'password',
  //   'avatar'
  // ];

  protected $guarded = [];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function getAvatarAttribute($value)
  {
    // return "https://i.pravatar.cc/200?u" . $this->email;
    // return asset($value); // this only works with Laravel Valet server. You can do below or change link configuration on
    // filesystem config
    $storage_path = 'storage/' . $value;
    return asset($value ? $storage_path : '/images/default-avatar.png');

    // you could do it like this if writing only asset($value) works --> return asset($value ?: path)

  }

  // $user->password = 'foobar'; This is called mutator everytime you're setting the password.
  public function setPasswordAttribute($value) {
    $this->attributes['password'] = bcrypt($value);
  }

  public function timeline()
  {
    // We can write this logic with tweets relationship below. And for the timeline, we'll do something else.
    // return Tweet::where('user_id', $this->id)->latest()->get();
    
    // include all of the user's tweets
    // as well as the tweets of everyone
    // they follow ... in descending order by date.

    /* ******
    // $this->follows will return a collection of all the users that the current user follows.
    // And imagine if the user follows 5000 people. If in the end we're only going to pluck the id
    // We can instead chain it like this: $this->follows()->pluck('id') so that it will be more performant.
    // $ids = $this->follows->pluck('id');
    $ids = $this->follows()->pluck('id');
    // include current user id to in ids array.
    $ids->push($this->id);

    // Give me a collection of user_id where the user_id is in this array of ids
    return Tweet::whereIn('user_id', $ids)->latest()->get(); 
    ********** */

    // You can also write the code block above like this 
    $friends = $this->follows()->pluck('id');
    // give me any tweets from the current friends
    // or where the user id is from the current user.
    // There are other relationship specific things if you go about it but 
    // this is thought to be fine.
    return Tweet::whereIn('user_id', $friends)
      ->orWhere('user_id', $this->id)
      ->withLikes()
      // ->latest()->get();
      ->latest()->paginate(50); // if you don't want to duplicate this, you'd want to extract it. Maybe you'd have config item..
  }

  public function tweets() {
    // You can set orderBy here if you always want to have it set.
    return $this->hasMany(Tweet::class)->latest();
  }

  public function path($append = '') {
    // $path = route('profile', $this->name);
    $path = route('profile', $this->username);

    return $append ? "{$path}/{$append}" : $path;
  }

  public function likes() {
    return $this->hasMany(Like::class);
  }
  
  // This the name of the key or the attribute in database that should be used as a Route Model Binding.
  // And this is how you'd do it in Laravel 6 and below. But in Larevel 7 and above you can directly write the attribute
  // name in the wild card route. E.g /profiles/{user:name}
  // public function getRouteKeyName()
  // {
  //   return 'name';
  // }
  
}
