<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'email',
    'password',
  ];

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

  public function getAvatarAttribute()
  {
    return "https://i.pravatar.cc/40?u" . $this->email;
  }

  public function timeline()
  {
    return Tweet::where('user_id', $this->id)->latest()->get();
  }

  // Method to create a new relationship
  // When you create a relationship with this method and you don't assign withTimeStamps() on the follows() method,
  // The timestamps column will be empty.
  public function follow(User $user) {
    return $this->follows()->save($user);
  }

  public function follows()
  {
    // Because we're not following Laravel's pivot table naming convention, then we have to specify the 
    // custom table name as the second parameter. And because we're using a custom table name, 
    // we'll have to specify the foreign pivot key and related pivot key. 
    // It has to be in order. You cannot swap related pivot key and foreign pivot key.
    return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id');
  }
}
