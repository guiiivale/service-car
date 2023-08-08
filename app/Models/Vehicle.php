<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'model',
        'make', // 'make' is the same as 'brand'
        'year',
        'color',
        'plate',
        'mileage',
        'fuel_type',
        'photo',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
