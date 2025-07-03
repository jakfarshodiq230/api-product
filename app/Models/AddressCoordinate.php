<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressCoordinate extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_id',
        'lat',
        'lng'
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
