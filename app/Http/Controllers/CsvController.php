<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;
class CsvController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->fields) {
                foreach ($user->fields as $field) {
                    $field->delete();
                }
            }
        }


        $path = $request->file('csv_file')->store('temp');


        $path = storage_path('app/' . $request->file('csv_file')->store('temp', 'public'));
        $rows = file($path);
        $names = explode(',', $rows[0]);
        $numbers = explode(',', $rows[1]);

        $counter = 0;
        foreach ($names as $name) {
            $data = [];
            $data[] = [
                'name' => trim($name),
                'number' => trim($numbers[$counter]),
                'owner_id' => $request->user()->id,
            ];
            Field::insert($data);
            $counter++;
        }
        return redirect('/dashboard');
    }

    public function uploadForm()
    {
        return view('upload');
    }
}
