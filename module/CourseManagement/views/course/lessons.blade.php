@extends('layouts.master')

@section('title', 'Course Lessons')


@section('style')
    @include('course/_inc/style')
@endsection


@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-book"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.courses.index') }}">Courses</a></li>
            <li class=""><a href="javascript:void(0)">Lessons</a></li>
        </ul>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            @include('partials._alert_message')

            <div id="fuelux-wizard-container">
                @include('course/_inc/wizard-heading')
                <hr />

                <form action="{{ route('cm.courses.lessons-update-or-create', $course_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="step-pane active" data-step="8">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div id="accordion" class="lessons accordion-style1 panel-group accordion-style2">
                                    @foreach ($courseLessons as $key => $courseLesson)
                                        <div class="lesson-panel panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key . '-' . $courseLesson->id }}" aria-expanded="false">
                                                        <i class="bigger-110 ace-icon fa fa-angle-right" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                        &nbsp;
                                                        <span class="accordion-title">{{ $courseLesson->title }}</span>
                                                    </a>
                                                </h4>
                                                <i onclick="delete_item(`{{ route('cm.delete-lesson', $courseLesson->id) }}`)" class="far fa-trash remove-lesson"></i>
                                            </div>
                                            <div class="panel-collapse collapse" id="collapse{{ $key . '-' . $courseLesson->id }}" aria-expanded="false">
                                                <div class="panel-body">
                                                    <div class="lesson">
                                                        <input type="hidden" name="course_lesson_id[]" value="{{ $courseLesson->id }}">
                                                        <div class="input-group" style="width: 100%">
                                                            <span class="input-group-addon" style="width: 135px; text-align: left">Course Topic <span style="color: red !important">*</span></span>
                                                            <select name="course_lesson_course_topic_id[]" class="form-control select2" data-placeholder="- Select Topic -" style="width: 100%" required>
                                                                <option></option>
                                                                @foreach ($courseTopics as $id => $title)
                                                                    <option value="{{ $id }}" {{ $courseLesson->course_topic_id == $id ? 'selected' : '' }}>{{ $title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="input-group" style="width: 100%">
                                                            <span class="input-group-addon" style="width: 135px; text-align: left">Lesson Title <span style="color: red !important">*</span></span>
                                                            <input type="text" class="form-control" onkeyup="setLessonTitle(this)" name="course_lesson_title[]" value="{{ $courseLesson->title }}" required autocomplete="off">
                                                        </div>
                                                        <div class="input-group" style="width: 100%; display: flex; align-items: center;">
                                                            <span class="input-group-addon" style="width: 155px; text-align: left; height: 35px; line-height: 20px">Duration <span style="color: red !important">*</span></span>
                                                            <input type="text" class="form-control duration" name="course_lesson_duration[]" value="{{ $courseLesson->duration }}" required autocomplete="off" placeholder="HH:MM:SS">
                                                            <i class="fas fa-info-circle" title="ex: HH:MM:SS ⇒ 00:10:11" data-toggle="tooltip" style="cursor: help; color: #696969; margin-left: 5px"></i>
                                                        </div>
                                                        @php
                                                            $isVideo = $courseLesson->is_video;

                                                            $isAttachment = $courseLesson->is_attachment;
                                                            $courseAttachmentExist = $isAttachment && !file_exists($courseLesson->attachment);
                                                        @endphp
                                                        <div style="display: flex; align-items: center; gap: 50px; width: 100%">
                                                            <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px;">
                                                                <div class="material-switch">
                                                                    <input type="hidden" class="lesson-no-video" name="lesson_is_video[]" value="0" {{ $isVideo ? 'disabled' : '' }} />
                                                                    <input type="checkbox" onclick="lessonIsVideoToggle(this)" class="lesson-is-video" name="lesson_is_video[]" id="lessonIsVideo{{ $key . '-' . $courseLesson->id }}" value="1" {{ $isVideo ? 'checked' : '' }} />
                                                                    <label for="lessonIsVideo{{ $key . '-' . $courseLesson->id }}" class="badge-primary"></label>
                                                                </div>
                                                                <label style="padding-top: 5px">Video</label>
                                                            </div>
                                                            <div style="display: flex !important; align-items: center !important; justify-content: space-between !important; width: calc(100% - 150px)">
                                                                {{-- <input type="url" class="form-control lesson-video width-50" name="lesson_video[]" value="{{ $courseLesson->video }}" {{ !$isAttachment && $isVideo ? 'required' : '' }} style="display: {{ $isAttachment ? 'none' : '' }}" placeholder="Enter video link"> --}}
                                                                <i class="fas fa-info-circle lesson-video-note" title="If you wanna add video instead of attachment please active video for enable this field." data-toggle="tooltip" style="cursor: help; color: #696969; display: {{ $courseLesson->is_video ? 'none' : '' }}"></i>
                                                                {{-- @if ($isVideo)
                                                                    <a href="{{ asset($courseLesson->video) }}" target="_blank" style="font-weight: 500; text-decoration: none;"><i class="far fa-play"></i> Play</a>
                                                                @endif --}}
                                                            </div>
                                                        </div>
                                                        <div style="display: flex; align-items: center; gap: 50px; width: 100%">
                                                            <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px;">
                                                                <div class="material-switch">
                                                                    <input type="hidden" class="lesson-no-attachment" name="lesson_is_attachment[]" value="0" {{ $isAttachment ? 'disabled' : '' }} />
                                                                    <input type="checkbox" onclick="lessonIsAttachmentToggle(this)" class="lesson-is-attachment" name="lesson_is_attachment[]" id="lessonIsAttachment{{ $key . '-' . $courseLesson->id }}" value="1" {{ $isAttachment ? 'checked' : '' }} />
                                                                    <label for="lessonIsAttachment{{ $key . '-' . $courseLesson->id }}" class="badge-primary"></label>
                                                                </div>
                                                                <label style="padding-top: 5px">Attachment</label>
                                                            </div>
                                                            <div style="display: flex !important; align-items: center !important; justify-content: space-between !important; width: calc(100% - 150px)">
                                                                {{-- <input type="file" class="lesson-attachment pt-1" name="lesson_attachment[]" {{ !$isVideo && $courseAttachmentExist ? 'required' : '' }} style="display: {{ $isVideo ? 'none' : '' }}"> --}}
                                                                <i class="fas fa-info-circle lesson-attachment-note" title="If you wanna add attachment instead of video please active attachment for enable this field." data-toggle="tooltip" style="cursor: help; color: #696969; display: {{ $courseLesson->is_attachment ? 'none' : '' }}"></i>
                                                                {{-- @if ($isAttachment && file_exists($courseLesson->attachment))
                                                                    <a href="{{ asset($courseLesson->attachment) }}" target="_blank" style="font-weight: 500; text-decoration: none;"><i class="far fa-paperclip"></i> Attachment</a>
                                                                @endif --}}
                                                            </div>
                                                        </div>
                                                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; width: 100%">
                                                            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%">
                                                                @if (!$courseLesson->is_published)
                                                                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 200px;">
                                                                        <div class="material-switch">
                                                                            <input type="hidden" class="lesson-not-published" name="lesson_is_published[]" value="0" {{ $courseLesson->is_published ? 'disabled' : '' }} />
                                                                            <input type="checkbox" onclick="lessonIsPublishToggle(this)" class="lesson-is-published" name="lesson_is_published[]" id="lessonIsPublished{{ $key . '-' . $courseLesson->id }}" value="1" {{ $courseLesson->is_published ? 'checked' : '' }} />
                                                                            <label for="lessonIsPublished{{ $key . '-' . $courseLesson->id }}" class="badge-primary"></label>
                                                                        </div>
                                                                        <label style="padding-top: 5px">Publish</label>
                                                                    </div>
                                                                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 200px">
                                                                        <div class="material-switch">
                                                                            <input type="hidden" class="lesson-not-auto-published" name="lesson_is_auto_published[]" value="0" {{ $courseLesson->is_auto_published ? 'disabled' : '' }} />
                                                                            <input type="checkbox" onclick="lessonIsAutoPublishToggle(this)" class="lesson-is-auto-published" name="lesson_is_auto_published[]" id="lessonIsAutoPublished{{ $key . '-' . $courseLesson->id }}" value="1" {{ $courseLesson->is_auto_published ? 'checked' : '' }} />
                                                                            <label for="lessonIsAutoPublished{{ $key . '-' . $courseLesson->id }}" class="badge-primary"></label>
                                                                        </div>
                                                                        <label style="padding-top: 5px">Auto Publish</label>
                                                                        <i class="fas fa-info-circle lesson-auto-publish-note" title="If you wanna enable auto publish it will show published at field which is required. Note: it will be disable publish field also!" data-toggle="tooltip" style="cursor: help; color: #696969; display: {{ $courseLesson->is_auto_published ? 'none' : '' }}"></i>
                                                                    </div>
                                                                @else
                                                                    <div style="display: flex; align-items: center; justify-content: space-between; width: 100%">
                                                                        <div>
                                                                            <input type="hidden" name="lesson_is_published[]" value="{{ $courseLesson->is_published }}">
                                                                            <input type="hidden" name="lesson_is_auto_published[]" value="{{ $courseLesson->is_auto_published }}">
                                                                            <input type="hidden" name="lesson_published_at[]" value="{{ $courseLesson->published_at }}">
                                                                            <div
                                                                                style="
                                                                                padding: 3px 7px;
                                                                                border-radius: 10px;
                                                                                font-weight: 600;
                                                                                color: green;
                                                                                font-size: 10px;
                                                                                text-transform: uppercase;"
                                                                            >
                                                                                <i class="far fa-check-circle"></i> Published {{ \Carbon\Carbon::parse($courseLesson->published_at)->format('M d Y, h:i:s a') }}
                                                                            </div>
                                                                        </div>
                                                                        <div style="background: white;
                                                                            display: flex;
                                                                            gap: 10px;
                                                                            font-weight: 500;
                                                                            padding: 5px 10px;
                                                                            border-radius: 10px;
                                                                            line-height: 14px;
                                                                            align-items:center"
                                                                        >
                                                                            <x-status status="{{ $courseLesson->status }}" id="{{ $courseLesson->id }}" table="{{ \Module\CourseManagement\Models\CourseLesson::getTableName() }}" />
                                                                            <span>Status (Published)</span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <input type="datetime-local" class="form-control lesson-published-at" name="lesson_published_at[]" value="{{ $courseLesson->published_at }}" style="display: {{ $courseLesson->is_published ? 'none' : '' }}">
                                                        </div>
                                                        <div style="display: flex; align-items: center; gap: 20px; width: 100%; margin-top: 20px">
                                                            <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                                                <label>
                                                                    <input name="lesson_is_free[]" class="lesson-no-free" value="0" type="hidden" {{ $courseLesson->is_free ? 'disabled' : '' }}>
                                                                    <input name="lesson_is_free[]" onclick="lessonIsFreeToggle(this)" value="1" type="checkbox" class="ace lesson-is-free" {{ $courseLesson->is_free ? 'checked' : '' }}>
                                                                    <span class="lbl"> Free</span>
                                                                </label>
                                                            </div>
                                                            <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                                                <label>
                                                                    <input name="lesson_is_quiz[]" class="lesson-no-quiz" value="0" type="hidden" {{ $courseLesson->is_quiz ? 'disabled' : '' }}>
                                                                    <input name="lesson_is_quiz[]" onclick="lessonIsQuizToggle(this)" value="1" type="checkbox" class="ace lesson-is-quiz" {{ $courseLesson->is_quiz ? 'checked' : '' }}>
                                                                    <span class="lbl"> Quiz</span>
                                                                </label>
                                                            </div>
                                                            <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                                                <label>
                                                                    <input name="lesson_is_assignment[]" value="0" class="lesson-no-assignment" type="hidden" {{ $courseLesson->is_assignment ? 'disabled' : '' }}>
                                                                    <input name="lesson_is_assignment[]" onclick="lessonIsAssignmentToggle(this)" value="1" type="checkbox" class="ace lesson-is-assignment" {{ $courseLesson->is_assignment ? 'checked' : '' }}>
                                                                    <span class="lbl"> Assignment</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="lesson-assignment-description" style="width: 100%; margin-top: 20px; display: {{ !$courseLesson->is_assignment ? 'none' : '' }}">
                                                            <textarea name="lesson_assignment_description[]" class="form-control tiny-editor" rows="10" style="width: 100%" placeholder="Assignment Description...">{{ $courseLesson->assignment_description }}</textarea>
                                                        </div>
                                                        <div style="width: 100%; margin-top: 20px;">
                                                            <textarea name="lesson_description[]" class="form-control tiny-editor" rows="10" style="width: 100%" placeholder="Lesson Description...">{!! $courseLesson->description !!}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    @if (old('course_lesson_course_topic_id'))
                                        @foreach (old('course_lesson_course_topic_id')?? [] as $key => $course_lesson_course_topic_id)
                                            <div class="lesson-panel panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key . '-' . $courseLesson->id }}" aria-expanded="true">
                                                            <i class="bigger-110 ace-icon fa fa-angle-down" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                            &nbsp;
                                                            <span class="accordion-title">{{ old('course_lesson_title')[$key] }}</span>
                                                        </a>
                                                    </h4>
                                                    <i onclick="removeLesson(this)" class="far fa-times-circle remove-lesson"></i>
                                                </div>
                                                <div class="panel-collapse collapse in" id="collapse{{ $key }}" aria-expanded="true">
                                                    <div class="panel-body">
                                                        <div class="lesson">
                                                            <input type="hidden" name="course_lesson_id[]" value="">
                                                            <div class="input-group" style="width: 100%">
                                                                <span class="input-group-addon" style="width: 135px; text-align: left">Course Topic <span style="color: red !important">*</span></span>
                                                                <select name="course_lesson_course_topic_id[]" class="form-control select2" data-placeholder="- Select Topic -" style="width: 100%" required>
                                                                    <option></option>
                                                                    @foreach ($courseTopics as $id => $title)
                                                                        <option value="{{ $id }}" {{ old('course_lesson_course_topic_id')[$key] == $id ? 'selected' : '' }}>{{ $title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="input-group" style="width: 100%">
                                                                <span class="input-group-addon" style="width: 135px; text-align: left">Lesson Title <span style="color: red !important">*</span></span>
                                                                <input type="text" class="form-control" onkeyup="setLessonTitle(this)" name="course_lesson_title[]" value="{{ old('course_lesson_title')[$key] }}" required autocomplete="off">
                                                            </div>
                                                            <div class="input-group" style="width: 100%; display: flex; align-items: center;">
                                                                <span class="input-group-addon" style="width: 165px; text-align: left; height: 35px; line-height: 20px">Duration <span style="color: red !important">*</span></span>
                                                                <input type="text" class="form-control duration" name="course_lesson_duration[]" value="{{ old('course_lesson_duration')[$key] }}" required autocomplete="off" placeholder="HH:MM:SS">
                                                                <i class="fas fa-info-circle" title="ex: HH:MM:SS ⇒ 00:10:11" data-toggle="tooltip" style="cursor: help; color: #696969; margin-left: 5px"></i>
                                                            </div>
                                                            @php
                                                                $isVideo = old('lesson_is_video')[$key];
                                                                $isVideo = $isVideo;

                                                                $isAttachment = old('lesson_is_attachment')[$key];
                                                                $courseAttachmentExist = $isAttachment;
                                                            @endphp
                                                            <div style="display: flex; align-items: center; gap: 50px; width: 100%">
                                                                <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px;">
                                                                    <div class="material-switch">
                                                                        <input type="hidden" class="lesson-no-video" name="lesson_is_video[]" value="0" {{ $isVideo ? 'disabled' : '' }} />
                                                                        <input type="checkbox" onclick="lessonIsVideoToggle(this)" class="lesson-is-video" name="lesson_is_video[]" id="lessonIsVideo{{ $key }}" value="1" {{ $isVideo ? 'checked' : '' }} />
                                                                        <label for="lessonIsVideo{{ $key }}" class="badge-primary"></label>
                                                                    </div>
                                                                    <label style="padding-top: 5px">Video</label>
                                                                </div>
                                                                <div style="display: flex !important; align-items: center !important; justify-content: space-between !important; width: calc(100% - 150px)">
                                                                    {{-- <input type="url" class="form-control lesson-video width-50" name="lesson_video[]" value="{{ old('lesson_video')[$key] }}" {{ !$isAttachment && $isVideo ? 'required' : '' }} style="display: {{ $isAttachment ? 'none' : '' }}" placeholder="Enter video link"> --}}
                                                                    <i class="fas fa-info-circle lesson-video-note" title="If you wanna add video instead of attachment please active video for enable this field." data-toggle="tooltip" style="cursor: help; color: #696969; display: {{ old('lesson_is_video')[$key] ? 'none' : '' }}"></i>
                                                                </div>
                                                            </div>
                                                            <div style="display: flex; align-items: center; gap: 50px; width: 100%">
                                                                <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px;">
                                                                    <div class="material-switch">
                                                                        <input type="hidden" class="lesson-no-attachment" name="lesson_is_attachment[]" value="0" {{ $isAttachment ? 'disabled' : '' }} />
                                                                        <input type="checkbox" onclick="lessonIsAttachmentToggle(this)" class="lesson-is-attachment" name="lesson_is_attachment[]" id="lessonIsAttachment{{ $key }}" value="1" {{ $isAttachment ? 'checked' : '' }} />
                                                                        <label for="lessonIsAttachment{{ $key }}" class="badge-primary"></label>
                                                                    </div>
                                                                    <label style="padding-top: 5px">Attachment</label>
                                                                </div>
                                                                <div style="display: flex !important; align-items: center !important; justify-content: space-between !important; width: calc(100% - 150px)">
                                                                    {{-- <input type="file" class="lesson-attachment pt-1" name="lesson_attachment[]" {{ !$isVideo && $courseAttachmentExist ? 'required' : '' }} style="display: {{ $isVideo ? 'none' : '' }}"> --}}
                                                                    <i class="fas fa-info-circle lesson-attachment-note" title="If you wanna add attachment instead of video please active attachment for enable this field." data-toggle="tooltip" style="cursor: help; color: #696969; display: {{ old('lesson_is_attachment')[$key] ? 'none' : '' }}"></i>
                                                                </div>
                                                            </div>
                                                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; width: 100%">
                                                                <div style="display: flex; align-items: center; justify-content: space-between; width: 100%">
                                                                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 200px;">
                                                                        <div class="material-switch">
                                                                            <input type="hidden" class="lesson-not-published" name="lesson_is_published[]" value="0" {{ old('lesson_is_published')[$key] ? 'disabled' : '' }} />
                                                                            <input type="checkbox" onclick="lessonIsPublishToggle(this)" class="lesson-is-published" name="lesson_is_published[]" id="lessonIsPublished{{ $key }}" value="1" {{ old('lesson_is_published')[$key] ? 'checked' : '' }} />
                                                                            <label for="lessonIsPublished{{ $key }}" class="badge-primary"></label>
                                                                        </div>
                                                                        <label style="padding-top: 5px">Publish</label>
                                                                    </div>
                                                                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 200px">
                                                                        <div class="material-switch">
                                                                            <input type="hidden" class="lesson-not-auto-published" name="lesson_is_auto_published[]" value="0" {{ old('lesson_is_auto_published')[$key] ? 'disabled' : '' }} />
                                                                            <input type="checkbox" onclick="lessonIsAutoPublishToggle(this)" class="lesson-is-auto-published" name="lesson_is_auto_published[]" id="lessonIsAutoPublished{{ $key }}" value="1" {{ old('lesson_is_auto_published')[$key] ? 'checked' : '' }} />
                                                                            <label for="lessonIsAutoPublished{{ $key }}" class="badge-primary"></label>
                                                                        </div>
                                                                        <label style="padding-top: 5px">Auto Publish</label>
                                                                        <i class="fas fa-info-circle lesson-auto-publish-note" title="If you wanna enable auto publish it will show published at field which is required. Note: it will be disable publish field also!" data-toggle="tooltip" style="cursor: help; color: #696969; display: {{ old('lesson_is_auto_published')[$key] ? 'none' : '' }}"></i>
                                                                    </div>
                                                                </div>
                                                                <input type="datetime-local" class="form-control lesson-published-at" name="lesson_published_at[]" value="{{ old('lesson_published_at')[$key] }}" style="display: {{ old('lesson_is_published')[$key] ? 'none' : '' }}">
                                                            </div>
                                                            <div style="display: flex; align-items: center; gap: 20px; width: 100%; margin-top: 20px">
                                                                <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                                                    <label>
                                                                        <input name="lesson_is_free[]" class="lesson-no-free" value="0" type="hidden" {{ old('lesson_is_free')[$key] ? 'disabled' : '' }}>
                                                                        <input name="lesson_is_free[]" onclick="lessonIsFreeToggle(this)" value="1" type="checkbox" class="ace lesson-is-free" {{ old('lesson_is_free')[$key] ? 'checked' : '' }}>
                                                                        <span class="lbl"> Free</span>
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                                                    <label>
                                                                        <input name="lesson_is_quiz[]" class="lesson-no-quiz" value="0" type="hidden" {{ old('lesson_is_quiz')[$key] ? 'disabled' : '' }}>
                                                                        <input name="lesson_is_quiz[]" onclick="lessonIsQuizToggle(this)" value="1" type="checkbox" class="ace lesson-is-quiz" {{ old('lesson_is_quiz')[$key] ? 'checked' : '' }}>
                                                                        <span class="lbl"> Quiz</span>
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                                                    <label>
                                                                        <input name="lesson_is_assignment[]" value="0" class="lesson-no-assignment" type="hidden" {{ old('lesson_is_assignment')[$key] ? 'disabled' : '' }}>
                                                                        <input name="lesson_is_assignment[]" onclick="lessonIsAssignmentToggle(this)" value="1" type="checkbox" class="ace lesson-is-assignment" {{ old('lesson_is_assignment')[$key] ? 'checked' : '' }}>
                                                                        <span class="lbl"> Assignment</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="lesson-assignment-description" style="width: 100%; margin-top: 20px; display: {{ !old('lesson_is_assignment')[$key] ? 'none' : '' }}">
                                                                <textarea name="lesson_assignment_description[]" class="form-control tiny-editor" rows="10" style="width: 100%" placeholder="Assignment Description...">{{ old('lesson_assignment_description')[$key] }}</textarea>
                                                            </div>
                                                            <div style="width: 100%; margin-top: 20px;">
                                                                <textarea name="lesson_description[]" class="form-control tiny-editor" rows="10" style="width: 100%" placeholder="Lesson Description...">{!! old('lesson_description')[$key] !!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if (count($courseLessons) == 0)
                                        <div class="lesson-panel panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true">
                                                        <i class="bigger-110 ace-icon fa fa-angle-down" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                        &nbsp;
                                                        <span class="accordion-title">Title goes here!</span>
                                                    </a>
                                                </h4>
                                                <i onclick="removeLesson(this)" class="far fa-times-circle remove-lesson"></i>
                                            </div>
                                            <div class="panel-collapse collapse in" id="collapseOne" aria-expanded="true">
                                                <div class="panel-body">
                                                    <div class="lesson">
                                                        <input type="hidden" name="course_lesson_id[]" value="">
                                                        <div class="input-group" style="width: 100%">
                                                            <span class="input-group-addon" style="width: 135px; text-align: left">Course Topic <span style="color: red !important">*</span></span>
                                                            <select name="course_lesson_course_topic_id[]" class="form-control select2" data-placeholder="- Select Topic -" style="width: 100%" required>
                                                                <option></option>
                                                                @foreach ($courseTopics as $id => $title)
                                                                    <option value="{{ $id }}">{{ $title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="input-group" style="width: 100%">
                                                            <span class="input-group-addon" style="width: 135px; text-align: left">Lesson Title <span style="color: red !important">*</span></span>
                                                            <input type="text" class="form-control" onkeyup="setLessonTitle(this)" name="course_lesson_title[]" required autocomplete="off">
                                                        </div>
                                                        <div class="input-group" style="width: 100%; display: flex; align-items: center;">
                                                            <span class="input-group-addon" style="width: 165px; text-align: left; height: 35px; line-height: 20px">Duration <span style="color: red !important">*</span></span>
                                                            <input type="text" class="form-control duration" name="course_lesson_duration[]" required autocomplete="off" placeholder="HH:MM:SS">
                                                            <i class="fas fa-info-circle" title="ex: HH:MM:SS ⇒ 00:10:11" data-toggle="tooltip" style="cursor: help; color: #696969; margin-left: 5px"></i>
                                                        </div>
                                                        <div style="display: flex; align-items: center; gap: 50px; width: 100%">
                                                            <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px;">
                                                                <div class="material-switch">
                                                                    <input type="hidden" class="lesson-no-video" name="lesson_is_video[]" value="0" disabled />
                                                                    <input type="checkbox" onclick="lessonIsVideoToggle(this)" class="lesson-is-video" name="lesson_is_video[]" id="lessonIsVideo" value="1" checked />
                                                                    <label for="lessonIsVideo" class="badge-primary"></label>
                                                                </div>
                                                                <label style="padding-top: 5px">Video</label>
                                                            </div>
                                                            <div style="display: flex; align-items: center; gap: 10px">
                                                                {{-- <input type="url" class="form-control lesson-video width-50" name="lesson_video[]" placeholder="Enter video link" required> --}}
                                                                <i class="fas fa-info-circle lesson-video-note" title="If you wanna add video instead of attachment please active video for enable this field." data-toggle="tooltip" style="cursor: help; color: #696969; display: none"></i>
                                                            </div>
                                                        </div>
                                                        <div style="display: flex; align-items: center; gap: 50px; width: 100%">
                                                            <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px;">
                                                                <div class="material-switch">
                                                                    <input type="hidden" class="lesson-no-attachment" name="lesson_is_attachment[]" value="0" />
                                                                    <input type="checkbox" onclick="lessonIsAttachmentToggle(this)" class="lesson-is-attachment" name="lesson_is_attachment[]" id="lessonIsAttachment" value="1" />
                                                                    <label for="lessonIsAttachment" class="badge-primary"></label>
                                                                </div>
                                                                <label style="padding-top: 5px">Attachment</label>
                                                            </div>
                                                            <div style="display: flex; align-items: center; gap: 10px">
                                                                {{-- <input type="file" class="lesson-attachment pt-1" name="lesson_attachment[]" style="display: none"> --}}
                                                                <i class="fas fa-info-circle lesson-attachment-note" title="If you wanna add attachment instead of video please active attachment for enable this field." data-toggle="tooltip" style="cursor: help; color: #696969"></i>
                                                            </div>
                                                        </div>
                                                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; width: 100%">
                                                            <div style="display: flex; align-items: center; justify-content: space-between">
                                                                <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 200px;">
                                                                    <div class="material-switch">
                                                                        <input type="hidden" class="lesson-not-published" name="lesson_is_published[]" value="0" disabled />
                                                                        <input type="checkbox" onclick="lessonIsPublishToggle(this)" class="lesson-is-published" name="lesson_is_published[]" id="lessonIsPublished" value="1" checked />
                                                                        <label for="lessonIsPublished" class="badge-primary"></label>
                                                                    </div>
                                                                    <label style="padding-top: 5px">Publish</label>
                                                                </div>
                                                                <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 200px">
                                                                    <div class="material-switch">
                                                                        <input type="hidden" class="lesson-not-auto-published" name="lesson_is_auto_published[]" value="0" />
                                                                        <input type="checkbox" onclick="lessonIsAutoPublishToggle(this)" class="lesson-is-auto-published" name="lesson_is_auto_published[]" id="lessonIsAutoPublished" value="1" />
                                                                        <label for="lessonIsAutoPublished" class="badge-primary"></label>
                                                                    </div>
                                                                    <label style="padding-top: 5px">Auto Publish</label>
                                                                    <i class="fas fa-info-circle lesson-auto-publish-note" title="If you wanna enable auto publish it will show published at field which is required. Note: it will be disable publish field also!" data-toggle="tooltip" style="cursor: help; color: #696969"></i>
                                                                </div>
                                                            </div>
                                                            <input type="datetime-local" class="form-control lesson-published-at" name="lesson_published_at[]" style="display: none">
                                                        </div>
                                                        <div style="display: flex; align-items: center; gap: 20px; width: 100%; margin-top: 20px">
                                                            <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                                                <label>
                                                                    <input name="lesson_is_free[]" class="lesson-no-free" value="0" type="hidden">
                                                                    <input name="lesson_is_free[]" onclick="lessonIsFreeToggle(this)" value="1" type="checkbox" class="ace lesson-is-free">
                                                                    <span class="lbl"> Free</span>
                                                                </label>
                                                            </div>
                                                            <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                                                <label>
                                                                    <input name="lesson_is_quiz[]" class="lesson-no-quiz" value="0" type="hidden">
                                                                    <input name="lesson_is_quiz[]" onclick="lessonIsQuizToggle(this)" value="1" type="checkbox" class="ace lesson-is-quiz">
                                                                    <span class="lbl"> Quiz</span>
                                                                </label>
                                                            </div>
                                                            <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                                                <label>
                                                                    <input name="lesson_is_assignment[]" value="0" class="lesson-no-assignment" type="hidden">
                                                                    <input name="lesson_is_assignment[]" onclick="lessonIsAssignmentToggle(this)" value="1" type="checkbox" class="ace lesson-is-assignment">
                                                                    <span class="lbl"> Assignment</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="lesson-assignment-description" style="width: 100%; margin-top: 20px; display: none">
                                                            <textarea name="lesson_assignment_description[]" class="form-control tiny-editor" rows="10" style="width: 100%" placeholder="Assignment Description..."></textarea>
                                                        </div>
                                                        <div style="width: 100%; margin-top: 20px;">
                                                            <textarea name="lesson_description[]" class="form-control tiny-editor" rows="10" style="width: 100%" placeholder="Lesson Description..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div style="display: flex; align-items: center; justify-content: space-between">
                                    <button type="button" class="add-more" onclick="addLesson()">
                                        <i class="far fa-plus-circle"></i> ADD LESSON
                                    </button>

                                    @include('partials._paginate', ['data' => $courseLessons])
                                </div>
                            </div>
                        </div>
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
                </form>
            </div>
        </div>
    </div>
@endsection




@section('script')
    @include('course/_inc/script')
@endsection
