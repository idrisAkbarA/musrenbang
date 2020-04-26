@extends('layouts.app')

@section('pengumuman')//highlight link yg dipilih di sidebar
    green lighten-5
@endsection

@section('bar-components')
    <filter-musrenbang></filter-musrenbang>
    <tambah-usulan></tambah-usulan>
@endsection
@section('content')
    <experiment></experiment>
@endsection