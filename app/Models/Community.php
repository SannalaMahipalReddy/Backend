<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $fillable = ['name', 'description','created_by'];


    public function posts()
    {
        return $this->hasMany(CommunityPost::class);
    }
}

