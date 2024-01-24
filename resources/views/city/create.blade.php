@extends('layouts.master')

@section('title', 'city Create')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">City</a></li>
            <li><a class="text-muted" href="{{ route('city.index') }}">City</a></li>
            <li class=""><a href="javascript:void(0)">Create</a></li>
        </ul>
    </div>
    <form action="{{ route('city.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('partials._alert_message')
    <div class="row mt-2">
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">Country <sup style="color: red">*</sup></label>
                <div class="col-sm-12 col-md-9">
                    <select name="country" id="country_id" class="select2 form-control" >
                        <option value="">-- Select Country --</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">State <sup style="color: red">*</sup></label>
                <div class="col-sm-12 col-md-9">
                    <select name="state" id="state" class="js-example-basic-single select2 form-control">
                        <option value="">-- Select State --</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">City Name <sup style="color: red"></sup></label>
                <div class="col-sm-12 col-md-9">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">Status (Published) <sup style="color: red">*</sup></label>
                <div class="col-sm-12 col-md-9">
                    <div class="material-switch pt-1">
                        <input type="checkbox" name="status" id="status" value="1" checked />
                        <label for="status" class="badge-primary"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label class="col-sm-12 col-md-3 col-form-label"></label>
        <div class="col-sm-12 col-md-9">
            <div class="btn-group" style="float: right; margin-top:15px">
                <button class="btn btn-sm btn-theme">
                    <i class="far fa-check-circle"></i>
                    SUBMIT
                </button>
                <a class="btn btn-sm btn-yellow ml-1" href="{{ route('city.index') }}">
                    <i class="far fa-long-arrow-left"></i>
                    BACK TO LIST
                </a>
            </div>
        </div>
    </div>

</form>
@endsection





@section('js')
@endsection
