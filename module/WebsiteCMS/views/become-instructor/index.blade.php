@extends('layouts.master')

@section('title', 'Terms And Condition')

@section('content')



    {{-- breadcrumbs section  --}}


    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Website CMS</a></li>
            <li><a class="text-muted" href="{{ route('wc.become-instructor.index') }}">Become instructor </a></li>
        </ul>
    </div>


    <form action="{{ route('wc.become-instructor.update', optional($becomeInstructor)->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('partials._alert_message')

        <div class="row mt-2">
            <div class="col-md-12">

                {{-- title --}}
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Title<sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="title" value="{{ old('title', optional($becomeInstructor)->title) }}"
                            >
                    </div>
                </div>



                {{-- short description  --}}

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Short Description <sup
                            style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <textarea name="short_description" class="form-control" rows="4">{{ old('short_description',optional($becomeInstructor)->short_description) }}</textarea>
                    </div>
                </div>



                {{-- image  --}}
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Image<sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="file" name="image" class="form-control" autocomplete="off">
                        <p class="text-danger">Image size must be 330X450</p>
                        @if (file_exists($becomeInstructor->image) && $becomeInstructor->image != '')
                            <img src="{{ asset($becomeInstructor->image) }}" width="200px" height="200px" alt=""
                                class="img-thumbnail">
                        @endif
                    </div>
                </div>


            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-12 col-md-3 col-form-label"></label>
            <div class="col-sm-12 col-md-9">
                <div class="btn-group" style="float: right; margin-top:15px">
                    <button class="btn btn-sm btn-theme">
                        <i class="far fa-check-circle"></i>
                        Update
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection





{{-- script section  --}}

@section('js')
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
       $('.ckeditor').ckeditor();
    });
</script>
@endsection
