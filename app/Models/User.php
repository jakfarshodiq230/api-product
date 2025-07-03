<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'maiden_name',
        'age',
        'gender',
        'email',
        'phone',
        'username',
        'password',
        'birth_date',
        'image',
        'blood_group',
        'height',
        'weight',
        'eye_color',
        'ip',
        'mac_address',
        'university',
        'ein',
        'ssn',
        'user_agent',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function hair()
    {
        return $this->hasOne(Hair::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function bank()
    {
        return $this->hasOne(Bank::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function crypto()
    {
        return $this->hasOne(Crypto::class);
    }
}
