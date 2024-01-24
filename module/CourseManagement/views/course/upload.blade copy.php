@extends('layouts.master')

@section('title', 'Upload')


@section('style')
    @include('course/_inc/style')
    
@endsection


@section('content')
<style>
    #progressBar {
    width: 100%;
    height: 10px;
    margin-top: 10px;
    display: block;
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
                    @foreach ($courseLessons as $courseLesson)
                        <div class="upload-container">
                            <input type="hidden" class="course-lesson-id" value="{{ $courseLesson->id }}">
                            <h4><i class="far fa-book"></i> {{ $courseLesson->title }}</h4>
                            @if ($courseLesson->is_video)
                                <div class="mb-1" style="display: flex; align-items: center !important; gap: 20px">
                                    {{-- <div class="radio">
                                        <label style="padding-left: 10px;">
                                            <input 
                                                name="is_youtube_embed_link[{{ $courseLesson->id }}]" 
                                                value="1" 
                                                type="radio" 
                                                class="ace" 
                                                {{ $courseLesson->is_youtube_embed_link ? 'checked' : '' }}
                                                onchange="toggleVideoUpload(this, `{{ $courseLesson->id }}`)"
                                            >
                                            <span class="lbl"> Youtube Embed Link</span>
                                        </label>
                                    </div> --}}
                                    <div class="radio" style="margin-top: 10px">
                                        <label style="padding-left: 10px;">
                                            {{-- <input 
                                                name="vedeo" 
                                                value="0" 
                                                type="radio" 
                                                class="ace" 
                                                {{ !$courseLesson->is_youtube_embed_link ? 'checked' : '' }}
                                                onchange="toggleVideoUpload(this, `{{ $courseLesson->id }}`)"
                                            > --}}
                                            <span class="lbl"> Video Upload in AWS</span>
                                        </label>
                                    </div>
                                </div>
                                {{-- <div class="video-link-div mb-1">
                                    <div class="preview-youtube-embed-link">
                                        @if ($courseLesson->video)
                                            <iframe width="80" height="80" src="{{ $courseLesson->video }}" title="{{ $courseLesson->title }}" frameborder="0" allowfullscreen></iframe>
                                        @else
                                            <img src="{{ asset('assets/img/video.png') }}" width="80" height="80" alt="{{ $courseLesson->title }}">
                                        @endif
                                    </div>
                                    <div style="width: 100%">
                                        <div class="input-group width-100" style="width: 100%">
                                            <span class="input-group-addon" style="text-align: left">
                                                https://www.youtube.com/embed/
                                            </span>
                                            @php
                                                $embedId = explode('https://www.youtube.com/embed/', $courseLesson->video);
                                            @endphp
                                            <input type="url" class="form-control youtube-embed-link" value="{{ isset($embedId[1]) ? $embedId[1] : '' }}" placeholder="Enter Youtube Embed Link">
                                        </div>
                                        <button onclick="updateOrAddYoutubeEmbedLinkInVideo(this, `{{ $courseLesson->id }}`, `{{ $courseLesson->title }}`)" class="btn-success btn-submit mt-2"><i class="far fa-check-circle"></i> Submit</button>
                                        <button class="btn-success btn-submit btn-submitting mt-2" disabled><i class="fas fa-spinner fa-spin"></i> Submitting...</button>
                                        <button class="btn-light btn-successed mt-2" disabled><i class="fas fa-check-circle"></i> Submitted Successfully</button>
                                        <button class="btn-light btn-failed mt-2" disabled><i class="fas fa-times-circle"></i> Failed to Submit</button>
                                    </div>
                                </div> --}}
                                <div class="upload-in-aws-div mb-1">
                                    <div class="preview-video">
                                        @if ($courseLesson->video)
                                            <video width="80" height="80" src="{{ $courseLesson->video }}" title="{{ $courseLesson->title }}" frameborder="0" allowfullscreen></video>
                                        @else
                                            <img src="{{ asset('assets/img/video.png') }}" width="80" height="80" alt="{{ $courseLesson->title }}">
                                        @endif
                                    </div>
                                    <div style="width: 100%">
                                        <form id="uploadForm" action="{{ route('cm.file-upload') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $courseLesson->id }}">
                                            <input type="file" class="file upload" name="video" accept="video/*" required>
                                            <progress id="progressBar" value="0" max="100"></progress>
                                            <button id="submitBtn" class="btn-success btn-submit mt-2" onclick="uploadFile()"><i class="far fa-check-circle"></i> Submit</button>
                                            <button id="submittingBtn" class="btn-success btn-submit btn-submitting mt-2" disabled><i class="fas fa-spinner fa-spin"></i> Submitting...</button>
                                            <button id="successBtn" class="btn-light btn-successed mt-2" disabled><i class="fas fa-check-circle"></i> Submitted Successfully</button>
                                            <button id="failedBtn" class="btn-light btn-failed mt-2" disabled><i class="fas fa-times-circle"></i> Failed to Submit</button>
                                        </form>  
                                        {{-- <progress id="progressBar" value="0" max="100" style="display: none;"></progress>                                      --}}
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
