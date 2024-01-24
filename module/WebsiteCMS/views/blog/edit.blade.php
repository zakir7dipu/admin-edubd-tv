@extends('layouts.master')

@section('title', 'Blog Edit')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Website CMS</a></li>
            <li><a class="text-muted" href="{{ route('wc.blog.index') }}">Blog</a></li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>

    <form action="{{ route('wc.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('partials._alert_message')

        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Blog Category <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <select name="blogCategory" id="category_id" class="select2 form-control">
                            <option value="">-- Select Blog Category --</option>
                            @foreach ($blogCategories as $blogCategory)
                                <option value="{{ $blogCategory->id }}" {{ ( $blog->category_id == $blogCategory->id  ) ? ' selected' : '' }}>
                                    {{ $blogCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Blog Title <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="title" value="{{ old('title', $blog->title) }}"
                            required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Blog slug<sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="slug" value="{{ old('slug', $blog->slug) }}" required
                            id="slug">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Short Description <sup
                            style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <textarea name="short_description" class="form-control" rows="2">{{ old('short_description',$blog->short_description) }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Serial No <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" name="serial_no" class="form-control only-number"
                            value="{{ old('serial_no', $blog->serial_no) }}" autocomplete="off" required>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Thumbnail Image
                        @if ($blog->thumbnail_image == '')
                            <sup style="color: red"></sup>
                        @endif
                    </label>
                    <div class="col-sm-12 col-md-9">
                        <input type="file" name="thumbnail_image" class="form-control"
                            {{ $blog->thumbnail_image == '' ? 'required' : '' }} autocomplete="off">
                        <p class="text-danger">Image size must be 300X300</p>
                        @if (file_exists($blog->thumbnail_image) && $blog->thumbnail_image != '')
                            <img src="{{ asset($blog->thumbnail_image) }}" width="50%" height="100px" alt=""
                                class="img-thumbnail">
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Cover Image
                        @if ($blog->cover_image == '')
                            <sup style="color: red"></sup>
                        @endif
                    </label>
                    <div class="col-sm-12 col-md-9">
                        <input type="file" name="cover_image" class="form-control"
                            {{ $blog->cover_image == '' ? 'required' : '' }} autocomplete="off">
                        <p class="text-danger">Image size must be 1050X450</p>
                        @if (file_exists($blog->cover_image) && $blog->cover_image != '')
                            <img src="{{ asset($blog->cover_image) }}" width="50%" height="100px" alt=""
                                class="img-thumbnail">
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Status (Published) <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="status" id="status" value="1"
                                {{ $blog->status ? 'checked' : '' }} />
                            <label for="status" class="badge-primary"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-12 col-md-3 col-form-label">Description <sup
                    style="color: red"></sup></label>
            <div class="col-sm-12 col-md-12">
                <textarea id="description" name="description" class="form-control ckeditor" rows="2">{{ old('description',$blog->description) }}</textarea>
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
                    <a class="btn btn-sm btn-yellow ml-1" href="{{ route('wc.blog.index') }}">
                        <i class="far fa-long-arrow-left"></i>
                        BACK TO LIST
                    </a>
                </div>
            </div>
        </div>
    </form>
    @endsection





    @section('js')
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
           $('.ckeditor').ckeditor();
        });
    </script>
    @endsection
