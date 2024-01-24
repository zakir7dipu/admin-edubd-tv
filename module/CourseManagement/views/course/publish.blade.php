@extends('layouts.master')

@section('title', 'Course Publish')


@section('style')
    @include('course/_inc/style')
    <style>
        input[readonly] {
            background: #e7f1ff !important; 
            border: 2px solid #e7f1ff !important
        }
    </style>
@endsection


@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-check-circle"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.courses.index') }}">Courses</a></li>
            <li class=""><a href="javascript:void(0)">Publish</a></li>
        </ul>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            @include('partials._alert_message')

            <div id="fuelux-wizard-container">
                @include('course/_inc/wizard-heading')
                <hr />
                
                <form action="{{ route('cm.courses.publish', $course->id ?? 0) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="step-pane active" data-step="9">
                        <div class="row publish">
                            <div class="col-sm-12 col-md-6 col-md-offset-3">
                                <div class="input-group mb-1" style="width: 100%">
                                    <span class="input-group-addon" style="width: 135px; text-align: left">Publish By <span style="color: red !important">*</span></span>
                                    <input type="text" class="form-control" value="{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}" readonly>
                                </div>
                                <div class="input-group mb-1" style="width: 100%">
                                    <span class="input-group-addon" style="width: 135px; text-align: left">Publish At <span style="color: red !important">*</span></span>
                                    <input type="datetime-local" name="published_at" class="form-control" id="coursePublishedAt" value="{{ $course->published_at != null && \Carbon\Carbon::now() > $course->published_at ? $course->published_at : \Carbon\Carbon::now() }}" required readonly>
                                    <input type="datetime-local" name="published_at" class="form-control" id="coursePublishedAtCustom" value="{{ \Carbon\Carbon::now() }}" disabled style="display: none">
                                </div>
                                @if ($course->published_at == null || \Carbon\Carbon::now() < $course->published_at)
                                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px;">
                                        <div class="material-switch">
                                            <input type="checkbox" onclick="courseAutoPublishToggle(this)" name="is_auto_published" id="isCourseAutoPublished" value="1" />
                                            <label for="isCourseAutoPublished" class="badge-primary"></label>
                                        </div>
                                        <label style="padding-top: 5px">Auto Publish</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="wizard-actions" style="display: flex; align-items: center; justify-content: space-between">
                        <a href="{{ route('cm.courses.upload', $course->id ?? 0) }}" class="btn btn-sm btn-prev">
                            <i class="ace-icon fa fa-arrow-left"></i>
                            PREVIOUS
                        </a>
                        @if ($course_id != 0)
                            @if (count($course->courseLessons) > 0)
                                <button type="submit" class="btn btn-sm btn-theme">
                                    {{ $course->is_published ? 'SAVE CHANGES' : 'PUBLISH' }}
                                    <i class="ace-icon far fa-check-circle icon-on-right"></i>
                                </button>
                            @endif
                        @else
                            <button onclick="alert('You can not publish this course because this course have no lesson. Please create lesson(s) then publish it!')" type="button" class="btn btn-sm btn-theme" style="background: #dfdfdf !important; border-color: #dfdfdf !important; color:rgb(76, 76, 76) !important">
                                PUBLISH
                                <i class="ace-icon far fa-check-circle icon-on-right"></i>
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection




@section('script')
    @include('course/_inc/script')
@endsection