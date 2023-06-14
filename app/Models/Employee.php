<?php

namespace App\Models;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $fillable = [
        'id',
        'user_id',
        'company_id',
        'CIN',
        'CNSS',
        'first_name',
        'last_name',
        'sex',
        'birth_date',
        'birth_place',
        'email',
        'phone',
        'address',
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
        'first_name' => [
            'table' => [
                'label' => 'Firstname',
                'columns' => [
                    'first_name',
                ],
                'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'first_name',
                ],
            ]
        ],
        'last_name' => [
            'table' => [
                'label' => 'Last Name',
                'columns' => [
                    'last_name',
                ],
                'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'last_name',
                ],
            ]
        ],
        'CIN' => [
            'table' => [
                'label' => 'CIN',
                'columns' => [
                    'CIN',
                ],
                'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'CIN',
                ],
            ]
        ],
        'CNSS' => [
            'table' => [
                'label' => 'CNSS',
                'columns' => [
                    'CNSS',
                ],
                'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'CNSS',
                ],
            ]
        ],
        'email' => [
            'table' => [
                'label' => 'Email',
                'columns' => [
                    'email',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'capital',
                ],
            ]
        ],
        'phone' => [
            'table' => [
                'label' => 'Phone',
                'columns' => [
                    'phone',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'phone',
                ],
            ]
        ],
        'sex' => [
            'table' => [
                'label' => 'SEX',
                'columns' => [
                    'sex',
                ],
                // 'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'select',
                'columns' => [
                    'sex',
                ],
                'options' => 'sexOptions'
            ]
        ],

        'birth_date' => [
            'table' => [
                'label' => 'Birth date',
                'columns' => [
                    'birth_date',
                ],
                'split_with' => ' @ ',
                // 'format' => '%M %d %Y'
            ],
            'filter' => [
                'type' => 'daterange',
                'columns' => [
                    'start' => 'birth_date',
                    'end' => 'birth_date'
                ],
            ]
        ],

        'birth_place' => [
            'table' => [
                'label' => 'Birth place',
                'columns' => [
                    'birth_place',
                ],
                'split_with' => ' @ ',
                // 'format' => '%M %d %Y'
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'first_name'

                ],
            ]
        ],
        'company_id' => [
            'table' => [
                'label' => 'Company',
                'columns' => [
                    'company_id'
                ],

            ],

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function centers()
    {
        return $this->belongsToMany(Center::class, 'employee_center');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sexOptions()
    {
        return [
            'M' => 'Male',
            'F' => 'Female',
        ];
    }

}
