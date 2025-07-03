<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCoordinate extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_address_id',
        'lat',
        'lng'
    ];

    public function companyAddress()
    {
        return $this->belongsTo(CompanyAddress::class);
    }
}
