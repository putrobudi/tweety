<?php

namespace App\Http\Controllers;



use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetsController extends Controller
{

    public function index()
    {
        return view('tweets.index', [
            'tweets' => auth()->user()->timeline()
        ]);
    }

    public function store()
    {
        // why we can pass this variable to create array below?
        // because when the test passes, it will return an array of the input and so we can access the array like $attributes['body']
        $attributes = request()->validate(['body' => 'required|max:255']);
        //  because we're mass assigning, then we have to make $fillable or turn off $fillable with $guarded = []
        Tweet::create([
            'user_id' => auth()->id(),
            'body' => $attributes['body']
        ]);

        return redirect('/home');
    }
}
