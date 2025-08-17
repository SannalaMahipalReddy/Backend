<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityComment extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'user_id', 'comment'];

    // Define the relationship with the post
    public function post()
    {
        return $this->belongsTo(CommunityPost::class);
    }

    // Optional: Define the relationship with the user who created the comment
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
