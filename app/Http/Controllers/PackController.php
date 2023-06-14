<?php

namespace App\Http\Controllers;


use App\Models\Pack;
use App\Models\PackItem;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;

class PackController extends Controller
{
    use CrudTrait;

    public function __construct()
    {
        $this->Model = Pack::class;
    }

    public function store(Request $request)
    {
        $pack = new Pack();
        $pack->fill($request->all());
        $pack->reference = "PK-" . time();
        $pack->save();
        foreach ($request->items as $item) {
            PackItem::create([
                'pack_id' => $pack->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);

        }
        return sendResponse($pack, 'Pack created successfully');
    }

    public function update(Request $request, $id)
    {
        $pack = Pack::findOrFail($id);
        $pack->fill($request->all());
        $pack->reference = "PK-" . time();
        $pack->save();
        $pack->PackItems()->delete();

        foreach ($request->items as $item) {
            PackItem::create([
                'pack_id' => $pack->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);

        }
        return sendResponse($pack, 'Pack updated successfully');
    }

}
