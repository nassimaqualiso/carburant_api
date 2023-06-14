<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Center;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
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
        'capital' => [
            'table' => [
                'label' => 'Capital',
                'columns' => [
                    'capital',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'capital',
                ],
            ],

        ],
        'idfiscale' => [
            'table' => [
                'label' => 'Idfiscale',
                'columns' => [
                    'idfiscale',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'idfiscale',
                ],
            ]
        ],
        'cnss' => [
            'table' => [
                'label' => 'CNSS',
                'columns' => [
                    'cnsss',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'cnss',
                ],
            ]
        ],
        'trade_registry' => [
            'table' => [
                'label' => 'Trade registry',
                'columns' => [
                    'trade_registry',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'trade_registry',
                ],
            ]
        ],
        'patent' => [
            'table' => [
                'label' => 'Patent',
                'columns' => [
                    'patent',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'patent',
                ],
            ]
        ],
        'ice' => [
            'table' => [
                'label' => 'ICE',
                'columns' => [
                    'ice',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'ice',
                ],
            ]
        ],
        'dg' => [
            'table' => [
                'label' => 'DG',
                'columns' => [
                    'dg',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'dg',
                ],
            ]
        ],
        'assistance_contact' => [
            'table' => [
                'label' => 'Assistance contact',
                'columns' => [
                    'assistance_contact',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'assistance_contact',
                ],
            ]
        ],
        'service_contact' => [
            'table' => [
                'label' => 'Service contact',
                'columns' => [
                    'service_contact',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'service_contact',
                ],
            ]
        ],
        'nature' => [
            'table' => [
                'label' => 'Nature',
                'columns' => [
                    'nature',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'nature',
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
    ];


    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function centers()
    {
        return $this->hasMany(Center::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
