<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserActivityHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_activity_histories';

    protected $fillable = [
        'user_id',
        'service_id',
        'car_id',
        'company_id',
        'value',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function serviceProblems()
    {
        return $this->hasMany(ServiceProblem::class);
    }
}
