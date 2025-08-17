<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = ['community_id', 'user_id', 'content'];

    // Define the relationship with comments
    public function comments()
    {
        return $this->hasMany(CommunityComment::class);
    }

    // Define the relationship with the user who created the post
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the community the post belongs to
    public function community()
    {
        return $this->belongsTo(Community::class);
    }
}
