<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'city',
        'state',
        'state_code',
        'postal_code',
        'country'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coordinates()
    {
        return $this->hasOne(AddressCoordinate::class);
    }
}
