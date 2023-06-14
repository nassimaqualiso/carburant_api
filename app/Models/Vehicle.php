<?php

namespace App\Models;

use App\Helpers\EnumLists;
use App\Traits\CreatedUpdatedDeletedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;
    use CreatedUpdatedDeletedBy;

    protected $guarded = [];
    protected $fillable = [
        'customer_id',
        'registration_car',
        'chassis_no',
        'date_mce',
        'vehicle_brand_id',
        'vehicle_model_id',
        'vehicle_energy_id',
        'vehicle_period_id',
        'vehicle_length_id',
    ];

    public $fieldsColumns = [

        'id' => [],
        'customer_id' => [
            'table' => [
                'label' => 'Customer',
                'columns' => [
                    'customer.first_name',
                    'customer.last_name',
                    'customer.corporate_name',
                ],
                'split_with' => ' ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'customer.first_name',
                    'customer.last_name',
                    'customer.corporate_name',
                ],
            ]
        ],
        'customer_type' => [
            'table' => [
                'label' => 'Customer type',
                'columns' => [
                    'customer.type',
                ],
            ],
            'filter' => [
                'type' => 'select',
                'columns' => [
                    'customer.type',
                ],
                'options' => 'typeCustomers'
            ]
        ],
        'registration_car' => [
            'table' => [
                'label' => 'Registration car',
                'columns' => [
                    'registration_car',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'registration_car',
                ],
            ]
        ],
        'chassis_no' => [
            'table' => [
                'label' => 'Chassis No',
                'columns' => [
                    'chassis_no',
                ],
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'chassis_no',
                ],
            ]
        ],
        'date_mce' => [
            'table' => [
                'label' => 'Date mce',
                'columns' => [
                    'date_mce',
                ],
            ],
            'filter' => [
                'type' => 'daterange',
                'columns' => [
                    'start' => 'date_mce',
                    'end' => 'date_mce'
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
                'type' => 'like',
                'columns' => [
                    'vehicleBrand.name',
                ],
            ]
        ],
        'vehicle_model_id' => [
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
        'vehicle_energy_id' => [
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
        'vehicle_period_id' => [
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
        'vehicle_length_id' => [
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

    public function typeCustomers() {
        return convert_to_associative_array(EnumLists::Customer_TYPES) ?? [];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
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
