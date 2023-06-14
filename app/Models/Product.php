<?php

namespace App\Models;

use App\Models\Pack;
use App\Models\PackItem;
use App\Models\ProductCategory;
use App\Models\CategoryParameter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $fillable = [
        'name',
        'code',
        'barcode_symbology',
        'is_active',
        'product_category_id',
        'type',
        'cost',
        'price',
        'qty',
        'alert_quantity',
        'image',
        'product_details'
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
        'name' => [
            'table' => [
                'label' => 'name',
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
        'product_category_id' => [
            'table' => [
                'label' => 'Category',
                'columns' => [
                    'productCategory.name',
                ],
            ],
            'filter' => [
                'type' => 'exact',
                'columns' => [
                    'category.id',
                ],
                'options' => 'optionsCategories'
            ]
        ],
        'code' => [
            'table' => [
                'label' => 'code',
                'columns' => [
                    'code',
                ],
                'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'code',
                ],
            ]
        ],
        'barcode_symbology' => [
            'table' => [
                'label' => 'barcode symbology',
                'columns' => [
                    'barcode_symbology',
                ],
                'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'barcode_symbology',
                ],
            ]
        ],
        'type' => [
            'table' => [
                'label' => 'type',
                'columns' => [
                    'type',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'select',
                'columns' => [
                    'type',
                ],
                'options' => 'typeOptions'
            ]
        ],

        'cost' => [
            'table' => [
                'label' => 'cost',
                'columns' => [
                    'cost',
                ],
                'split_with' => ' @ ',
            ],

        ],
        'price' => [
            'table' => [
                'label' => 'price',
                'columns' => [
                    'price',
                ],
                // 'split_with' => ' @ ',
            ],

        ],
        'qty' => [
            'table' => [
                'label' => 'quantity',
                'columns' => [
                    'qty',
                ],
                // 'split_with' => ' @ ',
            ],

        ],
        'alert_quantity' => [
            'table' => [
                'label' => 'alert_quantity',
                'columns' => [
                    'alert_quantity',
                ],
                'split_with' => ' @ ',
                // 'format' => '%M %d %Y'
            ],

        ],
        'image' => [
            'table' => [
                'label' => 'image',
                'columns' => [
                    'image',
                ],
                'split_with' => ' @ ',
            ],
        ],

        'product_details' => [
            'table' => [
                'label' => 'product details',
                'columns' => [
                    'product_details',
                ],
                'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'product_details',
                ],
            ]
        ],
        'is_active' => [
            'table' => [
                'label' => 'status',
                'columns' => [
                    'is_active',
                ],
                'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'boolean',
                'columns' => [
                    'status',
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

    public function productCategory()
    {

        return $this->belongsTo(ProductCategory::class);

    }

    public function typeOptions()
    {
        return [
            'standard' => 'Standard',
            'Service' => 'Service',
        ];
    }

    public function CategoryParameters()
    {
        return $this->belongsToMany(CategoryParameter::class, 'category_parameter_product')->withPivot('value');
    }



    public function packs()
    {
        return $this->belongsToMany(Pack::class, 'pack_product');
    }

    public function PackItems()
    {
        return $this->hasMany(PackItem::class);
    }
    public function optionsCategories()
    {
        return ProductCategory::pluck('name', 'id')->toArray();
    }
}
