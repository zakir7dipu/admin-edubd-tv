@extends('layouts.master')

@section('title', 'Institute Edit')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Exam Management</a></li>
            <li><a class="text-muted" href="{{ route('em.institutes.index') }}">Institute</a></li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>
    @include('partials._alert_message')

    <form action="{{ route('em.institutes.update', $institute->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row mt-2">
            <div class="col-md-6">

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Institute Name <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="name" value="{{ old('name', $institute->name) }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Short Form<sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="short_form" value="{{ old('short_form',$institute->short_form) }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Title<sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="title" value="{{ old('title',$institute->title) }}">
                    </div>
                </div>



            </div>
            <div class="col-md-6">

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Address<sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="address" value="{{ old('address', $institute->address) }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Website<sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="website" value="{{ old('website',$institute->website) }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Status (Published) <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="status" id="status" value="1" {{ $institute->status ? 'checked' : '' }} />
                            <label for="status" class="badge-primary"></label>
                        </div>
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
                        UPDATE
                    </button>
                    <a class="btn btn-sm btn-yellow ml-1" href="{{ route('em.institutes.index') }}">
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
