<?php

namespace App\Models;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\CategoryParameterOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryParameter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'type', 'product_category_id'];
    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function options()
    {
        return $this->hasMany(CategoryParameterOption::class);
    }


    public function products()
    {

        return $this->belongsToMany(Product::class, 'category_parameter_product');
    }
}
