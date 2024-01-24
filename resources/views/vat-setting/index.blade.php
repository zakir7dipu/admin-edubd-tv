@extends('layouts.master')

@section('title', 'Vat Setting')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-percentage"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="{{ route('vat-settings') }}">Vat Setting</a></li>
        </ul>
    </div>


    <form action="{{ route('vat-settings') }}" method="POST">
        @csrf
        @include('partials._alert_message')

        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Percentage</label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control only-number" name="percentage" value="{{ old('value', optional($vatSetting)->percentage) }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Status</label>
                    <div class="col-sm-12 col-md-9">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="status" id="status" value="1" {{ optional($vatSetting)->status ? 'checked' : '' }} />
                            <label for="status" class="badge-primary"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label"></label>
                    <div class="col-sm-12 col-md-9">
                        <div class="btn-group" style="margin-top:15px">
                            <button class="btn btn-sm btn-theme">
                                <i class="far fa-edit"></i>
                                UPDATE
                            </button>
                        </div>
                    </div>
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
