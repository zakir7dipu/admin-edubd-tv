@extends('layouts.master')

@section('title', 'Edit Course Category')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.course-categories.index') }}">Course Categories</a></li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">

            @include('partials._alert_message')

            <form action="{{ route('cm.course-categories.update', $courseCategory->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Parent Course Category</label>
                    <div class="col-sm-12 col-md-9">
                        <select name="parent_id" class="form-control select2" width="100%">
                            <option value="" selected>- Select -</option>

                            <x-course-category.course-category-options :categoryId="$courseCategory->id" :parentId="$courseCategory->parent_id" />
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Name <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $courseCategory->name) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Slug <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug', $courseCategory->slug) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Short Description</label>
                    <div class="col-sm-12 col-md-9">
                        <textarea name="short_description" class="form-control" rows="2" autocomplete="off">{{ old('short_description', $courseCategory->short_description) }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Serial No <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" name="serial_no" class="form-control only-number" value="{{ old('serial_no', $courseCategory->serial_no) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Icon</label>
                    <div class="col-sm-12 col-md-9" style="display: flex; gap: 20px">
                        <div style="line-height: 0px">
                            <input type="file" name="icon" accept="image/webp, image/png, image/gif, image/jpg, image/jpeg">
                            <small class="text-danger">Icon size must be 250X250.</small>
                        </div>
                        @if ($courseCategory->icon != '' && file_exists($courseCategory->icon))
                            <img src="{{ asset($courseCategory->icon) }}" class="img-thumbnail" width="80px" height="80px" alt="icon">
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Show in Highlight Category</label>
                    <div class="col-sm-12 col-md-9">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="is_highlighted" id="isHighlighted" value="1" {{ $courseCategory->is_highlighted || old('is_highlighted') ? 'checked' : '' }} />
                            <label for="isHighlighted" class="badge-primary"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Show in Menu</label>
                    <div class="col-sm-12 col-md-9">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="show_in_menu" id="showInMenu" value="1" {{ $courseCategory->show_in_menu || old('show_in_menu') ? 'checked' : '' }} />
                            <label for="showInMenu" class="badge-primary"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Status (Published) <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="status" id="status" value="1" {{ $courseCategory->status || old('status') ? 'checked' : '' }} />
                            <label for="status" class="badge-primary"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label"></label>
                    <div class="col-sm-12 col-md-9">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-theme">
                                <i class="far fa-edit"></i>
                                UPDATE
                            </button>
                            <a class="btn btn-sm btn-yellow ml-1" href="{{ route('cm.course-categories.index') }}">
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
