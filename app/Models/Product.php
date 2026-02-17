<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'price', 
        'stock', 
        'company_id', 
        'comment', 
        'img_path',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where('name', 'LIKE', "%{$keyword}%");
        }
        return $query;
    }


    public function scopeFilterByCompany($query, $companyId)
    {
        if (! empty($companyId)) {
            $query->where('company_id', $companyId);
        }

        return $query;
    }
}
