<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'category',
        'description',
        'cost_price',
        'selling_price',
        'quantity_in_stock',
        'low_stock_threshold',
        'unit_of_measure',
    ];

    protected function casts(): array
    {
        return [
            'cost_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
            'quantity_in_stock' => 'decimal:3',
            'low_stock_threshold' => 'decimal:3',
        ];
    }
}
