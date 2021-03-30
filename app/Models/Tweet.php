<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
  use HasFactory;
  use Likable;

  // make sure you know what you're doing with mass assignment.
  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  
}
