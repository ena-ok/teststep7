<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if ($keyword) {
            return $query->where('name', 'LIKE', "%{$keyword}%");
        }
        return $query;
    }


    public function scopeFilterByCompany(Builder $query, ?int $companyId): Builder
    {
        if (! empty($companyId)) {
            $query->where('company_id', $companyId);
        }

        return $query;
    }
}
