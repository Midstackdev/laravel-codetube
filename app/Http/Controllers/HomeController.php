<?php

namespace App\Http\Controllers;

use App\Repository\UserRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('welcome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, UserRepository $user)
    {
        return view('home', [
            'subscriptionVideos' => $user->videosFromSubscriptions($request->user())
        ]);
    }

    public function welcome()
    {
        return view('welcome');
    }
}
