<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Movie;

class MovieCollection extends ResourceCollection
{
    const api_key = "531eaffcac14a8c431f91d7a77a345e8";
       
    const base_url = "https://api.themoviedb.org/3/";
    
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
             'links' => $this->links()
        ];
    }
    
    public static function all($params)
    {
        $query = $params["query"];
        $page = $params["page"];
        
        $popular_url = MovieCollection::base_url . "movie/popular?" . http_build_query(["api_key" => MovieCollection::api_key,
                                                                                       "page" => $page]);
                                                                               
        $search_url = MovieCollection::base_url . "search/movie?" . http_build_query(["api_key" => MovieCollection::api_key,
                                                                                     "page" => $page,
                                                                                     "query" => $query]);
        
        $url = $popular_url;

        if($query)
        {
            $url = $search_url;
        }
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        
        $data = json_decode($response, true);

        $movies["page"] = $data["page"];
        $movies["total_results"] = $data["total_results"];
        $movies["total_pages"] = $data["total_pages"];
        
        foreach($data["results"] as $movie)
        {
            $movies["results"][] = Movie::make(["id" => $movie["id"],
                                                "title" => $movie["title"],
                                                "original_title" => $movie["original_title"],
                                                "overview" => $movie["overview"],
                                                "popularity" => $movie["popularity"],
                                                "vote_average" => $movie["vote_average"],
                                                "poster_path" => $movie["poster_path"],
                                                "release_date" => $movie["release_date"],
                                                "original_language" => $movie["original_language"]
                                                ]);
        }
        
        return $movies;
    }
}
