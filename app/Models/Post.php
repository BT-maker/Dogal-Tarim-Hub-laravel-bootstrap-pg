<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'is_published',
        'published_at',
        'user_id' //Yazar ID'si ekledik
    ];

    protected $casts =[
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title']= $value;
        $this->attributes['slug']= Str::slug($value);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published',true)
                     ->where('published_at', '<=', now());
    }


    //Yazar ilişkisi (belongsTo)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Kategoriler ilişkisi (many-to-many)
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_categories');
    }
}