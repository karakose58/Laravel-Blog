<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['category_name', 'title', 'text', 'user_id', 'status', 'start', 'stop', 'tags', 'image'];

    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = json_encode(is_array($value) ? $value : array_map('trim', explode(',', $value)));
    }

    public function getTagsAttribute($value)
    {
        return is_array(json_decode($value, true)) ? implode(', ', json_decode($value, true)) : '';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id')->where('status', 1);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_name', 'name');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}


