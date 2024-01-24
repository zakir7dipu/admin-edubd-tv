@extends('layouts.master')

@section('title', 'Testimonials Edit')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Website CMS</a></li>
            <li><a class="text-muted" href="{{ route('wc.testimonials.index') }}">Testimonials</a></li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>

    <form action="{{ route('wc.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('partials._alert_message')
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Name <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="name"
                            value="{{ old('name', $testimonial->name) }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Designation <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="designation"
                            value="{{ old('designation', $testimonial->designation) }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Country <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="country"
                            value="{{ old('country', $testimonial->country) }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Description <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <textarea name="description" class="form-control" rows="2">{{ old('description', $testimonial->description) }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Status (Published)<sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="status" id="status" value="1"
                                {{ $testimonial->status ? 'checked' : '' }} />
                            <label for="status" class="badge-primary"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Image
                        @if ($testimonial->image == '')
                            <sup style="color: red">*</sup>
                        @endif
                    </label>
                    <div class="col-sm-12 col-md-9">
                        <input type="file" name="image" class="form-control"
                            {{ $testimonial->image == '' ? 'required' : '' }} autocomplete="off">
                        <p class="text-danger">Image size must be 200X200</p>
                        @if (file_exists($testimonial->image) && $testimonial->image != '')
                            <img src="{{ asset($testimonial->image) }}" width="50%" height="100px" alt=""
                                class="img-thumbnail">
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Ratings <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" name="rating" class="form-control"
                            value="{{ old('rating', $testimonial->rating) }}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Serial No <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" name="serial_no" class="form-control only-number"
                            value="{{ old('serial_no', $testimonial->serial_no) }}" autocomplete="off" required>
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
                    <a class="btn btn-sm btn-yellow ml-1" href="{{ route('wc.testimonials.index') }}">
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
