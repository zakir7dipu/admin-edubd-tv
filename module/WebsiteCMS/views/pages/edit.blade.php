@extends('layouts.master')

@section('title', 'Pages Edit')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Website CMS</a></li>
            <li><a class="text-muted" href="{{ route('wc.pages.index') }}">Page</a></li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>
    <form action="{{ route('wc.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('partials._alert_message')
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Page Name <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" id="pageName" name="name"
                            value="{{ old('name', $page->name) }}" required onkeyup="handleKeyUp()">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">slug <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="slug" value="{{ old('title', $page->slug) }}"
                            required id="slug">
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Description <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <textarea name="description" class="form-control" rows="2">{{ old('description', $page->description) }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Serial No <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" name="serial_no" class="form-control only-number"
                            value="{{ old('serial_no', $page->serial_no) }}" autocomplete="off" required>
                    </div>
                </div>



            </div>
            <div class="col-md-6">

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Position<sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" name="position" class="form-control"
                            value="{{ old('seo_title', $page->position) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Status (Published)<sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="status" id="status" value="1"
                                {{ $page->status ? 'checked' : '' }} />
                            <label for="status" class="badge-primary"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label"></label>
                    <div class="col-sm-12 col-md-9">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-theme">
                                <i class="far fa-edit"></i>
                                UPDATE
                            </button>
                            <a class="btn btn-sm btn-yellow ml-1" href="{{ route('wc.pages.index') }}">
                                <i class="far fa-long-arrow-left"></i>
                                BACK TO LIST
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection





@section('js')
    <script>
        function handleKeyUp(e) {
            let pageNameValue = document.getElementById('pageName').value;
            console.log(pageNameValue)
            document.getElementById('slug').value = "/" + pageNameValue.replaceAll(" ", "-");
        }
    </script>
@endsection
