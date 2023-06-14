<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $fillable = [
        'id',
        'corporate_name',
        'type',
        'company_id',
        'user_id',
        'trade_registry',
        'ICE',
        'patent',
        'idfiscale',
        'CIN',
        'first_name',
        'last_name',
        'email',
        'phone',
        'sex',
        'manager_phone',
        'manager_email',
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
        'type' => [
            'table' => [
                'label' => 'Type',
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

        'corporate_name' => [
            'table' => [
                'label' => 'Corprate name',
                'columns' => [
                    'corporate_name',
                ],
                'split_with' => ' @ ',
            ],
            'filter' => [
                'type' => 'like',
                'columns' => [
                    'corporate_name',
                ],
            ]
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
                    'email',
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
                'label' => 'update date',
                'columns' => [
                    'updated_at',
                ],
                'split_with' => ' @ ',
                // 'format' => '%M %d %Y'
            ],
            'filter' => [
                'type' => 'date',
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


    public function sexOptions()
    {
        return [
            'M' => 'Male',
            'F' => 'Female',
        ];
    }

    public function typeOptions()
    {
        return [
            'particular' => 'Particular',
            'company' => 'Company',
        ];
    }

}
