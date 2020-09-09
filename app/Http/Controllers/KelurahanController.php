<?php

namespace App\Http\Controllers;

use App\Kelurahan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class KelurahanController extends Controller
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function show(Kelurahan $kelurahan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelurahan $kelurahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        $pod = kelurahan::orderBy('id', 'DESC')->get();
        // foreach ($pod as $key => $value) {
        //     $pod[$key]['index'] = $key+1;
        // }
        return response()->json($pod);
    }
    public function add(Request $request)
    {
        $pod = new kelurahan;
        $pod->nama = $request['nama'];
        $pod->save();

        $getIdkel = kelurahan::where('nama', $request['nama'])->first();
        $idkel = $getIdkel->id;
        
        $trimmedNama = strtolower(preg_replace('/\s+/', '', $request['nama']));
        $user = new User;
        $user->name = $trimmedNama;
        $user->id_kel = $idkel;
        if($request['password']==""){
            $user->password = Hash::make($trimmedNama . '123');
        }else{
            $user->password = Hash::make($request['password']);
        }
        $user->save();
        $result = kelurahan::orderBy('id', 'DESC')->get();
         
        return response()->json($result);
    }
    public function update(Request $request)
    {
        $pod = kelurahan::find($request['id']);
        $pod->nama = $request['nama'];
        $pod->save();

        $user = user::where('id_kel',$request['id'])->first();
        $user->name = strtolower(preg_replace('/\s+/', '', $request['nama']));
        $user->save();
        
        $result = kelurahan::orderBy('id', 'DESC')->get();
        return response()->json($result);
    }
    public function updatePass(Request $request)
    {
        $user = user::where('id_kel',$request['id'])->first();
        
        $user->save();

        $result = kelurahan::orderBy('id', 'DESC')->get();
        return response()->json($result);
    }
    public function DELETE(Request $request)
    {
        $pod = kelurahan::find($request['id']);
        $pod->delete();
        $user = user::where('id_kel',$request['id'])->first()->delete();

        $result = kelurahan::orderBy('id', 'DESC')->get();
        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelurahan $kelurahan)
    {
        //
    }


}
