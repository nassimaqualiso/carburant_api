<?php

namespace App\Models;

use App\Traits\CreatedUpdatedDeletedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forfait extends Model
{
    use HasFactory, SoftDeletes;
    use CreatedUpdatedDeletedBy;

    protected $guarded = [];
    protected $fillable = [
        'reference',
        'name',
        'price',
        'data_car_id',
        'nature_id',
        'sub_nature_id',
    ];

    public function salePrices()
    {
        return $this->morphToMany(SalePrice::class, 'object', 'sale_price_articles')->withPivot('price');
    }

    public $fieldsColumns = [

        'id' => [],
        'reference' => [
            'table' => [
                'label' => 'Reference',
                'columns' => [
                    'reference',
                ],
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
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'price',
                ],
            ]
        ],
        'nature' => [
            'table' => [
                'label' => 'Nature',
                'columns' => [
                    'nature.name',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'nature.name',
                ],
            ]
        ],
        'subNature' => [
            'table' => [
                'label' => 'sub nature',
                'columns' => [
                    'subNature.name',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'subNature.name',
                ],
            ]
        ],
        'vehicle_brand' => [
            'table' => [
                'label' => 'Brand',
                'columns' => [
                    'dataCar.vehicleBrand.name',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'dataCar.vehicleBrand.name',
                ],
            ]
        ],
        'vehicle_model' => [
            'table' => [
                'label' => 'Model',
                'columns' => [
                    'dataCar.vehicleModel.name',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'dataCar.vehicleModel.name',
                ],
            ]
        ],
        'vehicle_energy' => [
            'table' => [
                'label' => 'Energy',
                'columns' => [
                    'dataCar.vehicleEnergy.name',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'dataCar.vehicleEnergy.name',
                ],
            ]
        ],
        'vehicle_period' => [
            'table' => [
                'label' => 'Period',
                'columns' => [
                    'dataCar.vehiclePeriod.name',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'dataCar.vehiclePeriod.name',
                ],
            ]
        ],
        'vehicle_length' => [
            'table' => [
                'label' => 'Length',
                'columns' => [
                    'dataCar.vehicleLength.name',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'dataCar.vehicleLength.name',
                ],
            ]
        ],
        'created_at' => [
            'table' => [
                'label' => 'creation date',
                'columns' => [
                    'created_at',
                ],
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

    public function dataCar()
    {
        return $this->belongsTo(DataCar::class);
    }
    public function nature()
    {
        return $this->belongsTo(Nature::class);
    }
    public function subNature()
    {
        return $this->belongsTo(SubNature::class);
    }
}
