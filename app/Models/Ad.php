<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'image_url', 'content'];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
