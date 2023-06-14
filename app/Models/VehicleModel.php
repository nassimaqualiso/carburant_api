<?php

namespace App\Models;

use App\Models\VehicleBrand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];


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
        'vehicle_brand_id' => [
            'table' => [
                'label' => 'Brand',
                'columns' => [
                    'vehicleBrand.name',
                ],
            ],
            'filter' => [
                'type' => 'exact',
                'columns' => [
                    'brand.id',
                ],
                'options' => 'optionsBrands'
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

    public function vehicleBrand()
    {
        return $this->belongsTo(VehicleBrand::class);


    }

    public function optionsBrands()
    {
        return VehicleBrand::pluck('name', 'id')->toArray();
    }
}
