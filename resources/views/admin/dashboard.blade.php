@php
  $appInfo = App\Models\AppInfo::first();
@endphp

@extends('admin.index')

@section('title')
    Dashboard
@endsection

@section('styles')

@endsection

@section('admin-content')
    <h1>Welcome to the {{ $appInfo -> app_name }} App.</h1>
@endsection

@section('scripts')

@endsection