<?php

namespace App\Models;

use App\Models\CategoryParameter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryParameterOption extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'category_parameter_id'];
    public function parameter()
    {
        return $this->belongsTo(CategoryParameter::class);
    }

}
