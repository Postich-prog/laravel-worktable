<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;
class CsvController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $user_id = auth()->user()->id;

        $path = $request->file('file')->store('temp', 'public');

        $path = storage_path('app/public/' . $path);
        $rows = file($path);

        $names = rtrim($rows[0], ",");
        $numbers = rtrim($rows[1], ",");

        $names = explode(',', $names);
        $numbers = explode(',', $numbers);

        foreach ($numbers as $number) {
            if (!is_numeric($number)) {
                session()->flash('error', 'Во второй строке CSV-файла должны находиться только числа.');
                return back();
            }
        }

        $counter = 0;
        foreach ($names as $name) {
            if (isset($numbers[$counter])) {
                $data = [];
                $data[] = [
                    'name' => trim($name),
                    'number' => trim($numbers[$counter]),
                    'owner_id' => $user_id,
                ];
                Field::insert($data);
            }
            $counter++;
        }
        Storage::delete('public/' . $path);
        Storage::delete('public/temp' . $path);
        return redirect('/dashboard');
    }

    public function uploadForm()
    {
        return view('upload');
    }
}
