<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Movie extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                "id" => $this->resource['id'],
                "title" => $this->resource['title'],
                "original_title" => $this->resource['original_title'],
                "overview" => $this->resource['overview'],
                "popularity" => $this->resource['popularity'],
                "vote_average" => $this->resource['vote_average'],
                "poster_path" => $this->resource['poster_path'],
                "release_date" => $this->resource['release_date'],
                "original_language" => $this->resource['original_language'],
				"genres" => $this->resource['genres']
        ];
    }
	
	public static function get_details($movie_id)
	{
		$curl = curl_init("https://api.themoviedb.org/3/movie/" . $movie_id . "?api_key=531eaffcac14a8c431f91d7a77a345e8");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);	

		$data = json_decode($response, true);
		
		if($data)
		{
			return $data;
		}	
		
		return false;		
	}
	
	public static function genres($url, $api_key)
	{
		$curl = curl_init($url . "genre/movie/list?api_key=" . $api_key);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
		
		$data = json_decode($response, true);
		
		if($data)
		{
			return $data["genres"];
		}	
		
		return [];
	}
}
