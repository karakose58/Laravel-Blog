<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['category_name', 'title', 'text', 'user_id', 'is_active', 'start', 'stop', 'tags', 'image'];

    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = json_encode(array_map('trim', explode(',', $value)));
    }

    public function getTagsAttribute($value)
    {
        $tags = json_decode($value, true);

        if (!is_array($tags)) {
            return '';
        }

        return implode(', ', $tags);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(comment::class, 'post_id')->where('is_active', 1);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_name', 'name');
    }
}


