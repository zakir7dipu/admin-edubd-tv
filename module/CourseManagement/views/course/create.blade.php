@extends('layouts.master')

@section('title', 'Create Course')


@section('style')
    @include('course/_inc/style')
@endsection


@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.courses.index') }}">Courses</a></li>
            <li class=""><a href="javascript:void(0)">Create</a></li>
        </ul>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            @include('partials._alert_message')

            <div id="fuelux-wizard-container">
                @include('course/_inc/wizard-heading')
                <hr />

                <form action="{{ route('cm.courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="step-pane active" data-step="1">
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">Course Title <span style="color: red !important">*</span></label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" class="form-control" name="course_title" id="name" value="{{ old('course_title') }}" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">Course Slug <span style="color: red !important">*</span></label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" class="form-control" name="course_slug" id="slug" value="{{ old('course_slug') }}" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">Short Description <span style="color: red !important">*</span></label>
                                    <div class="col-sm-12 col-md-8">
                                        <textarea name="course_short_description" class="form-control" rows="4" required autocomplete="off">{{ old('course_short_description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">Course Category <span style="color: red !important">*</span></label>
                                    <div class="col-sm-12 col-md-8">
                                        <select name="course_category_id" class="form-control select2" data-placeholder="- Select -" width="100%" required>
                                            <option></option>
                                            <x-course-category.course-category-options />
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">Course Type <span style="color: red !important">*</span></label>
                                    <div class="col-sm-12 col-md-8">
                                        <select name="course_type" class="form-control select2" data-placeholder="- Select -" width="100%" required>
                                            <option></option>
                                            @foreach (courseTypes() as $type)
                                                <option value="{{ $type }}" {{ old('course_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">Course Level <span style="color: red !important">*</span></label>
                                    <div class="col-sm-12 col-md-8">
                                        <select name="course_level_id" class="form-control select2" data-placeholder="- Select -" width="100%" required>
                                            <option></option>
                                            @foreach ($courseLevels as $id => $name)
                                                <option value="{{ $id }}" {{ old('course_level_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">Course Language <span style="color: red !important">*</span></label>
                                    <div class="col-sm-12 col-md-8">
                                        <select name="course_language_id" class="form-control select2" data-placeholder="- Select -" width="100%" required>
                                            <option></option>
                                            @foreach ($courseLanguages as $language)
                                                <option
                                                    value="{{ $language->id }}"
                                                    @if (old('course_language_id') == $language->id)
                                                        selected
                                                    @elseif ($language->is_default)
                                                        selected
                                                    @endif
                                                >
                                                    {{ $language->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">Regular Fee <span style="color: red !important">*</span></label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" class="form-control only-number" id="regularFee" name="regular_fee" value="{{ old('regular_fee', 0) }}" onkeyup="calculateCourseFee('regularFee')" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">Discount Amount</label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" class="form-control only-number" id="discountAmount" name="discount_amount" value="{{ old('discount_amount', 0) }}" onkeyup="calculateCourseFee('discount')" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">Course Fee <span style="color: red !important">*</span></label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" class="form-control only-number" id="courseFee" name="course_fee" value="{{ old('course_fee', 0) }}" readonly required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-12 col-md-4 col-form-label">
                                        Thumbnail Image <span style="color: red !important">*</span>
                                    </label>
                                    <div class="col-sm-12 col-md-8">
                                        <div style="display: flex; justify-content:space-between">
                                            <div style="line-height: 0px">
                                                <input type="file" name="thumbnail_image" accept="image/webp, image/png, image/gif, image/jpg, image/jpeg" required>
                                                <small class="text-danger">Thumbnail Image size must be 450 x 400.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-12 col-md-4 col-form-label">
                                        Thumbnail Image Big <span style="color: red !important">*</span>
                                    </label>
                                    <div class="col-sm-12 col-md-8">
                                        <div style="display: flex; justify-content:space-between">
                                            <div style="line-height: 0px">
                                                <input type="file" name="thumbnail_image_big" accept="image/webp, image/png, image/gif, image/jpg, image/jpeg" required>
                                                <small class="text-danger">Thumbnail Image size must be 400 x 592.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">
                                        Intro Video <span style="color: red !important">*</span>
                                    </label>
                                    <div class="col-sm-12 col-md-8">
                                        <div class="input-group width-100" style="width: 100%">
                                            <span class="input-group-addon" style="text-align: left; font-size: 11.5px">
                                                https://www.youtube.com/embed/
                                            </span>
                                            <input type="text" class="form-control" name="intro_video" placeholder="Video ID" autocomplete="off">
                                        </div>
                                        {{-- <input type="url" name="intro_video" class="form-control" value="{{ old('intro_video') }}" required> --}}
                                    {{-- </div> --}}
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">Certificate</label>
                                    <div class="col-sm-12 col-md-8">
                                        <div class="material-switch" style="margin-top: 6px">
                                            <input type="checkbox" name="is_certificate" id="isCertificate" value="1" {{ old('is_certificate') ? 'checked' : '' }} />
                                            <label for="isCertificate" class="badge-primary"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">Set Popular</label>
                                    <div class="col-sm-12 col-md-8">
                                        <div class="material-switch" style="margin-top: 6px">
                                            <input type="checkbox" name="is_popular" id="isPopular" value="1" {{ old('is_popular') ? 'checked' : '' }} />
                                            <label for="isPopular" class="badge-primary"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label class="col-sm-12 col-md-4 col-form-label">Use for Slider</label>
                                    <div class="col-sm-12 col-md-8">
                                        <div class="material-switch" style="margin-top: 6px">
                                            <input type="checkbox" name="is_slider" id="isSlider" value="1" {{ old('is_slider') ? 'checked' : '' }} />
                                            <label for="isSlider" class="badge-primary"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row">
                                    @if (old('tag_id'))
                                        @foreach ($tags as $id => $name)
                                            <div class="col-xs-12 col-sm-6 col-md-4 mb-2">
                                                <div class="checkbox" style="margin-block: 0px !important">
                                                    <label style="padding-left: 10px;">
                                                        <input type="checkbox" name="tag_id[]" value="{{ $id }}" {{ in_array($id, old('tag_id')) ? 'checked' : '' }} class="ace">
                                                        <span class="lbl"> {{ $name }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach ($tags as $id => $name)
                                            <div class="col-xs-12 col-sm-6 col-md-4 mb-2">
                                                <div class="checkbox" style="margin-block: 0px !important">
                                                    <label style="padding-left: 10px;">
                                                        <input type="checkbox" name="tag_id[]" value="{{ $id }}" class="ace">
                                                        <span class="lbl"> {{ $name }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="wizard-actions" style="display: flex; align-items: center; justify-content: space-between">
                        <a href="{{ route('cm.courses.index') }}" class="btn btn-sm btn-prev">
                            <i class="ace-icon fa fa-arrow-left"></i>
                            BACK TO LIST
                        </a>
                    
                        <button type="submit" class="btn btn-sm btn-theme">
                            SAVE & NEXT
                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                        </button>
                    </div>                </form>
            </div>
        </div>
    </div>
@endsection




@section('script')
    @include('course/_inc/script')
@endsection
