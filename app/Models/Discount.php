<?php

namespace App\Models;

use App\Traits\CreatedUpdatedDeletedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory, SoftDeletes;
    use CreatedUpdatedDeletedBy;

    protected $guarded = [];
    protected $fillable = [
        "name",
        "all_customer",
        "all_center",
        "start_date",
        "end_date",
        "type",
        "value",
        "minimum_qty",
        "maximum_qty",
        "days",
        "is_active",
    ];

    public $fieldsColumns = [

        'id' => [],
        'name' => [
            'table' => [
                'label' => 'name',
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
        'start_date' => [
            'table' => [
                'label' => 'start date',
                'columns' => [
                    'start_date',
                ],
            ],
            'filter' => [
                'type' => 'daterange',
                'columns' => [
                    'start' => 'start_date',
                    'end' => 'start_date'
                ],
            ]
        ],
        'end_date' => [
            'table' => [
                'label' => 'end date',
                'columns' => [
                    'end_date',
                ],
            ],
            'filter' => [
                'type' => 'daterange',
                'columns' => [
                    'start' => 'end_date',
                    'end' => 'end_date'
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

    public function discountCustomers(){
        return $this->hasMany(DiscountCustomer::class);
    }

    public function discountArticles(){
        return $this->hasMany(DiscountArticle::class);
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'object', 'discount_articles');
    }

    public function packs()
    {
        return $this->morphedByMany(Pack::class, 'object', 'discount_articles');
    }

    public function forfaits()
    {
        return $this->morphedByMany(Forfait::class, 'object', 'discount_articles');
    }

    public function saveArticles($data = [], $model){
        $this->discountArticles()->where('object_type',$model)->delete();
        $dataToSave = [];
        foreach($data as $dt){
            $dataToSave[] = [
                'discount_id' => $this->id,
                'object_type' => $model,
                'object_id' => $dt['id'],
            ];
        }
        // $this->discountArticles->sync($dataToSave);
        DiscountArticle::upsert($dataToSave, ['discount_id', 'object_type', 'object_id']);
    }

    public function discountCenters(){
        return $this->hasMany(DiscountCenter::class);
    }

    public function saveCustomers( $customers = [] ){
        $this->discountCustomers()->delete();
        $saveCustomers = [];
        foreach ($customers as $customer_id){
            $saveCustomers[] = [
                'discount_id' => $this->id,
                'customer_id' => $customer_id
            ];
        }
        DiscountCustomer::upsert($saveCustomers, ['discount_id', 'customer_id']);
    }

    public function syncCustomers() {
        $existCustomers = $this->discountCustomers()->pluck('customer_id')->toArray() ?? null;
        if($existCustomers) {
            $customers = Customer::select('id as customer_id')->whereNotIn('id', $existCustomers)->get()->toArray() ?? null;
            if($customers) $this->discountCustomers()->createMany($customers);
        }
        else{
            $customers = Customer::select('id as customer_id')->get()->toArray() ?? null;
            if($customers) $this->discountCustomers()->createMany($customers);
        }
    }

    public function syncCenters() {
        $existCenters = $this->discountCenters()->pluck('center_id')->toArray() ?? null;
        if($existCenters) {
            $centers = Center::select('id as center_id')->whereNotIn('id', $existCenters)->get()->toArray() ?? null;
            if($centers) $this->discountCenters()->createMany($centers);
        }
        else{
            $centers = Center::select('id as center_id')->get()->toArray() ?? null;
            if($centers) $this->discountCenters()->createMany($centers);
        }
    }

    public function saveCenters( $centers = [] ){
        $this->discountCenters()->delete();
        $saveCenters = [];
        foreach ($centers as $center_id){
            $saveCenters[] = [
                'discount_id' => $this->id,
                'center_id' => $center_id
            ];
        }
        DiscountCenter::upsert($saveCenters, ['discount_id', 'center_id']);
    }
}
