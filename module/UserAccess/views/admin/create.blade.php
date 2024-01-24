@extends('layouts.master')

@section('title', 'Admin Create')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">User Access</a></li>
            <li><a class="text-muted" href="{{ route('ua.admin.index') }}">Admin</a></li>
            <li class=""><a href="javascript:void(0)">Create</a></li>
        </ul>
    </div>
    @include('partials._alert_message')

    <form action="{{ route('ua.admin.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mt-2">
            <div class="col-md-6">

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">first Name <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"  id="first_name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Last Name</label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}"  id="last_name">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Phone</label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}"  id="phone">
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Postcode </label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control only-number" name="postcode" value="{{ old('postcode') }}" autocomplete="off" >
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Password <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required style="position: absolute">
                        <span id="icon" style="position: absolute; top: 8px; right: 0; cursor: pointer" data-type="show" onclick="passwordToggle(this)">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Image</label>
                    <div class="col-sm-12 col-md-8">
                        <input type="file" name="image" accept="image/webp, image/png, image/gif, image/jpg, image/jpeg">
                        <small class="text-danger mb-0">Image size must be 450X450.</small>
                    </div>
                </div>

            </div>
            <div class="col-md-6">

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">User Name</label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="username" value="{{ old('username') }}"  id="username">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Email<sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"  id="email" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Gender</label>
                    <div class="col-sm-12 col-md-8">
                        <select class="form-select" name="gender">
                            @foreach (genders() as $gender)
                                <option value="{{ $gender }}" {{ old('gender') == $gender ? 'selected' : '' }}>{{ $gender }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Status <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="status" id="status" value="1" checked />
                            <label for="status" class="badge-primary"></label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Country <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <select class="form-select select2" name="country_id" onchange="fetchStatesAndCities()" id="country_id" data-placeholder="- Select Country -" style="width: 100%">
                            <option></option>
                            @foreach ($countries as $id => $name)
                                <option value="{{ $id }}" {{ old('country_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">State</label>
                    <div class="col-sm-12 col-md-9">
                        <select class="form-select select2" name="state_id" id="state_id" onchange="fetchCities()" data-placeholder="- Select State -" style="width: 100%">
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">City <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <select class="form-select select2" name="city_id" id="city_id" data-placeholder="- Select City -" style="width: 100%" >
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Street Address</label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="address_1" value="{{ old('address_1') }}" autocomplete="off" >
                    </div>
                </div>


            </div>


        </div>



        <div class="form-group row">
            <label class="col-sm-12 col-md-3 col-form-label"></label>
            <div class="col-sm-12 col-md-9">
                <div class="btn-group" style="float: right; margin-top: 10px">
                    <button class="btn btn-sm btn-theme">
                        <i class="far fa-check-circle"></i>
                        SUBMIT
                    </button>
                    <a class="btn btn-sm btn-yellow ml-1" href="{{ route('ua.admin.index') }}">
                        <i class="far fa-long-arrow-left"></i>
                        BACK TO LIST
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection





@section('js')
@include('admin/_inc/script')
@endsection