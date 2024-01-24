@extends('layouts.master')

@section('title', 'Slider Create')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Website CMS</a></li>
            <li><a class="text-muted" href="{{ route('wc.sliders.index') }}">Slider</a></li>
            <li class=""><a href="javascript:void(0)">Create</a></li>
        </ul>
    </div>
    @include('partials._alert_message')

    <form action="{{ route('wc.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mt-2">
            <div class="col-md-6">


                <div class="form-group row mb-1">
                    <label class="col-sm-12 col-md-3 col-form-label">Course Name <span
                            style="color: red !important"></span></label>
                    <div class="col-sm-12 col-md-9">
                        <select name="course_id" onchange="appendCourse(this)" class="form-control select2" width="100%" id="course_id">
                            <option value="" selected>- Select -</option>

                            @foreach ($courses as $id => $title)
                                <option value="{{ $id }}" {{ old('course_id') == $id ? 'selected' : '' }}>
                                    {{ $title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Title <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}"
                            required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Short Description <sup
                            style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <textarea id="short_description" name="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Serial No <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" name="serial_no" class="form-control only-number"
                            value="{{ old('serial_no', $nextSerialNo) }}" autocomplete="off" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Image <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="file" id="image" name="image" class="form-control" required
                            autocomplete="off">
                        <p class="text-danger mb-0">Image size must be 1050X450</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Link <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" id="link" name="link" class="form-control" value="{{ old('link') }}"
                            autocomplete="off">
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
            <label class="col-sm-12 col-md-3 col-form-label"></label>
            <div class="col-sm-12 col-md-9">
                <div class="btn-group" style="float: right; margin-top: 10px">
                    <button class="btn btn-sm btn-theme">
                        <i class="far fa-check-circle"></i>
                        SUBMIT
                    </button>
                    <a class="btn btn-sm btn-yellow ml-1" href="{{ route('wc.sliders.index') }}">
                        <i class="far fa-long-arrow-left"></i>
                        BACK TO LIST
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection





@section('js')
    <script>
        function appendCourse(obj) {

            var id = $(obj).val();
            var courseTitle = '';
            let url = `{{ route('get-course') }}`;

            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {

                    if (response.courses) {

                        $('#title').val(response.courses.title);
                        $('#link').val(response.courses.slug);
                        $('#short_description').val(response.courses.short_description);
                        $("#link").attr('readonly', 'readonly');

                    } else {


                        $('#title').val('');
                        $('#link').val('');
                        $('#short_description').val('');
                        $("#link").removeAttr('readonly');
                    }

                    // $('#image').val(response.courses.thumbnail_image);

                }
            });

        }
    </script>
@endsection
