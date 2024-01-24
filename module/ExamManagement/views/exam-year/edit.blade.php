@extends('layouts.master')

@section('title', 'Exam Year Edit')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Exam Management</a></li>
            <li><a class="text-muted" href="{{ route('em.exam-years.index') }}">Exam Year</a></li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>
    @include('partials._alert_message')

    <form action="{{ route('em.exam-years.update', $examYear->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row mt-2">
            <div class="col-md-12">

                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Exam Year <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-10">
                        <input type="text" class="form-control" name="year" value="{{ old('year', $examYear->year) }}" required id="name">
                    </div>
                </div>



            </div>
            <div class="col-md-12">

                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Status (Published) <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-10">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="status" id="status" value="1" {{ $examYear->status ? 'checked' : '' }} />
                            <label for="status" class="badge-primary"></label>
                        </div>
                    </div>
                </div>
            </div>


        </div>



        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label"></label>
            <div class="col-sm-12 col-md-10">
                <div class="btn-group" style=" margin-top: 10px">
                    <button class="btn btn-sm btn-theme">
                        <i class="far fa-check-circle"></i>
                        UPDATE
                    </button>
                    <a class="btn btn-sm btn-yellow ml-1" href="{{ route('em.exam-years.index') }}">
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
