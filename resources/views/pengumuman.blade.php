@extends('layouts.app')

@section('pengumuman')
    green lighten-5
@endsection

@section('bar-components')

@endsection
@section('content')
    @if (Session::get('user') == "Administrator")
        <timeline-admin></timeline-admin>
    @else
        <timeline></timeline>
    @endif
@endsection