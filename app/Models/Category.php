<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon'
    ];

    // otomatik slug oluşturma
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str::slug($value);
    }

    //Post ilişkisi (many-to-many)
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_categories');
    }
}
