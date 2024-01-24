@extends('layouts.master')

@section('title', 'Create Exam Category')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>
        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Exam Management</a></li>
            <li><a class="text-muted" href="{{ route('em.exam-categories.index') }}">Exam Categories</a></li>
            <li class=""><a href="javascript:void(0)">Create</a></li>
        </ul>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            @include('partials._alert_message')
            <form action="{{ route('em.exam-categories.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Parent Exam Category</label>
                    <div class="col-sm-12 col-md-6">
                        <select name="parent_id" class="form-control select2" width="100%">
                            <option value="" selected>- Select -</option>
                            <x-exam-category.exam-category-options />
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Name <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-6">
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Slug <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-6">
                        <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Short Description</label>
                    <div class="col-sm-12 col-md-6">
                        <textarea name="short_description" class="form-control" rows="4" autocomplete="off">{{ old('short_description') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Serial No <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-6">
                        <input type="text" name="serial_no" class="form-control only-number" value="{{ old('serial_no', $nextSerialNo) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Show in Menu</label>
                    <div class="col-sm-12 col-md-9">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="show_in_menu" id="showInMenu" value="1" {{ old('show_in_menu') ? 'checked' : '' }} />
                            <label for="showInMenu" class="badge-primary"></label>
                        </div>
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
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label"></label>
                    <div class="col-sm-12 col-md-9">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-theme">
                                <i class="far fa-check-circle"></i>
                                SUBMIT
                            </button>
                            <a class="btn btn-sm btn-yellow ml-1" href="{{ route('em.exam-categories.index') }}">
                                <i class="far fa-long-arrow-left"></i>
                                BACK TO LIST
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection