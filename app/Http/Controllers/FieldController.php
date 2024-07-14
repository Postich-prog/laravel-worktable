<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::get();
        return view('index', compact('fields'));
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            Field::find($request->pk)
                ->update([
                    $request->name => $request->value
                ]);

            return response()->json(['success' => true]);
        }
    }
    public function delete($id)
    {
        $product = Field::find($id);
        $product->delete();
        return response()->json(['success' => 'success']);
    }
}
