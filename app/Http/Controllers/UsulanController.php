<?php

namespace App\Http\Controllers;

use App\Usulan;
use App\ItemUsulan;
use App\Kelurahan;
use App\POD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsulanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function init()
    {
        $userInfo = ['id'=>1,"kelurahan"=>"Air Hitam"]; //nanti ganti dengan session
        return $userInfo;
    }
    public function hapus(Request $request)
    {   
        try {
            //code...
            $id = $request['id'];
            $usulan = Usulan::find($id);
            $usulan->delete();
            return 'true';
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function itemPilihan()
    {
        $itemUsulan = ItemUsulan::all(); //nanti ganti dengan session
        $pod = pod::all(); //nanti ganti dengan session
        $kelurahan = kelurahan::all(); //nanti ganti dengan session
        return ['itemUsulan'=>$itemUsulan->pluck('nama'),'pod'=>$pod->pluck('nama'),'kelurahan'=>$kelurahan->pluck('nama')];
    }
    public function dataUsulan()
    {
        $data = Usulan::paginate(5)->orderBy('created_at', 'desc'); //nanti ganti dengan session
        return $data;
    }
    public function dataUsulanFilter(Request $request)
    {
        $itemPerPage = $request['itemPerPage'];
        $data = Usulan::orderBy('id', 'desc')->paginate($itemPerPage); //nanti ganti dengan session
        return $data;
    }
    public function index()
    {
        $userInfo = ['id'=>1,"kelurahan"=>"Air Hitam"]; //nanti ganti dengan session
        return view('musrenbang')->with('userInfo',$userInfo);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verifikasi(Request $request)
    {   
        try {
            $verif =  Usulan::find($request->input('id'));
            $verif->verifikasi = $request->input('verifikasi');
            $verif->save();
            return "true";
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
    public function validasi(Request $request)
    {
        try {
            $valid =  Usulan::find($request['id']);
            $valid->validasi = $request['validasi'];
            $valid->save();
            return "true";
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function prioritas(Request $request)
    {
        try {
            $prioritas =  Usulan::find($request->input('id'));
            $prioritas->prioritas = $request->input('prioritas');
            $prioritas->save();
            // return $request;
            return "true";
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        try {
            //code...
            $usul =  new usulan;
            $usul->usulan = $request['usulan'];
            $usul->pod = $request['pod'];
            $usul->kelurahan = $request['kelurahan'];
            $usul->volume = $request['volume'];
            $usul->satuan = $request['satuan'];
            $usul->alamat = $request['alamat'];
            $usul->alasan_usulan = $request['alasan_usulan'];
            $usul->output = $request['output'];
            $usul->rt = $request['rt'];
            $usul->rw = $request['rw'];
            $usul->alamat_pengusul = $request['alamat_pengusul'];
            $usul->hp_pengusul = $request['hp_pengusul'];
            $usul->nama_pengusul = $request['nama_pengusul'];
            $usul->verifikasi = "tidak";
            $usul->validasi = "tidak";
            $usul->prioritas = "tidak";
            $usul->foto1 = $request['foto1'];
            $usul->foto2 = $request['foto2'];
            $usul->file1 = $request['file1'];
            $usul->file2 = $request['file2'];
            $usul->loading_verifikasi = false;
            $usul->loading_validasi = false;
            $usul->loading_prioritas = false;
            $usul->save();
            return Usulan::orderBy('id', 'desc')->paginate($request['itemPerPage']);
        } catch (\Throwable $th) {
            throw $th;
        }
       
    }
    public function testFilter(Request $request){
        $perPage = $request['perPage'];
        $filter= json_decode($request['filter'],true);
        $tahun =$filter['tahun'];
        $filterKeyArray = [];
        $filterValueArray = [];
        $finalFilter=[];
        foreach ($filter as $key => $value) {
            if($value !=null && $key !='tahun'){
                array_push($filterKeyArray,$key);
                array_push($filterValueArray,$value);
            }
        }
        $finalFilter = array_combine($filterKeyArray,$filterValueArray);

        if($tahun!=null && $tahun!="Semua"){
            $usul = Usulan::whereYear('created_at',$tahun)->where($finalFilter)->orderBy('id', 'desc')->paginate($perPage);
            return $usul;
        }
        $usul = Usulan::where($finalFilter)->orderBy('id', 'desc')->paginate($perPage);
        return $usul;
    }

    public function update(Request $request)
    {   
        try {
            //code...
            $usul =  usulan::find($request['id']);
            $usul->usulan = $request['usulan'];
            $usul->pod = $request['pod'];
            $usul->kelurahan = $request['kelurahan'];
            $usul->volume = $request['volume'];
            $usul->satuan = $request['satuan'];
            $usul->alamat = $request['alamat'];
            $usul->alasan_usulan = $request['alasan_usulan'];
            $usul->output = $request['output'];
            $usul->rt = $request['rt'];
            $usul->rw = $request['rw'];
            $usul->alamat_pengusul = $request['alamat_pengusul'];
            $usul->hp_pengusul = $request['hp_pengusul'];
            $usul->nama_pengusul = $request['nama_pengusul'];
            // $usul->verifikasi = "tidak";
            // $usul->validasi = "tidak";
            // $usul->prioritas = "tidak";
            // $usul->foto1 = $request['foto1'];
            // $usul->foto2 = $request['foto2'];
            // $usul->file1 = $request['file1'];
            // $usul->file2 = $request['file2'];
            // $usul->loading_verifikasi = false;
            // $usul->loading_validasi = false;
            // $usul->loading_prioritas = false;
            $usul->save();
            return Usulan::orderBy('id', 'desc')->paginate($request['itemPerPage']);
        } catch (\Throwable $th) {
            throw $th;
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Usulan  $usulan
     * @return \Illuminate\Http\Response
     */
    public function show(Usulan $usulan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Usulan  $usulan
     * @return \Illuminate\Http\Response
     */
    public function edit(Usulan $usulan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Usulan  $usulan
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usulan  $usulan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usulan $usulan)
    {
        //
    }
}
