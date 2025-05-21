<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'status'];

    public function posts() 
    {
        return $this->hasMany(Post::class, 'category_name', 'name')->where('posts.status', 1); 
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }}

