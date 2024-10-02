<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'image_path','media_url', 'category_id', 'content_type_id', 'user_id'];

    // Each content belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Each content has a content type (e.g., article, video)
    public function contentType()
    {
        return $this->belongsTo(ContentType::class, 'type_id');
    }

    // Each content is created by a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each content can have many media items
    public function media()
    {
        return $this->hasMany(Media::class);
    }
}
