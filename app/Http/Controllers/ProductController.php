<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = Product::class;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $model = new $this->Model;
        $this->authorize($model->getTable() . '.store', auth()->user());
        $item = $this->Model::create($request->all());
        if( isset($item->id) && $request->filled('parameters')){
            $parameters = [];
            foreach($request->get('parameters') as $idParam => $paramValue){
                if($paramValue === "") continue;
                $parameters[] = [
                    'category_parameter_id' => Str::after($idParam, '_'),
                    'value' => $paramValue,
                ];
            }
            if(!empty($parameters)) $item->CategoryParameters()->sync($parameters);
        }
        return sendResponse($item, 'A new ' . class_basename($model) . ' has been created');
    }

     /**
     * Display the specified resource.
     */
    public function show( Request $request, $id)
    {
        $model = new $this->Model;
        $this->authorize($model->getTable() . '.show', auth()->user());
        $item = $this->getData($request, false, $id, false);
        return sendResponse($item, 'show');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = new $this->Model;
        $this->authorize($model->getTable() . '.update', auth()->user());
        $item = $this->Model::findOrFail($id);
        $item->update($request->all());
        if( isset($item->id) && $request->filled('parameters')){
            $parameters = [];
            foreach($request->get('parameters') as $idParam => $paramValue){
                $parameters[] = [
                    'category_parameter_id' => Str::after($idParam, '_'),
                    'value' => $paramValue,
                ];
            }
            if(!empty($parameters)) $item->CategoryParameters()->sync($parameters);
        }
        return sendResponse($item, 'update');
    }


}
