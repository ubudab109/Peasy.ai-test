<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRandom extends Model
{
    use HasFactory;

    protected $table = 'user_random';
    protected $fillable = [
        'median',
        'mean',
        'data',
    ];
    // protected $casts = [
    //     'data' => 'array',
    // ];

}
