<?php

namespace App\Models;

use App\Models\Nature;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubNature extends Model
{
    use HasFactory, SoftDeletes;


    protected $guarded = [];
    protected $fillable = [
        'name',

    ];

    public $fieldsColumns = [

        'id' => [
            'table' => [
                'label' => 'ID',
                'columns' => [
                    'id',
                ],
            ],

        ],
        'name' => [
            'table' => [
                'label' => 'Name',
                'columns' => [
                    'name',
                ],
                'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'name',
                ],
            ]
        ],




    ];

    public function categories()
    {

        return $this->belongsToMany(ProductCategory::class, 'subnature_category');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
