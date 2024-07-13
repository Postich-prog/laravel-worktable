<?php

namespace App\Http\Controllers;

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
                'owner_id' => 1
            ];
            Field::insert($data);
            $counter++;
        }
        return redirect()->back()->with('success', 'CSV file has been uploaded successfully.');
    }

    public function uploadForm()
    {
        return view('upload');
    }
}
