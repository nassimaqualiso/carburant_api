<?php

namespace App\Models;

use App\Models\Pack;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pack_id',
        'product_id',
        'quantity',

    ];

    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
