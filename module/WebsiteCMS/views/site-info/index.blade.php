@extends('layouts.master')

@section('title', 'Site Infos')

@section('content')



    {{-- breadcrumbs section  --}}


    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Website CMS</a></li>
            <li><a class="text-muted" href="{{ route('wc.siteinfo.index') }}">Site Infos</a></li>
        </ul>
    </div>


    <form action="{{ route('wc.siteinfo.update', $siteinfo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('partials._alert_message')

        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Site Name <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="site_name" value="{{ old('site_name', $siteinfo->site_name) }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Site title <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="site_title" value="{{ old('site_title', $siteinfo->site_title) }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Email<sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="email" name="email" class="form-control" value="{{ old('email', $siteinfo->email) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Address <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <textarea name="address" class="form-control" rows="4">{{ old('address', $siteinfo->address) }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Phone<sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="number" name="phone" class="form-control" value="{{ old('phone', $siteinfo->phone) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Short Description</label>
                    <div class="col-sm-12 col-md-9">
                        <textarea name="short_description" class="form-control" rows="4">{{ old('short_description', $siteinfo->short_description) }}</textarea>
                    </div>
                </div>
            </div>



            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Fav Icon <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="file" name="fav_icon" class="form-control" {{ file_exists($siteinfo->fav_icon) && $siteinfo->fav_icon != '' ? '' : 'required' }} autocomplete="off">
                        <p class="text-danger">Image size must be 50X50</p>
                        @if (file_exists($siteinfo->fav_icon) && $siteinfo->fav_icon != '')
                            <img src="{{ asset($siteinfo->fav_icon) }}" width="50px" height="50px" alt="fav" class="img-thumbnail">
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Site Logo <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="file" name="logo" class="form-control" {{ file_exists($siteinfo->logo) && $siteinfo->logo != '' ? '' : 'required' }} autocomplete="off">
                        <p class="text-danger">Logo size must be 300X119</p>
                        @if (file_exists($siteinfo->logo) && $siteinfo->logo != '')
                            <img src="{{ asset($siteinfo->logo) }}" width="50%" height="100px" alt="logo" class="img-thumbnail">
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Transparent menu Logo <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="file" name="transparent_logo" class="form-control" {{ file_exists($siteinfo->transparent_logo) && $siteinfo->transparent_logo != '' ? '' : 'required' }} autocomplete="off">
                        <p class="text-danger">Logo size must be 300X119</p>
                        @if (file_exists($siteinfo->transparent_logo) && $siteinfo->transparent_logo != '')
                            <img src="{{ asset($siteinfo->transparent_logo) }}" width="50%" height="100px" alt="transparent_logo" class="img-thumbnail">
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Description</label>
                    <div class="col-sm-12 col-md-9">
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $siteinfo->description) }}</textarea>
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
    <script>
        function handleKeyUp(e) {
            let pageNameValue = document.getElementById('pageName').value;
            console.log(pageNameValue)
            document.getElementById('slug').value = "/" + pageNameValue.replaceAll(" ", "-");
        }
    </script>
@endsection
