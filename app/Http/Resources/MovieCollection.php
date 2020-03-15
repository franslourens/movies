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

		if($data)
		{
			$genres = Movie::genres(MovieCollection::base_url, MovieCollection::api_key);
			
			$movies["page"] = $data["page"];
			$movies["total_results"] = $data["total_results"];
			$movies["total_pages"] = $data["total_pages"];

			
			foreach($data["results"] as $movie)
			{					
				$movie_id = intval($movie["id"]);
				$movie_genres[$movie_id][] = [];
					
				foreach($movie["genre_ids"] as $id)
				{
					foreach($genres as $genre)
					{
						if($genre["id"] == $id)
						{
							$movie_genres[$movie_id][] = $genre["name"];
						}
					}
				}

				$release_date = "N\A";
				
				if(isset($movie["release_date"]) && !empty($movie["release_date"]))
				{
					$release_date = $movie["release_date"];
				}
				
				$movies["results"][] = Movie::make(["id" => $movie_id,
													"title" => $movie["title"],
													"original_title" => $movie["original_title"],
													"overview" => $movie["overview"],
													"popularity" => $movie["popularity"],
													"vote_average" => $movie["vote_average"],
													"poster_path" => $movie["poster_path"],
													"release_date" => $release_date,
													"original_language" => $movie["original_language"],
													"genres" => $movie_genres[$movie_id]
													]);
			}
			
			return $movies;
		}
		
		return ["page" => 1, "total_results" => 1, "total_pages" => 1, "results" => [Movie::make(["id" => "", 
																								  "title" => "", 
																								  "original_title" => "", 
																								  "overview" => "",
																								  "popularity" => "",
																								  "vote_average" => "",
																								  "poster_path" => "",
																								  "release_date" => "",
																								  "original_language" => "",
																								  "genres" => ""
																								  ])]];
    }
}
