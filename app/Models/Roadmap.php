<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roadmap extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'category',
    ];

    
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id'); 
    }
    
    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function upvotes()
    {
        return $this->hasMany(Upvote::class);
    }
}
