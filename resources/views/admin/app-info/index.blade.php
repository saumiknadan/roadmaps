@extends('admin.index')

@section('title')
    {{ $appInfo-> app_name}}
@endsection

@section('styles')
        

@endsection

@section('admin-content')

    <div class="row">
        <div class="container" id="top">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row mb-5">
                        <h5 class="card-title mb-sm-0 me-2">{{ $appInfo-> app_name}}</h5>
                    </div>
                    @include('admin.partials.message')

                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12 mx-auto">
                                <div class="d-flex align-items-center gap-4">
                                    <div>
                                        <h1 class="mb-0" style="font-size: 1.8rem; font-weight: 600;">
                                            {{ $appInfo->app_name }}
                                        </h1>
                                    </div>
                                    @if (isset($appInfo->logo) && $appInfo->logo != null)
                                        <div class="d-flex align-items-center">
                                            <img 
                                                src="{{ $appInfo->logo == 'admin' 
                                                    ? asset(env('ADMINPATH') . $appInfo->logo) 
                                                    : asset(env('FRONTPATH') . $appInfo->logo) }}"
                                                alt="App Logo"
                                                style="width: 60px; height: auto; object-fit: contain;"
                                            >
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-4">
                                    @if($appInfo)
                                        <a class="btn btn-label-primary me-3" href="{{ route('app-info.edit', $appInfo->id) }}">Edit App Info</a>
                                    @else
                                        <a class="btn btn-label-primary me-3" href="{{ route('app-info.create') }}">Create App Info</a>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection



