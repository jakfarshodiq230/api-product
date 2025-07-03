<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'address',
        'city',
        'state',
        'state_code',
        'postal_code',
        'country'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function coordinates()
    {
        return $this->hasOne(CompanyCoordinate::class);
    }
}
