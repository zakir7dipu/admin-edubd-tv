@extends('layouts.master')

@section('title', 'About')



@section('content')


    {{-- breadcrumbs section  --}}

    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Website CMS</a></li>
            <li><a class="text-muted" href="{{ route('wc.about.index') }}">About</a></li>
        </ul>
    </div>

    {{-- breadcrumbs end --}}




    {{-- form section  --}}

    <form action="{{ route('wc.about.update', $about->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('partials._alert_message')
        <div class="row mt-2">
            <div class="col-md-6">


                {{-- title --}}
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Title<sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="text" class="form-control" name="title" value="{{ old('title', $about->title) }}"
                            required>
                    </div>
                </div>



                {{-- short description  --}}

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Short Description <sup
                            style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <textarea name="short_description" class="form-control" rows="4">{{ old('short_description', $about->short_description) }}</textarea>
                    </div>
                </div>



                {{-- description  --}}

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Description <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $about->description) }}</textarea>
                    </div>
                </div>


                <hr>

                {{-- about countings --}}
                <h4 class="mb-2" style="color: black">About Count</h4>
                <div id="aboutCounting">
                    {{-- ADD DYNAMICALLY --}}
                    @if (old('title'))
                        @foreach (old('title') as $key => $title)
                            <div class="row aboutcount mb-1">
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <div class="input-group">
                                                <label class="input-group-addon"
                                                    style="background: #dfdfdf; color: #000000">Title <span
                                                        style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="count_title[]"
                                                    autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-5">
                                            <div class="input-group">
                                                <label class="input-group-addon"
                                                    style="background: #dfdfdf; color: #000000">Count <span
                                                        style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="count[]" autocomplete="off"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <i class="far fa-times-circle" onclick="removeCount(this)"
                                                style="font-size: 20px; color: red; padding-top: 7px; cursor: pointer"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @foreach ($about->aboutCounts as $counts)
                        <div class="row aboutcount mb-1">
                            <div class="col-sm-12 col-md-12">
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="input-group">
                                            <label class="input-group-addon"
                                                style="background: #dfdfdf; color: #000000">Title <span
                                                    style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="count_title[]"
                                                value="{{ $counts->title }}" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-5">
                                        <div class="input-group">
                                            <label class="input-group-addon"
                                                style="background: #dfdfdf; color: #000000">Count <span
                                                    style="color: red">*</span></label>
                                            <input type="text" class="form-control only-number" name="count[]"
                                                value="{{ $counts->count }}" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <i class="far fa-times-circle" onclick="removeCount(this)"
                                            style="font-size: 20px; color: red; padding-top: 7px; cursor: pointer"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>


                <button type="button"
                    style="padding: 4px 8px;
            border-radius: 5px;
            background: #bfffd4 !important;
            border: 2px solid #bfffd4;
            color: black;
            font-weight: 500"
                    onclick="addCount()" class="add-count">
                    <i class="far fa-plus-circle"></i> ADD Count
                </button>


            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Image<sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="file" name="image" class="form-control" autocomplete="off">
                        <p class="text-danger">Image size must be 400x500</p>
                        @if (file_exists($about->image) && $about->image != '')
                            <img src="{{ asset($about->image) }}" width="200px" height="200px" alt=""
                                class="img-thumbnail">
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Background Image <sup
                            style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="file" name="background_image" class="form-control" autocomplete="off">
                        <p class="text-danger">Image size must be 1050X450</p>
                        @if (file_exists($about->background_image) && $about->background_image != '')
                            <img src="{{ asset($about->background_image) }}" width="50%" height="100px"
                                alt="" class="img-thumbnail">
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





@section('js')
    @include('about/_inc/script')
@endsection
