@extends('layouts.master')

@section('title', 'Upload')


@section('style')
    @include('course/_inc/style')
    
    <style>

        .upload-container {
            display: flex; 
            flex-direction: column !important;
            box-shadow: rgba(33, 35, 38, 0.1) 0px 10px 10px -10px;
            padding: 10px 0px;
        }

        .upload-input {
            height: 0px !important;
            overflow: hidden;
        }

        label {
            display: flex; 
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 15px;
            height: 100px;
        }

        .upload-input + label.upload-label {
            border: 2px #e9e9e9 dashed;
            overflow: hidden;
            font-size: 13px;
        }

        .upload-input + label.upload-label:hover {
            border: 2px #4338ca dashed;
            background: #f8fafc;
            color: #3730a3;
            cursor: pointer;
            font-weight: 500;
        }

        [type="hidden"] + label.upload-label {
            background: #f8fafc;
            border: 2px #4338ca dashed;
            color: #3730a3;
            font-weight: 500;
        }

        [type="hidden"] + label.upload-label:hover {
            cursor: not-allowed;
            border: 2px #4338ca dashed;
        }

        .upload-label-completed {
            border: 2px #059669 dashed !important;
            color: #065f46 !important;
        }

        .upload-label-waiting {
            border: 2px #f97316 dashed !important;
            color: #f97316 !important;
        }

        .progress {
            background: #f3f4f6;
            border-radius: 10px;
            margin-bottom: 10px !important;
        }

        .progress-bar {
            background-color: #4338ca;
        }

        .progress-bar-finished {
            background-color: #059669;
        }
    </style>
@endsection


