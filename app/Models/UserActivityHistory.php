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
        'appointment_id',
        'is_finished',
        'value',
    ];

    public function serviceProblems()
    {
        return $this->hasMany(ServiceProblem::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
