<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Customer;
use App\Models\Forfait;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Discount;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DiscountController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = Discount::class;
    }

    public function getListCustomers(){
        $FieldsCols = ['last_name', 'first_name', 'corporate_name'];
        foreach ($FieldsCols as $nameCol) {
            $formatFieldsCols[] = "COALESCE(" . $nameCol . ",'')";
        }
        $splitWith = ' ';
        $data = Customer::select(
                            DB::raw("TRIM(CONCAT( " . implode(",'" . $splitWith . "',", $formatFieldsCols) . " )) as label"),
                            'id as value',
                            'type as type_customer'
                        )
                        ->get();
        $formatData = [];
        foreach( $data as $key => $options ) {
            $formatData[] = [
                'label' => $key,
                'options' => $options
            ];
        }
        return sendResponse($data, 'success');
    }
    public function getListCenters(){
        $data = Center::select(
                            'id as value',
                            'name as label',
                            'company_id'
                        )
                        ->with('company')
                        // ->groupBy('type_customer','value','label')
                        ->get();
                        // ->groupBy('type_customer');
        return sendResponse($data, 'success');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
            $model = new Discount();
            $this->authorize($model->getTable() . '.store', auth()->user());

            $item = new $this->Model;
            $item->fill($request->all());
            $item->all_customer = ($request->filled('customers') && !empty($request->get('customers'))) ? false : true;
            $item->all_center = ($request->filled('centers') && !empty($request->get('centers'))) ? false : true;

            if($item->save()) {
                if($item->all_customer) $item->syncCustomers();
                else $item->saveCustomers($request->get('customers'));

                if($item->all_center) $item->syncCenters();
                else $item->saveCenters($request->get('centers'));
            }
            return sendResponse($item, 'A new ' . class_basename($model) . ' has been created');
        } catch (\Throwable $th) {
            return sendError($th->getMessage(),);
        }
    }

     /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $model = new $this->Model;
        $this->authorize($model->getTable() . '.show', auth()->user());
        $item = $this->Model::with([
                    'discountCenters',
                    'discountCustomers',
                    'discountArticles',
                    'products:id,name,code',
                    'packs:id,name,reference',
                    'forfaits:id,name,reference',
                ])->findOrFail($id);
        return sendResponse($item, 'show');
    }

     /**
     * update a newly created resource in storage.
     */
    public function update(Request $request, $id)
    {
        try
        {
            $model = new Discount();
            $this->authorize($model->getTable() . '.store', auth()->user());

            $item = $this->Model::findOrFail($id);
            $item->fill($request->all());
            $item->all_customer = ($request->filled('customers') && !empty($request->get('customers'))) ? false : true;
            $item->all_center = ($request->filled('centers') && !empty($request->get('centers'))) ? false : true;

            if($item->save()) {
                if($item->all_customer) $item->syncCustomers();
                else $item->saveCustomers($request->get('customers'));

                if($item->all_center) $item->syncCenters();
                else $item->saveCenters($request->get('centers'));
                if($request->filled('products') && !empty($request->get('products')))
                    $item->products()->sync($request->get('products'));
                    // $item->saveArticles($request->get('products'), 'App\Product');

                if($request->filled('packs') && !empty($request->get('packs')))
                    $item->packs()->sync($request->get('packs'));

                if($request->filled('forfaits') && !empty($request->get('forfaits')))
                    $item->forfaits()->sync($request->get('forfaits'));
            }
            return sendResponse($item, ' ' . class_basename($model) . ' has been updated');
        } catch (\Throwable $th) {
            return sendError($th->getMessage(),);
        }
    }

    public function getProductCategories(){
        $data = ProductCategory::pluck('name', 'id');
        return sendResponse($data, 'success');
    }

    public function getArticles(Request $request){
        if(!$request->filled('type_articles') OR empty($request->get('type_articles'))) return sendResponse([], 'success');
        $data = ['eeee'];
        switch($request->get('type_articles')){
            case 'product':
                $data = Product::when($request->filled('name') && !empty($request->get('name')), function($query) use($request){
                            return $query->where('name', 'Like', '%' . $request->get('name') . '%');
                        })
                        ->when(
                            $request->filled('categories')
                            &&
                            !empty($request->get('categories')
                            &&
                            Schema::hasColumn((new Product)->getTable(), 'category_id')
                        ), function($query) use($request){
                            return $query->where('category_id', $request->get('categories'));
                        })
                        ->orWhere('id', null)
                        ->select(
                            'id',
                            'name',
                            'code as reference'
                        )
                        ->get();
                break;
            case 'pack':
                $data = Product::when($request->filled('name') && !empty($request->get('name')), function($query) use($request){
                            return $query->where('name', 'Like', '%' . $request->get('name') . '%');
                        })
                        ->orWhere('id', null)
                        ->select(
                            'id',
                            'name',
                            'reference'
                        )
                        ->get();
                break;
            case 'forfait':
                $data = Forfait::when($request->filled('name') && !empty($request->get('name')), function($query) use($request){
                            return $query->where('name', 'Like', '%' . $request->get('name') . '%');
                        })
                        ->orWhere('id', null)
                        ->select(
                            'id',
                            'name',
                            'reference'
                        )
                        ->get();
                break;
        }
        return sendResponse($data, 'success');
    }
}

