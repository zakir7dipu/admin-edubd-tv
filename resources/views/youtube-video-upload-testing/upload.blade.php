@extends('layouts.master')

@section('title', 'Youtube Video Upload')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="fab fa-youtube"></i> @yield('title')</h4>
    </div>

    <div class="mt-2">
        @include('partials._alert_message')
    </div>

    <form action="{{ route('youtube-video-upload-testings.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Title</label>
            <div class="col-sm-12 col-md-10">
                <input type="text" class="form-control" name="title" value="{{ old('title') }}" autocomplete="off">
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Description</label>
            <div class="col-sm-12 col-md-10">
                <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Video</label>
            <div class="col-sm-12 col-md-10">
                <input type="file" class="form-control" name="video" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label"></label>
            <div class="col-sm-12 col-md-10">
                <button class="btn btn-sm btn-theme">
                    <i class="far fa-check-circle"></i>
                    SUBMIT
                </button>
            </div>
        </div>
    </form>
@endsection