<?php

namespace App\Http\Controllers;

use App\ItemUsulan;
use Illuminate\Http\Request;

class ItemUsulanController extends Controller
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
     * @param  \App\ItemUsulan  $itemUsulan
     * @return \Illuminate\Http\Response
     */
    public function show(ItemUsulan $itemUsulan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ItemUsulan  $itemUsulan
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemUsulan $itemUsulan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ItemUsulan  $itemUsulan
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ItemUsulan  $itemUsulan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemUsulan $itemUsulan)
    {
        //
    }
    public function getData()
    {
        $pod = ItemUsulan::orderBy('id', 'DESC')->get();
        // foreach ($pod as $key => $value) {
        //     $pod[$key]['index'] = $key+1;
        // }
        return response()->json($pod);
    }
    public function add(Request $request)
    {
        $usulan = new ItemUsulan;
        $usulan->nama = $request['nama'];
        $usulan->save();

        $result = ItemUsulan::orderBy('id', 'DESC')->get();
        return response()->json($result);
    }
    public function update(Request $request)
    {
        $usulan = ItemUsulan::find($request['id']);
        $usulan->nama = $request['nama'];
        $usulan->save();

        $result = ItemUsulan::orderBy('id', 'DESC')->get();
        return response()->json($result);
    }
    public function DELETE(Request $request)
    {
        $usulan = ItemUsulan::find($request['id']);
        $usulan->delete();

        $result = ItemUsulan::orderBy('id', 'DESC')->get();
        return response()->json($result);
    }
}
