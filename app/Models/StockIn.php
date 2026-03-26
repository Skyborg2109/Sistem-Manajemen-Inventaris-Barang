<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = ['product_id', 'quantity', 'date', 'supplier_name', 'notes'];

    protected $casts = [
        'date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
