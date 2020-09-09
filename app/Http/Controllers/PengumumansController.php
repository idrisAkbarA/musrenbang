<?php

namespace App\Http\Controllers;

use App\pengumumans;
use Illuminate\Http\Request;

class PengumumansController extends Controller
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
     * @param  \App\pengumumans  $pengumumans
     * @return \Illuminate\Http\Response
     */
    public function show(pengumumans $pengumumans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pengumumans  $pengumumans
     * @return \Illuminate\Http\Response
     */
    public function edit(pengumumans $pengumumans)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pengumumans  $pengumumans
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pengumumans  $pengumumans
     * @return \Illuminate\Http\Response
     */
    public function destroy(pengumumans $pengumumans)
    {
        //
    }

    public function getData()
    {
        $pod = pengumumans::orderBy('id', 'DESC')->get();
        return response()->json($pod);  
    }
    public function add(Request $request)
    {
        $pod = new pengumumans;
        $pod->nama = $request['nama'];
        $pod->isi = $request['isi'];
        $pod->save();

        $result = pengumumans::orderBy('id', 'DESC')->get();
        return response()->json($result);
    }
    public function update(Request $request)
    {
        $pod = pengumumans::find($request['id']);
        $pod->nama = $request['nama'];
        $pod->isi = $request['isi'];
        $pod->save();

        $result = pengumumans::orderBy('id', 'DESC')->get();
        return response()->json($result);
    }
    public function DELETE(Request $request)
    {
        $pod = pengumumans::find($request['id']);
        $pod->delete();

        $result = pengumumans::orderBy('id', 'DESC')->get();
        return response()->json($result);
    }

}
