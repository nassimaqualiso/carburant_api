<?php

namespace App\Models;

use App\Models\PackItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pack extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $fillable = [
        'reference',
        'name',
        'price',
        'is_active'
    ];

    public function salePrices()
    {
        return $this->morphToMany(SalePrice::class, 'object', 'sale_price_articles')->withPivot('price');
    }

    public $fieldsColumns = [

        'id' => [
            'table' => [
                'label' => 'ID',
                'columns' => [
                    'id',
                ],
            ],

        ],
        'reference' => [
            'table' => [
                'label' => 'Reference',
                'columns' => [
                    'reference',
                ],
                'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'reference',
                ],
            ]
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
        'price' => [
            'table' => [
                'label' => 'Price',
                'columns' => [
                    'price',
                ],
                'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'price',
                ],
            ]
        ],
        'is_active' => [
            'filter' => [
                'type' => 'bool',
                'columns' => [
                    'is_active',
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
                'type' => 'datetimerange',
                'columns' => [
                    'start' => 'created_at',
                    'end' => 'created_at'
                ],
            ]
        ],
        'updated_at' => [
            'table' => [
                'label' => 'update date',
                'columns' => [
                    'updated_at',
                ],
                'split_with' => ' @ ',
                // 'format' => '%M %d %Y'
            ],
            'filter' => [
                'type' => 'datetimerange',
                'columns' => [
                    'start' => 'updated_at',
                    'end' => 'updated_at'
                ],
            ]
        ],
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'pack_product');
    }

    public function PackItems()
    {
        return $this->hasMany(PackItem::class);
    }

}
