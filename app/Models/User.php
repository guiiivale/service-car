<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\UserTypes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type_id',
        'company_category_id',
        'reset_password_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'reset_password_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    public function companyCategory()
    {
        return $this->belongsTo(CompanyCategory::class, 'company_category_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_user')->withPivot('value', 'duration', 'description');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function scopeCompanies($query)
    {
        return $query->where('user_type_id', UserTypes::COMPANY_ID)->with('userType', 'companyCategory', 'services', 'addresses');
    }

    public function scopeUsers($query)
    {
        return $query->where('user_type_id', UserTypes::USER_ID)->with('userType', 'companyCategory', 'vehicles', 'addresses');
    }

    public function scopeEverything($query)
    {
        return $query->with('userType', 'companyCategory', 'services', 'vehicles', 'addresses');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'company_id');
    }

    public function userReviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'company_id');
    }

    public function userAppointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }
}