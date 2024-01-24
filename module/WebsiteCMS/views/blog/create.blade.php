@extends('layouts.master')

@section('title', 'Blog Create')

@section('content')




{{-- breadcrumb section  --}}

    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Website CMS</a></li>
            <li><a class="text-muted" href="{{ route('wc.blog.index') }}">Blog</a></li>
            <li class=""><a href="javascript:void(0)">Create</a></li>
        </ul>
    </div>
    @include('partials._alert_message')



    {{-- from section  --}}

    <form action="{{ route('wc.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mt-2">
            <div class="col-md-6">


                {{-- blog category --}}

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Blog Category <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <select name="blogCategory" id="category_id" class="select2 form-control">
                            <option value="">-- Select Blog Category --</option>
                            @foreach ($blogCategories as $blogCategory)
                                <option value="{{ $blogCategory->id }}">
                                    {{ $blogCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>




                {{-- blog title  --}}

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Blog Title <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" required id="name">
                    </div>
                </div>




                {{-- blog slug  --}}
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Blog slug<sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="slug" value="{{ old('slug') }}" required
                            id="slug">
                    </div>
                </div>





                {{-- short description  --}}


                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Short Description <sup
                            style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <textarea name="short_description" class="form-control" rows="4">{{ old('short_description') }}</textarea>
                    </div>
                </div>


            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Thumbnail Image <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="file" name="thumbnail_image" class="form-control" required autocomplete="off">
                        <p class="text-danger mb-0">Image size must be 300X300</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Cover Image <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="file" name="cover_image" class="form-control" autocomplete="off">
                        <p class="text-danger mb-0">Image size must be 1050X450</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Serial No <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" name="serial_no" class="form-control only-number"
                            value="{{ old('serial_no', $nextSerialNo) }}" autocomplete="off" required>
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

        <div class="form-group row">
            <label class="col-sm-12 col-md-3 col-form-label">Description <sup
                    style="color: red"></sup></label>
            <div class="col-sm-12 col-md-12">
                <textarea name="description" class="form-control ckeditor"  rows="2">{{ old('description') }}</textarea>
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
