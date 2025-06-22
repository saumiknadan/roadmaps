@extends('admin.index')
@section('title') Profile Update @endsection

@section('styles')

@endsection

@section('admin-content')
    {{-- Profile --}}
    @include('profile.partials.update-profile-information-form')


    {{-- Update Password --}}
    @include('profile.partials.update-password-form')
    

@endsection


@section('scripts')

@endsection