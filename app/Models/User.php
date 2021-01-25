<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $withCount = ['movies'];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function scopeWherSearch($query,$search)
    {
        return $query->when($search , function ($q) use ($search){
            return $q->where('name', 'like',"%$search%");
        });
    }

    public function scopeWhereRole($query ,$role_name)
    {
        return $query->whereHas('roles',function ($q) use ($role_name) {
            return $q->whereIn('name',(array)$role_name);
        });
    }
    public function scopeWhereRoleNot($query ,$role_name)
    {
        return $query->whereHas('roles',function ($q) use ($role_name) {
            return $q->whereNotIn('name',(array)$role_name);
        });
    }

    // relations --------------------------
    public function movies(){
        return $this->belongsToMany(Movie::class , 'user_movie');
    }
}
