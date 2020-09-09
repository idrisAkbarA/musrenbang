<?php

namespace App\Http\Controllers;

use App\POD;
use Illuminate\Http\Request;

class PODController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\POD  $pOD
     * @return \Illuminate\Http\Response
     */
    public function show(POD $pOD)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\POD  $pOD
     * @return \Illuminate\Http\Response
     */
    public function edit(POD $pOD)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\POD  $pOD
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        $pod = pod::orderBy('id', 'DESC')->get();
        // foreach ($pod as $key => $value) {
        //     $pod[$key]['index'] = $key+1;
        // }
        return response()->json($pod);
    }
    public function add(Request $request)
    {
        $pod = new pod;
        $pod->nama = $request['nama'];
        $pod->save();

        $result = pod::orderBy('id', 'DESC')->get();
        return response()->json($result);
    }
    public function update(Request $request)
    {
        $pod = pod::find($request['id']);
        $pod->nama = $request['nama'];
        $pod->save();

        $result = pod::orderBy('id', 'DESC')->get();
        return response()->json($result);
    }
    public function DELETE(Request $request)
    {
        $pod = pod::find($request['id']);
        $pod->delete();

        $result = pod::orderBy('id', 'DESC')->get();
        return response()->json($result);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\POD  $pOD
     * @return \Illuminate\Http\Response
     */
    public function destroy(POD $pOD)
    {
        //
    }
}
