@extends('layouts.master')

@section('title', 'Upload')


@section('style')
    @include('course/_inc/style')

@endsection


@section('content')
<style>
progress {
  width: 100%;
  height: 10px;
  appearance: none;
}

progress::-webkit-progress-bar {
  background-color: #cabbbb;
  border-radius: 10px;
}

progress::-webkit-progress-value {
  background-color: #4caf50;
  border-radius: 10px;
}

progress::-webkit-progress-value::before {
  content: attr(value) '%';
  position: absolute;
  right: 5px;
  color: white;
}

progress::-webkit-progress-value::after {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  height: 100%;
  width: calc((100% - attr(value) '%'));
  background-color: #ddd;
  border-radius: 10px;
}


</style>

    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-cloud-upload-alt"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.courses.index') }}">Courses</a></li>
            <li class=""><a href="javascript:void(0)">Upload</a></li>
        </ul>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            @include('partials._alert_message')

            <div id="fuelux-wizard-container">

                @include('course/_inc/wizard-heading')

                <hr>

                <div style="display: flex; flex-direction: column !important; gap: 20px; margin-block: 20px; color: #000000;">
                    @foreach ($courseLessons as $key=>$courseLesson)
                        <div class="upload-container">
                            <input type="hidden" class="course-lesson-id" value="{{ $courseLesson->id }}">
                            <h4><i class="far fa-book"></i> {{ $courseLesson->title }}</h4>
                            @if ($courseLesson->is_video)
                                <div class="upload-in-aws-div mb-1">
                                    <div class="preview-video">
                                        @if ($courseLesson->video)
                                            <video width="200" height="80" controls>
                                                <source src="{{ $courseLesson->video }}" type="video/mp4">
                                            </video>
                                        @else
                                            <img src="{{ asset('assets/img/video.png') }}" width="80" height="80" alt="{{ $courseLesson->title }}">
                                        @endif
                                    </div>

                                    <div style="width: 100%">
                                        <form id="uploadForm-{{$key}}" action="{{ route('cm.file-upload') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $courseLesson->id }}">
                                            <input id="videoInput-{{$key}}" type="file" class="file upload" name="video" accept="video/*" required>
                                            <div class="progress-wrapper">
                                                <progress id="progressBar-{{$key}}" value="0" max="100"></progress>
                                                <span id="progressPercent-{{$key}}">0%</span>
                                            </div>
                                            <button id="submitBtn-{{$key}}" class="btn-success btn-submit mt-2" type="button" onclick="uploadFile({{$key}})"><i class="far fa-check-circle"></i> Submit</button>
                                            <button id="submittingBtn-{{$key}}" class="btn-success btn-submit btn-submitting mt-2" disabled><i class="fas fa-spinner fa-spin"></i> Submitting...</button>
                                            <button id="successBtn-{{$key}}" class="btn-light btn-successed mt-2" style="display: none;"><i class="fas fa-check-circle"></i> Uploaded Successfully</button>
                                            <button id="failedBtn-{{$key}}" class="btn-light btn-failed mt-2" style="display: none;"><i class="fas fa-times-circle"></i> Failed to Submit</button>
                                        </form>


                                    </div>
                                </div>
                            @elseif ($courseLesson->is_attachment)
                                <div class="attachment-div mt-3 mb-1">
                                    <div class="attachment-initial-view">
                                        @if ($courseLesson->attachment)
                                            <a href="{{ getGoogleDriveUrl($courseLesson->attachment) }}" target="_blank">
                                                <img src="{{ asset('assets/img/pdf.png') }}" width="80" height="80" alt="{{ $courseLesson->title }}">
                                            </a>
                                        @else
                                            <img src="{{ asset('assets/img/no-pdf.webp') }}" width="80" height="80" alt="{{ $courseLesson->title }}">
                                        @endif
                                    </div>
                                    <div class="attachment-after-insert-or-update-view" style="display: none"></div>
                                    <div style="width: 100%">
                                        <form class="attachment-upload-form">
                                            <input type="hidden" name="course_id" value="{{ $courseLesson->id }}">
                                            <input type="file" name="attachment" class="file attachment" accept=".pdf" />
                                            <button class="btn-success btn-submit mt-2"><i class="far fa-check-circle"></i> Submit</button>
                                            <button class="btn-success btn-submit btn-submitting mt-2" disabled><i class="fas fa-spinner fa-spin"></i> Submitting...</button>
                                            <button class="btn-light btn-successed mt-2" disabled><i class="fas fa-check-circle"></i> Submitted Successfully</button>
                                            <button class="btn-light btn-failed mt-2" disabled><i class="fas fa-times-circle"></i> Failed to Submit</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div style="display: flex; align-items: center; justify-content: center">
                    @include('partials._paginate', ['data' => $courseLessons])
                </div>

                <hr />

                <div class="wizard-actions" style="display: flex; align-items: center; justify-content: space-between">
                    <a href="{{ route('cm.courses.lessons-update-or-create', $course_id) }}" class="btn btn-sm btn-prev">
                        <i class="ace-icon fa fa-arrow-left"></i>
                        PREVIOUS
                    </a>

                    <a href="{{ route('cm.courses.publish', $course_id) }}" class="btn btn-sm btn-theme">
                        NEXT
                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection





@section('script')
    @include('course/_inc/script')
@endsection
