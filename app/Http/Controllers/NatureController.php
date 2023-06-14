<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use App\Models\SubNature;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;

class NatureController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = Nature::class;
    }


    public function update(Request $request, $id)
    {
        $nature = Nature::findOrFail($id);
        $nature->name = $request->name;

        $subnatures = [];

        foreach ($request->subnatures as $sub) {
            $subnature = SubNature::create([
                'name' => $sub['name'],
            ]);
            array_push($subnatures, $subnature);
            if (isset($sub['selectedCategories'])) {
                $subnature->categories()->sync($sub['selectedCategories']);
            }
        }
        $nature->subnatures()->delete();
        $nature->subnatures()->saveMany($subnatures);
        $nature->save();

        $response = [
            'success' => true,
            'data' => $nature,
            'message' => 'nature updated successfully',
        ];

        return response()->json($response, 200);

    }
}
