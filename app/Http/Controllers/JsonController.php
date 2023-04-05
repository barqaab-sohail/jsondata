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
            $fileName =  time() . '.' . $extension;
            $folderName = "json/";
            $request->file('select_file')->storeAs('public/' . $folderName, $fileName);
            $file_path = storage_path('app/public/' . $folderName . $fileName);
            $data = file_get_contents($file_path); //data read from json file
            $users = json_decode($data);
            // $data = file_get_contents($request->file('select_file'));
            // print_r($data);
        }
        return response()->json(['message' => "Data saved successfully. $users"]);
    }
}
