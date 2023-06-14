<?php

namespace App\Http\Controllers;

use App\Models\CategoryParameterOption;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\CategoryParameter;

class ProductCategoryController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = ProductCategory::class;
    }

    public function update(Request $request, $id)
    {

        $category = ProductCategory::findOrFail($id);
        $category->fill($request->all());

        $categoryParameters = [];

        foreach ($request->parameters as $parameter) {
            $categoryParameter = CategoryParameter::create([
                'name' => $parameter['name'],
                'type' => $parameter['type'],
            ]);

            array_push($categoryParameters, $categoryParameter);
            $categoryParameterOptions = [];
            if (isset($parameter['options'])) {
                foreach ($parameter['options'] as $option) {
                    $categoryParameterOption = CategoryParameterOption::create([
                        'name' => $option['name'],
                    ]);

                    array_push($categoryParameterOptions, $categoryParameterOption);

                }

                $categoryParameter->options()->delete();
                $categoryParameter->options()->saveMany($categoryParameterOptions);
                $categoryParameter->save();

            }
        }
        $category->parameters()->delete();
        $category->parameters()->saveMany($categoryParameters);
        $category->save();

        $response = [
            'success' => true,
            'data' => $category,
            'message' => 'Category updated successfully',
        ];

        return response()->json($response, 200);
    }
}
