<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $watch_list = $request->user()->watch()->get();
        
        $movies = [];
        
        foreach($watch_list as $watch)
        {
            $movies[] = $watch->movie_id;
        }
        
        return view('home', ["movies" => $movies]);
    }
}
