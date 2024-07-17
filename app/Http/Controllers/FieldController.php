<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;

class FieldController extends Controller
{
    public function dashboard()
    {
        $user_id = auth()->user()->id;
        $fields = Field::where('owner_id', $user_id)->get();
        if (is_null($fields) || $fields->isEmpty()) {
            $fields = [];
        }

        return view('dashboard', compact('fields'));
    }

    public function create(Request $request)
    {
        $data[] = [
            'owner_id' => $request->user()->id,
        ];
        Field::insert($data);
        return response()->json(['success' => 'success']);
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            if ($request->name) {
                Field::find($request->pk)
                    ->update([
                        $request->name => $request->value
                    ]);

                return response()->json(['success' => true]);
            }

            if ($request->number) {
                Field::find($request->pk)
                    ->update([
                        $request->number => $request->value
                    ]);

                return response()->json(['success' => true]);
            }
        }
    }

    public function delete($id)
    {
        $field = Field::find($id);
        $field->delete();
        return response()->json(['success' => 'success']);
    }
}
