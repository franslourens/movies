<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
    protected $table = 'movies.watch';
    protected $fillable = ['movie_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
