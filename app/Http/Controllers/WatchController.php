<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Watch;
use App\Http\Resources\Movie;

class WatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
	public function index(Request $request)
    {
        $watch_list = $request->user()->watch()->get();
        
        $movies = [];
        
        foreach($watch_list as $watch)
        {
            $movies[] = Movie::get_details($watch->movie_id);
        }

        return view('watch.index', ["movies" => $movies]);
    }
    

    public function store(Request $request)
    {        
        try
        {
            $request->user()->watch()->updateOrCreate(['movie_id' => $request->movie_id]);
            echo json_encode(array("status" => "success", "message" => ""));
            exit;
        }
        catch(Exception $e)
        {
            echo json_encode(array("status" => "failed", "message" => $e->getMessage()));
            exit;          
        }
    }
    
    public function destroy(Request $request)
    {
        $watch = Watch::where([['movie_id','=', $request->movie_id],['user_id','=', $request->user()->id]]);
        
        $watch->delete();
 
        echo json_encode(array("status" => "success", "message" => ""));
        exit;
    }
}
