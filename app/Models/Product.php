<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'category_id',
        'code',
        'name',
        'unit',
        'price',
        'stock',
        'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getHargaRupiahAttribute(): string
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }

    public function transactionDetails(): HasMany
{
    return $this->hasMany(TransactionDetail::class);
}

    
}