<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function picture()
    {
        return $this->belongsTo(Picture::class, 'pictureId');
    }

    protected $fillable = ['title', 'pictureId' ,"author", "description", "userId"];
}
