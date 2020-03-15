<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function store(Request $request)
    {
        $imageName = $request->file->getClientOriginalName();
        $request->file->move(public_path('files'), $imageName);
         
    	return response()->json(['success'=>'You have successfully upload file.']);
    }
}
