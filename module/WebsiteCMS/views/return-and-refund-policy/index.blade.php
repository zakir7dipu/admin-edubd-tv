@extends('layouts.master')

@section('title', 'Return and Refund Policy')

@section('content')



    {{-- breadcrumbs section  --}}


    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Website CMS</a></li>
            <li><a class="text-muted" href="{{ route('wc.return-refund-policy.index') }}">Return and Refund Policy </a></li>
        </ul>
    </div>


    <form action="{{ route('wc.return-refund-policy.update', optional($returnAndRefund)->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('partials._alert_message')

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Description</label>
                    <div class="col-sm-12 col-md-12">
                        <textarea name="description" class="form-control ckeditor" rows="4">{{ old('description', $returnAndRefund->description) }}</textarea>
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
