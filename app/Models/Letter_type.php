<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_code',
        'name_type',
    ];
}
