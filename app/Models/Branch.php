<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;
    protected $guarded = [];


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
                    'capital',
                ],
            ]
        ],
        'company' => [
            'table' => [
                'label' => 'Company',
                'columns' => [
                    'company.name',
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

}
