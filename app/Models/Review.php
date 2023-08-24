<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'appointment_id',
        'user_id',
        'rating',
        'review',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
