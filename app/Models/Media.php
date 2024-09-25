<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = ['content_id', 'url', 'type'];

    // Each media belongs to a content
    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
