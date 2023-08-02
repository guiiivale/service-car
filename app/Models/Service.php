<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    public function users()
    {
        return $this->belongsToMany(User::class, 'service_user');
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
