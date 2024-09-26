<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]) ;
        Subscriber::create([
            'email'=>$request->email,

        ]);
        return back()->with('success' , 'you have successfully subscribed');

    }
}
