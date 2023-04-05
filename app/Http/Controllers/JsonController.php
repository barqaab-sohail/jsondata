<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JsonController extends Controller
{

    public function import(Request $request)
    {
        $this->validate($request, [
            'select_file'  => 'required'
        ]);
        $extension = '';
        if ($request->hasFile('select_file')) {
            $extension = request()->select_file->getClientOriginalExtension();
            // $data = file_get_contents($request->file('select_file'));
            // print_r($data);
        }
        return response()->json(['message' => "Data saved successfully. $extension"]);
    }
}
