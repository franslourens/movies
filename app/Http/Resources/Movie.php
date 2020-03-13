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
                "original_language" => $this->resource['original_language']
        ];
    }
}
