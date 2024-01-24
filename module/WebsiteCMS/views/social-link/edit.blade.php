@extends('layouts.master')

@section('title', 'Social Link Edit')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Website CMS</a></li>
            <li><a class="text-muted" href="{{ route('wc.social-links.index') }}">Social Links</a></li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>


    <form action="{{ route('wc.social-links.update', $social_links->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('partials._alert_message')
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Name <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="name"
                            value="{{ old('name', $social_links->name) }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Url <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="url" class="form-control" name="url"
                            value="{{ old('url', $social_links->url) }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Icon <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="icon"
                            value="{{ old('icon', $social_links->icon) }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Serial No <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" name="serial_no" class="form-control only-number"
                            value="{{ old('serial_no', $social_links->serial_no) }}" autocomplete="off" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">background_color <sup
                            style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="color" name="background_color" class="form-control"
                            value="{{ old('background_color', $social_links->background_color) }}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">foreground_color <sup
                            style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="color" name="foreground_color" class="form-control"
                            value="{{ old('foreground_color', $social_links->foreground_color) }}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Status (Published) <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="status" id="status" value="1"
                                {{ $social_links->status ? 'checked' : '' }} />
                            <label for="status" class="badge-primary"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-12 col-md-3 col-form-label"></label>
            <div class="col-sm-12 col-md-9">
                <div class="btn-group" style="float: right; margin-top:15px">
                    <button class="btn btn-sm btn-theme">
                        <i class="far fa-edit"></i>
                        UPDATE
                    </button>
                    <a class="btn btn-sm btn-yellow ml-1" href="{{ route('wc.social-links.index') }}">
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
