<?php

namespace App\Models;

use App\Models\Product;
use App\Models\SubNature;
use App\Models\CategoryParameter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes;


    protected $guarded = [];

    protected $fillable = ['name'];

    public $fieldsColumns = [
        'id' => [
            'table' => [
                'label' => 'ID',
                'columns' => [
                    'id',
                ],
                'split_with' => ' @ ',
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

        'created_at' => [
            'table' => [
                'label' => 'creation date',
                'columns' => [
                    'created_at',
                ],
                'split_with' => ' @ ',
                // 'format' => '%M %d %Y'
            ],
            'filter' => [
                'type' => 'date',
                'columns' => [
                    'start' => 'created_at',
                    'end' => 'created_at'
                ],
            ]
        ],
        'updated_at' => [
            'table' => [
                'label' => 'udapte date',
                'columns' => [
                    'updated_at',
                ],
                'split_with' => ' @ ',
                // 'format' => '%M %d %Y'
            ],
            'filter' => [
                'type' => 'daterange',
                'columns' => [
                    'start' => 'updated_at',
                    'end' => 'updated_at'
                ],
            ]
        ],
    ];

    public function products()
    {

        return $this->hasMany(Product::class);
    }

    public function parameters()
    {
        return $this->hasMany(CategoryParameter::class);
    }

    public function subNatures()
    {
        return $this->belongsToMany(SubNature::class);
    }

    public function natures()
    {
        return $this->belongsToMany(Nature::class);
    }



}
