<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Letter_type;
use App\Models\User;
use App\Models\Result;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_type_id',
        'letter_perihal',
        'recipients',
        'content',
        'attachment',
        'notulis',
    ];

    protected $casts = [
        'recipients' => 'array',
    ];

    public function LetterType() {
        return $this->belongsTo(Letter_type::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'notulis', 'id');
    }

    public function results() {
        return $this->hasMany(Result::class,  'letter_id', 'id');
    }
}
