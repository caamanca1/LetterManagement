<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Letter;
use App\Models\User;
use App\Models\Result;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_id',
        'notes',
        'presence_recipients',
    ];

    protected $casts = [
        'presence_recipients' => 'array',
    ];

    public function letter() {
        return $this->belongsTo(Letter::class);
    }
}
