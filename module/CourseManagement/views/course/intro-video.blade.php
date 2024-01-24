@extends('layouts.master')

@section('title', 'Intro Video')


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
            <li class=""><a href="javascript:void(0)">Intro Video</a></li>
        </ul>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            @include('partials._alert_message')

            <div id="fuelux-wizard-container">

                @include('course/_inc/wizard-heading')

                <hr>

                <div style="display: flex; flex-direction: column !important; gap: 20px; margin-block: 20px; color: #000000;">
                @if(!$course->id == 0)
                    <div class="intro-video-container">
                            <h4><i class="far fa-book"></i> Intro Video</h4>
                            <div class="mb-1" style="display: flex; align-items: center !important; gap: 20px">
                                <div class="radio" style="margin-top: 10px">
                                    <label style="padding-left: 10px;">
                                        <input 
                                            name="is_video_or_link" 
                                            value="0" 
                                            type="radio" 
                                            class="ace" 
                                            {{ $course->is_video_or_link == 0 ? 'checked' : '' }}
                                            onchange="toggleIntroVideoUpload(this, `{{ $course->id }}`)"
                                        >
                                        <span class="lbl"> Video Upload in AWS</span>
                                    </label>
                                </div>
                                <div class="radio"  style="margin-top: 10px">
                                    <label style="padding-left: 10px;">
                                        <input 
                                            name="is_video_or_link" 
                                            value="1" 
                                            type="radio" 
                                            class="ace" 
                                            {{ $course->is_video_or_link == 1 ? 'checked' : '' }}
                                            onchange="toggleIntroVideoUpload(this, `{{ $course->id }}`)"
                                        >
                                        <span class="lbl"> Youtube Embed Link</span>
                                    </label>
                                </div>
                                <div class="radio"  style="margin-top: 10px">
                                    <label style="padding-left: 10px;">
                                        <input 
                                            name="is_video_or_link" 
                                            value="2" 
                                            type="radio" 
                                            class="ace" 
                                            {{ $course->is_video_or_link== 2 ? 'checked' : '' }}
                                            onchange="toggleIntroVideoUpload(this, `{{ $course->id }}`)"
                                        >
                                        <span class="lbl"> Add Link</span>
                                    </label>
                                </div>
                            </div>
                                <div class="upload-in-aws-div mb-1">
                                    <div class="preview-video">
                                        @if ($course->intro_video)
                                            <video width="200" height="80" controls>
                                                <source src="{{ $course->intro_video }}" type="video/mp4">
                                            </video>
                                        @else
                                            <img src="{{ asset('assets/img/video.png') }}" width="80" height="80" alt="{{ $course->title }}">
                                        @endif
                                    </div>

                                    <div style="width: 100%">
                                        <form id="uploadForm" action="{{ route('cm.intor-file-upload') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $course->id }}">
                                            <input id="videoInput" type="file" class="file upload" name="intro_video" accept="video/*" required>
                                            <div class="progress-wrapper">
                                                <progress id="progressBar" value="0" max="100"></progress>
                                                <span id="progressPercent">0%</span>
                                            </div>
                                            <button id="submitBtn" class="btn-success btn-submit mt-2" type="button" onclick="introUploadFile()"><i class="far fa-check-circle"></i> Submit</button>
                                            <button id="submittingBtn" class="btn-success btn-submit btn-submitting mt-2" disabled><i class="fas fa-spinner fa-spin"></i> Submitting...</button>
                                            <button id="successBtn" class="btn-light btn-successed mt-2" style="display: none;"><i class="fas fa-check-circle"></i> Uploaded Successfully</button>
                                            <button id="failedBtn" class="btn-light btn-failed mt-2" style="display: none;"><i class="fas fa-times-circle"></i> Failed to Submit</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="video-link-div mb-1" style="display: none">
                                    <div class="preview-youtube-embed-link">
                                        @if ($course->intro_video)
                                        <video width="200" height="80" src="{{ $course->intro_video }}"controls>
                                            <source src="{{ $course->intro_video }}" type="video/mp4">
                                        </video>                                        
                                        @else
                                            <img src="{{ asset('assets/img/video.png') }}" width="80" height="80" alt="">
                                        @endif
                                    </div>
                                    <div style="width: 100%">
                                        <div class="input-group width-100" style="width: 100%">
                                            <span class="input-group-addon" style="text-align: left">
                                                https://www.youtube.com/embed/
                                            </span>
                                            @php
                                                $embedId = explode('https://www.youtube.com/embed/', $course->intro_video);
                                            @endphp
                                            <input type="url" class="form-control youtube-embed-link" value="{{ isset($embedId[1]) ? $embedId[1] : '' }}" placeholder="Enter Youtube Embed Link">
                                        </div>
                                        <button onclick="updateOrAddYoutubeEmbedLinkInIntroVideo(this, `{{ $course->id }}`, `{{ $course->title }}`)" class="btn-success btn-submit mt-2"><i class="far fa-check-circle"></i> Submit</button>
                                        <button class="btn-success btn-submit btn-submitting mt-2" disabled><i class="fas fa-spinner fa-spin"></i> Submitting...</button>
                                        <button class="btn-light btn-successed mt-2" disabled><i class="fas fa-check-circle"></i> Submitted Successfully</button>
                                        <button class="btn-light btn-failed mt-2" disabled><i class="fas fa-times-circle"></i> Failed to Submit</button>
                                    </div>
                                </div>
                                <div class="all-link-div mb-1" style="display: none">
                                    <div class="preview-all-link">
                                        @if ($course->intro_video)
                                        <video width="200" height="80" src="{{ $course->intro_video }}"controls>
                                            <source src="{{ $course->intro_video }}" type="video/mp4">
                                        </video>                                        
                                        @else
                                            <img src="{{ asset('assets/img/video.png') }}" width="80" height="80" alt="{{ $course->title }}">
                                        @endif
                                    </div>
                                    <div style="width: 100%">
                                        <div class="input-group width-100" style="width: 100%">
                                            <span class="input-group-addon" style="text-align: left">
                                                Add Link
                                            </span>
                                            <input type="url" class="form-control all-link" value="{{$course->intro_video}}" placeholder="Enter Link">
                                        </div>
                                        <button onclick="updateOrAddLinkInIntroVideo(this, `{{ $course->id }}`, `{{ $course->title }}`)" class="btn-success btn-submit mt-2"><i class="far fa-check-circle"></i> Submit</button>
                                        <button class="btn-success btn-submit btn-submitting mt-2" disabled><i class="fas fa-spinner fa-spin"></i> Submitting...</button>
                                        <button class="btn-light btn-successed mt-2" disabled><i class="fas fa-check-circle"></i> Submitted Successfully</button>
                                        <button class="btn-light btn-failed mt-2" disabled><i class="fas fa-times-circle"></i> Failed to Submit</button>
                                    </div>
                                </div>
                        </div>
                @endif
                </div>

                <hr />

                <div class="wizard-actions" style="display: flex; align-items: center; justify-content: space-between">
                    <a 
                        @if ($course_id)
                            href="{{ route('cm.courses.edit', $course_id) }}" 
                        @else
                            href="{{ route('cm.courses.create') }}" 
                        @endif
                        
                        class="btn btn-sm btn-prev"
                    >
                        <i class="ace-icon fa fa-arrow-left"></i>
                        PREVIOUS
                    </a>
                
                    <a href="{{ route('cm.courses.introductions-update-or-create', $course_id) }}" class="btn btn-sm btn-theme">
                        NEXT
                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection





@section('script')
<script type="text/javascript" defer>
      $(document).ready(function() {
        const radioButtons = $('input[name="tinyint[{{ $course->id ?? 0 }}]"]');
        const courseId = "{{ $course->id ?? 0 }}";
        
        radioButtons.each(function() {
            if ($(this).is(':checked')) {
                toggleVideoUpload(this, courseId);
                return false; 
            }
        });
    });
</script>
    @include('course/_inc/script')
@endsection
