<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'service_categories';

    protected $fillable = [
        'title',
        'slug',
        'description',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
