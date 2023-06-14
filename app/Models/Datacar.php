<?php

namespace App\Models;

use App\Traits\CreatedUpdatedDeletedBy;
use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes,
    Factories\HasFactory
};

class DataCar extends Model
{
    use HasFactory, SoftDeletes;
    use CreatedUpdatedDeletedBy;

    protected $guarded = [];
    protected $fillable = [
        'vehicle_brand_id',
        'vehicle_model_id',
        'vehicle_energy_id',
        'vehicle_period_id',
        'vehicle_length_id',
    ];

    public $fieldsColumns = [

        'id' => [],
        'vehicle_brand_name' => [
            'table' => [
                'label' => 'Brand',
                'columns' => [
                    'vehicleBrand.name',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'vehicleBrand.name',
                ],
            ]
        ],
        'vehicle_model_name' => [
            'table' => [
                'label' => 'Model',
                'columns' => [
                    'vehicleModel.name',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'vehicleModel.name',
                ],
            ]
        ],
        'vehicle_energy_name' => [
            'table' => [
                'label' => 'Energy',
                'columns' => [
                    'vehicleEnergy.name',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'vehicleEnergy.name',
                ],
            ]
        ],
        'vehicle_period_name' => [
            'table' => [
                'label' => 'Period',
                'columns' => [
                    'vehiclePeriod.name',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'vehiclePeriod.name',
                ],
            ]
        ],
        'vehicle_length_name' => [
            'table' => [
                'label' => 'Length',
                'columns' => [
                    'vehicleLength.name',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'vehicleLength.name',
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

    public function vehicleBrand()
    {
        return $this->belongsTo(VehicleBrand::class);
    }
    public function vehicleModel()
    {
        return $this->belongsTo(vehicleModel::class);
    }
    public function vehicleEnergy()
    {
        return $this->belongsTo(vehicleEnergy::class);
    }
    public function vehiclePeriod()
    {
        return $this->belongsTo(vehiclePeriod::class);
    }
    public function vehicleLength()
    {
        return $this->belongsTo(vehicleLength::class);
    }
}