@section('content')
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
                    {{-- <div class="container pt-4">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h5>Upload File</h5>
                                    </div>
                    
                                    <div class="card-body">
                                        <div id="upload-container" class="text-center">
                                            <button id="browseFile" class="btn btn-primary">Brows File</button>
                                        </div>
                                        <div  style="display: none" class="progress mt-3" style="height: 25px">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%; height: 100%">75%</div>
                                        </div>
                                    </div>
                    
                                    <div class="card-footer p-4" style="display: none">
                                        <video id="videoPreview" src="" controls style="width: 100%; height: auto"></video>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    @foreach ($courseLessons as $courseLesson)
                        <div class="upload-container">
                            <h4><i class="far fa-book"></i> {{ $courseLesson->title }} {{ $courseLesson->id }}</h4>

                            @if ($courseLesson->is_video && $courseLesson->video)
                                <div class="my-1">
                                    <a class="btn btn-sm" target="_blank" style="background: #4338ca !important; border:2px solid #4338ca; width: fit-content" href="{{ asset('assets/uploads/video/mov_bbb.mp4') }}"><i class="far fa-video"></i> &nbsp; Play Video</a>
                                    <a class="btn btn-sm" style="background: #f32641 !important; border:2px solid #f32641; width: fit-content" href="javascript:void(0)"><i class="far fa-trash"></i> &nbsp; Delete Video</a>
                                </div>
                                <h4><i class="far fa-book"></i> This is an Attachment Lesson</h4>
                            @elseif ($courseLesson->is_attachment && $courseLesson->attachment)
                                <div class="my-1">
                                    <a class="btn btn-sm" target="_blank" style="background: #4338ca !important; border:2px solid #4338ca; width: fit-content" href="{{ asset('assets/uploads/video/mov_bbb.mp4') }}"><i class="far fa-video"></i> &nbsp; Show Attachment</a>
                                    <a class="btn btn-sm" style="background: #f32641 !important; border:2px solid #f32641; width: fit-content" href="javascript:void(0)"><i class="far fa-trash"></i> &nbsp; Delete Attachment</a>
                                </div>
                            @elseif ($courseLesson->is_video && !$courseLesson->video)
                                <div>
                                    <input type="file" class="upload-input" name="video[]" id="file" />
                                    <label for="file" class="upload-label"><i class="far fa-video"></i> Upload Video</label>
                                </div>
                                <div>
                                    <input type="hidden" class="upload-input" id="file3" />
                                    <label for="file3" class="upload-label"><i class="fas fa-spinner fa-spin"></i> Uploading...</label>
                                </div>
                                <div>
                                    <input type="hidden" class="upload-input upload-input-waiting" id="file3" />
                                    <label for="file3" class="upload-label upload-label-waiting"><i class="far fa-spinner-third fa-spin"></i> Waiting...</label>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                </div>
                            @elseif ($courseLesson->is_attachment && !$courseLesson->attachment)
                                <div>
                                    <input type="file" class="upload-input" name="attachment[]" id="file" />
                                    <label for="file" class="upload-label"><i class="far fa-paperclip"></i> Upload Attachment</label>
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
                    <a href="{{ route('cm.courses.topics-update-or-create', $course_id) }}" class="btn btn-sm btn-prev">
                        <i class="ace-icon fa fa-arrow-left"></i>
                        PREVIOUS
                    </a>
                
                    <button type="submit" class="btn btn-sm btn-theme">
                        SAVE & NEXT
                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- <div class="upload-container">
    <h4><i class="far fa-book"></i> This is an Attachment Lesson</h4>
    <div class="my-1">
        <a class="btn btn-sm" target="_blank" style="background: #4338ca !important; border:2px solid #4338ca; width: fit-content" href="{{ asset('assets/uploads/video/mov_bbb.mp4') }}"><i class="far fa-video"></i> &nbsp; Play Video</a>
        <a class="btn btn-sm" style="background: #f32641 !important; border:2px solid #f32641; width: fit-content" href="javascript:void(0)"><i class="far fa-trash"></i> &nbsp; Delete Video</a>
    </div>
</div>
<div class="upload-container">
    <h4><i class="far fa-book"></i> This is a Video Lesson</h4>
    <div>
        <input type="file" class="upload-input" id="file" />
        <label for="file" class="upload-label"><i class="far fa-video"></i> Upload Video</label>
    </div>
</div>
<div class="upload-container">
    <h4><i class="far fa-book"></i> This is a Video Lesson</h4>
    <div>
        <input type="file" class="upload-input" id="file" />
        <label for="file" class="upload-label"><i class="far fa-video"></i> Upload Video</label>
    </div>
</div>
<div class="upload-container">
    <h4><i class="far fa-book"></i> This is an Attachment Lesson</h4>
    <div>
        <input type="file" class="upload-input" id="file2" />
        <label for="file2" class="upload-label"><i class="far fa-paperclip"></i> Upload Attachment</label>
    </div>
</div>
<div class="upload-container">
    <h4><i class="far fa-book"></i> This is an Attachment Lesson</h4>
    <div>
        <input type="hidden" class="upload-input" id="file3" />
        <label for="file3" class="upload-label"><i class="fas fa-spinner fa-spin"></i> Uploading...</label>
    </div>
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
    </div>
</div>
<div class="upload-container">
    <h4><i class="far fa-book"></i> This is an Attachment Lesson</h4>
    <div>
        <input type="hidden" class="upload-input" id="file3" />
        <label for="file3" class="upload-label upload-label-completed"><i class="far fa-check-circle"></i> Completed</label>
    </div>
    <div class="progress">
        <div class="progress-bar progress-bar-finished" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
    </div>
</div> --}}


@section('script')
    @include('course/_inc/script')

    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

    <script>
        var currentUploadID = null;
        var uploadIds       = [];
        var completedIds    = [];
    </script>


    <script>
        let browseFile = $('#browseFile');
            let resumable = new Resumable({
                target: `{{ route('cm.file-upload') }}`,
                query:{_token:'{{ csrf_token() }}'},
                fileType: ['mp4'],
                chunkSize: 1024*1024,
                headers: {
                    'Accept' : 'application/json'
                },
                testChunks: false,
                throttleProgressCallbacks: 1,
            });

            resumable.assignBrowse(browseFile[0]);

            resumable.on('fileAdded', function (file) {
                showProgress();
                resumable.upload()
            });

            resumable.on('fileProgress', function (file) {
                updateProgress(Math.floor(file.progress() * 100));
            });

            resumable.on('fileSuccess', function (file, response) {
                response = JSON.parse(response)
                $('#videoPreview').attr('src', response.path);
                $('.card-footer').show();
            });

            resumable.on('fileError', function (file, response) {
                alert('file uploading error.')
            });

            let progress = $('.progress');
            function showProgress() {
                progress.find('.progress-bar').css('width', '0%');
                progress.find('.progress-bar').html('0%');
                progress.find('.progress-bar').removeClass('bg-success');
                progress.show();
            }

            function updateProgress(value) {
                progress.find('.progress-bar').css('width', `${value}%`)
                progress.find('.progress-bar').html(`${value}%`)
            }

            function hideProgress() {
                progress.hide();
            }
    </script>
@endsection
