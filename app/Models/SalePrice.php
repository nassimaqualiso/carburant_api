<?php

namespace App\Models;

use App\Traits\CreatedUpdatedDeletedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalePrice extends Model
{
    use HasFactory, SoftDeletes;
    use CreatedUpdatedDeletedBy;

    protected $guarded = [];
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'all_customer',
        'all_center',
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

    public function salePriceCustomers(){
        return $this->hasMany(SalePriceCustomer::class);
    }

    public function salePriceArticles(){
        return $this->hasMany(SalePriceArticle::class);
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'object', 'sale_price_articles')->withPivot('price');
    }

    public function packs()
    {
        return $this->morphedByMany(Pack::class, 'object', 'sale_price_articles')->withPivot('price');
    }

    public function forfaits()
    {
        return $this->morphedByMany(Forfait::class, 'object', 'sale_price_articles')->withPivot('price');
    }

    public function saveArticles($data = [], $model){
        $this->salePriceArticles()->where('object_type',$model)->delete();
        $dataToSave = [];
        foreach($data as $dt){
            $dataToSave[] = [
                'sale_price_id' => $this->id,
                'object_type' => $model,
                'object_id' => $dt['id'],
                'price' => $dt['new_price'],
            ];
        }
        // $this->salePriceArticles->sync($dataToSave);
        SalePriceArticle::upsert($dataToSave, ['sale_price_id', 'object_type', 'object_id', 'price']);
    }

    public function salePriceCenters(){
        return $this->hasMany(SalePriceCenter::class);
    }

    public function saveCustomers( $customers = [] ){
        $this->salePriceCustomers()->delete();
        $saveCustomers = [];
        foreach ($customers as $customer_id){
            $saveCustomers[] = [
                'sale_price_id' => $this->id,
                'customer_id' => $customer_id
            ];
        }
        SalePriceCustomer::upsert($saveCustomers, ['sale_price_id', 'customer_id']);
    }

    public function syncCustomers() {
        $existCustomers = $this->salePriceCustomers()->pluck('customer_id')->toArray() ?? null;
        if($existCustomers) {
            $customers = Customer::select('id as customer_id')->whereNotIn('id', $existCustomers)->get()->toArray() ?? null;
            if($customers) $this->salePriceCustomers()->createMany($customers);
        }
        else{
            $customers = Customer::select('id as customer_id')->get()->toArray() ?? null;
            if($customers) $this->salePriceCustomers()->createMany($customers);
        }
    }

    public function syncCenters() {
        $existCenters = $this->salePriceCenters()->pluck('center_id')->toArray() ?? null;
        if($existCenters) {
            $centers = Center::select('id as center_id')->whereNotIn('id', $existCenters)->get()->toArray() ?? null;
            if($centers) $this->salePriceCenters()->createMany($centers);
        }
        else{
            $centers = Center::select('id as center_id')->get()->toArray() ?? null;
            if($centers) $this->salePriceCenters()->createMany($centers);
        }
    }

    public function saveCenters( $centers = [] ){
        $this->salePriceCenters()->delete();
        $saveCenters = [];
        foreach ($centers as $center_id){
            $saveCenters[] = [
                'sale_price_id' => $this->id,
                'center_id' => $center_id
            ];
        }
        SalePriceCenter::upsert($saveCenters, ['sale_price_id', 'center_id']);
    }
}
