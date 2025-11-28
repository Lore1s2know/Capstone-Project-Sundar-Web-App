<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Upvote extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'review_id', 'vote'];

    // Relationship: This upvote belongs to a specific User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: This upvote belongs to a specific Review
    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
