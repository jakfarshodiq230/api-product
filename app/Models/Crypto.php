<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crypto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coin',
        'wallet',
        'network'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
