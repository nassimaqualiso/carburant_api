<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCenter extends Model
{
    use HasFactory;
    public $fillable = [ 'discount_id', 'center_id' ];
}
