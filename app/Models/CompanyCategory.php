<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'company_categories';

    protected $fillable = [
        'title',
        'slug',
        'description',
    ];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_company_category');
    }
}
