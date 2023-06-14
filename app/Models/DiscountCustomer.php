<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCustomer extends Model
{
    use HasFactory;
    public $fillable = [ 'discount_id', 'customer_id' ];
}
