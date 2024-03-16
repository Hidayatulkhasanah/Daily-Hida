<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Belajar extends Model
{
    use HasFactory;
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'title',
        'content',
    ];

protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/belajars/' . $image),
        );
    }
}


