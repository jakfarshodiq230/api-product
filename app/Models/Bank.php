<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_expire',
        'card_number',
        'card_type',
        'currency',
        'iban'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
