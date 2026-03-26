<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $fillable = ['product_id', 'quantity', 'date', 'recipient_name', 'notes'];

    protected $casts = [
        'date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
