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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'number' => 'required|numeric',
        ]);

        $user = $request->user();
        $userId = $user->id;
        $validatedData['owner_id'] = $userId;

        $field = Field::create($validatedData);

        return redirect()->route('dashboard');
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
                if (!is_numeric($request->value)) {
                    session()->flash('error', 'Во второй строке CSV-файла должны находиться только числа.');
                    return back();
                } else {
                    Field::find($request->pk)
                        ->update([
                            $request->number => $request->value
                        ]);
                }


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
