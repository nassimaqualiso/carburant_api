<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePriceCenter extends Model
{
    use HasFactory;
    public $fillable = [ 'sale_price_id', 'center_id' ];
}
