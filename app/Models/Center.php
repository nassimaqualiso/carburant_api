<?php

namespace App\Models;

// use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Center extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public $companies = Company::pluck('name', 'id')->toArray();
    public function optionsCompanies()
    {
        return Company::pluck('name', 'id')->toArray();
    }

    public $fieldsColumns = [
        'id' => [],
        'name' => [
            'table' => [
                'label' => 'Name',
                'columns' => [
                    'name',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'name',
                ],
            ]
        ],
        'company_id' => [
            'table' => [
                'label' => 'company',
                'columns' => [
                    'company.name',
                ],
            ],
            'filter' => [
                'type' => 'exact',
                'columns' => [
                    'company.id',
                ],
                'options' => 'optionsCompanies'
            ]
        ],

        'idfiscale' => [
            'table' => [
                'label' => 'Id fiscale',
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
        'rc' => [
            'table' => [
                'label' => 'Trade registery',
                'columns' => [
                    'idfiscale',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'rc',
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
        'payment_mode' => [
            'table' => [
                'label' => 'payment mode',
                'columns' => [
                    'payment_mode',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'payment_mode',
                ],
            ]
        ],
        'address' => [
            'table' => [
                'label' => 'Address',
                'columns' => [
                    'address',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'address',
                ],
            ]
        ],

        'phone1' => [
            'table' => [
                'label' => 'phone1',
                'columns' => [
                    'phone1',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'phone1',
                ],
            ]
        ],
        'phone2' => [
            'table' => [
                'label' => 'phone2',
                'columns' => [
                    'phone2',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'phone2',
                ],
            ]
        ],
        'manager_phone' => [
            'table' => [
                'label' => 'manager_phone',
                'columns' => [
                    'manager_phone',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'manager_phone',
                ],
            ]
        ],
        'manager' => [
            'table' => [
                'label' => 'manager',
                'columns' => [
                    'manager',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'manager',
                ],
            ]
        ],
        'manager_email' => [
            'table' => [
                'label' => 'manager_email',
                'columns' => [
                    'manager_email',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'manager_email',
                ],
            ]
        ],
        'email' => [
            'table' => [
                'label' => 'email',
                'columns' => [
                    'email',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'email',
                ],
            ]
        ],
        'created_at' => [
            'table' => [
                'label' => 'created at',
                'columns' => [
                    'created_at',
                ],
                'split_with' => ' @ ',
                // 'format' => '%M %d %Y',
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


    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_center');
    }
}
