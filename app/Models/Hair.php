<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hair extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'color',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
