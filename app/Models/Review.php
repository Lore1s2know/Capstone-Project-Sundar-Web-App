<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_name',
        'review_text',
        'category_id',
    ];
    // Relationships
    // A review belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // A review belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
