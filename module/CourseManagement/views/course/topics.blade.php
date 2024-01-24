@extends('layouts.master')

@section('title', 'Course Topics')


@section('style')
    @include('course/_inc/style')
@endsection


@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-clipboard-list"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.courses.index') }}">Course</a></li>
            <li class=""><a href="javascript:void(0)">Topics</a></li>
        </ul>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            @include('partials._alert_message')

            <div id="fuelux-wizard-container">
                @include('course/_inc/wizard-heading')
                <hr />



                <form action="{{ route('cm.courses.topics-update-or-create', $course_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="step-pane active" data-step="7">
                        <div class="row">
                            <div class="col-sm-12 col-md-8 col-md-offset-2">
                                <div id="topics">
                                    @foreach ($courseTopics as $key => $courseTopic)
                                        <div class="topic">
                                            <input type="hidden" name="topic_id[]" value="{{ $courseTopic->id }}">
                                            <div class="input-group" style="width: 100%">
                                                <span class="input-group-addon" style="width: 125px; text-align: left">Topic Title <span style="color: red !important">*</span></span>
                                                <input type="text" class="form-control" name="topic_title[]" value="{{ $courseTopic->title }}" required>
                                            </div>
                                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; width: 100%">
                                                <div style="display: flex; align-items: center; width: 100%">
                                                    @if (!$courseTopic->is_published)
                                                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px">
                                                            <div class="material-switch">
                                                                <input type="hidden" class="topic-not-published" name="topic_is_published[]" value="0" {{ $courseTopic->is_published == 1 ? 'disabled' : '' }} />
                                                                <input type="checkbox" onclick="topicIsPublishToggle(this)" class="topic-is-published" name="topic_is_published[]" id="topicIsPublished{{ $key . '-' . $courseTopic }}" value="1" {{ $courseTopic->is_published == 1 ? 'checked' : '' }} />
                                                                <label for="topicIsPublished{{ $key . '-' . $courseTopic }}" class="badge-primary"></label>
                                                            </div>
                                                            <label style="padding-top: 5px">Publish</label>
                                                        </div>
                                                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px">
                                                            <div class="material-switch">
                                                                <input type="hidden" class="topic-not-auto-published" name="topic_is_auto_published[]" value="0" {{ $courseTopic->is_auto_published == 1 ? 'disabled' : '' }} />
                                                                <input type="checkbox" onclick="topicIsAutoPublishToggle(this)" class="topic-is-auto-published" name="topic_is_auto_published[]" id="topicIsAutoPublished{{ $key . '-' . $courseTopic }}" value="1" {{ $courseTopic->is_auto_published == 1 ? 'checked' : '' }} />
                                                                <label for="topicIsAutoPublished{{ $key . '-' . $courseTopic }}" class="badge-primary"></label>
                                                            </div>
                                                            <label style="padding-top: 5px">Auto Publish</label>
                                                        </div>
                                                    @else
                                                        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%">
                                                            <div>
                                                                <input type="hidden" name="topic_is_published[]" value="{{ $courseTopic->is_published }}">
                                                                <input type="hidden" name="topic_is_auto_published[]" value="{{ $courseTopic->is_auto_published }}">
                                                                <input type="hidden" name="topic_published_at[]" value="{{ $courseTopic->published_at }}">
                                                                <div
                                                                    style="
                                                                    padding: 3px 7px;
                                                                    border-radius: 10px;
                                                                    font-weight: 600;
                                                                    color: green;
                                                                    font-size: 10px;
                                                                    text-transform: uppercase;"
                                                                >
                                                                    <i class="far fa-check-circle"></i> Published {{ \Carbon\Carbon::parse($courseTopic->published_at)->format('M d Y, h:i:s a') }}
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
                                                                <x-status status="{{ $courseTopic->status }}" id="{{ $courseTopic->id }}" table="{{ \Module\CourseManagement\Models\CourseTopic::getTableName() }}" />
                                                                <span>Status (Publish)</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if (!$courseTopic->is_published)
                                                    <div class="input-group topic-publish-at-input-group" style="width: 100%; display: {{ $courseTopic->is_auto_published == 0 ? 'none' : '' }}">
                                                        <span class="input-group-addon" style="width: 125px; text-align: left;">Publish At <span style="color: red !important">*</span></span>
                                                        <input type="datetime-local" class="form-control topic-published-at" name="topic_published_at[]" value="{{ $courseTopic->published_at }}" {{ \Carbon\Carbon::now() > $courseTopic->published_at ? 'readonly' : '' }}>
                                                    </div>
                                                @endif
                                            </div>
                                            <i onclick="delete_item(`{{ route('cm.delete-topic', $courseTopic->id) }}`)" class="far fa-trash remove-icon"></i>
                                        </div>
                                    @endforeach

                                    @if (old('topic_title'))
                                        @foreach (old('topic_title') as $key => $topic_title)
                                            <div class="topic">
                                                <input type="hidden" name="topic_id[]" value="">
                                                <div class="input-group" style="width: 100%">
                                                    <span class="input-group-addon" style="width: 125px; text-align: left">Topic Title <span style="color: red !important">*</span></span>
                                                    <input type="text" class="form-control" name="topic_title[]" value="{{ $topic_title }}" required>
                                                </div>
                                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; width: 100%">
                                                    <div style="display: flex; align-items: center; justify-content: space-between">
                                                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px">
                                                            <div class="material-switch">
                                                                <input type="hidden" class="topic-not-published" name="topic_is_published[]" value="0" {{ old('topic_is_published')[$key] == 1 ? 'disabled' : '' }} />
                                                                <input type="checkbox" onclick="topicIsPublishToggle(this)" class="topic-is-published" name="topic_is_published[]" id="topicIsPublished{{ $key }}" value="1" {{ old('topic_is_published')[$key] == 1 ? 'checked' : '' }} />
                                                                <label for="topicIsPublished{{ $key }}" class="badge-primary"></label>
                                                            </div>
                                                            <label style="padding-top: 5px">Publish</label>
                                                        </div>
                                                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px">
                                                            <div class="material-switch">
                                                                <input type="hidden" class="topic-not-auto-published" name="topic_is_auto_published[]" value="0" {{ old('topic_is_auto_published')[$key] == 1 ? 'disabled' : '' }} />
                                                                <input type="checkbox" onclick="topicIsAutoPublishToggle(this)" class="topic-is-auto-published" name="topic_is_auto_published[]" id="topicIsAutoPublished{{ $key }}" value="1" {{ old('topic_is_auto_published')[$key] == 1 ? 'checked' : '' }} />
                                                                <label for="topicIsAutoPublished{{ $key }}" class="badge-primary"></label>
                                                            </div>
                                                            <label style="padding-top: 5px">Auto Publish</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group topic-publish-at-input-group" style="width: 100%; display: {{ old('topic_is_auto_published')[$key] == 0 ? 'none' : '' }}">
                                                        <span class="input-group-addon" style="width: 125px; text-align: left;">Publish At <span style="color: red !important">*</span></span>
                                                        <input type="datetime-local" class="form-control topic-published-at" name="topic_published_at[]" value="{{ old('topic_published_at')[$key] }}">
                                                    </div>
                                                </div>
                                                <i onclick="removeTopic(this)" class="far fa-times-circle remove-icon"></i>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if (count($courseTopics) == 0)
                                        <div class="topic">
                                            <input type="hidden" name="topic_id[]" value="">
                                            <div class="input-group" style="width: 100%">
                                                <span class="input-group-addon" style="width: 125px; text-align: left">Topic Title <span style="color: red !important">*</span></span>
                                                <input type="text" class="form-control" name="topic_title[]" required>
                                            </div>
                                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; width: 100%">
                                                <div style="display: flex; align-items: center; justify-content: space-between">
                                                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px">
                                                        <div class="material-switch">
                                                            <input type="hidden" class="topic-not-published" name="topic_is_published[]" value="0" disabled />
                                                            <input type="checkbox" onclick="topicIsPublishToggle(this)" class="topic-is-published" name="topic_is_published[]" id="topicIsPublished" value="1" checked />
                                                            <label for="topicIsPublished" class="badge-primary"></label>
                                                        </div>
                                                        <label style="padding-top: 5px">Publish</label>
                                                    </div>
                                                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px">
                                                        <div class="material-switch">
                                                            <input type="hidden" class="topic-not-auto-published" name="topic_is_auto_published[]" value="0" />
                                                            <input type="checkbox" onclick="topicIsAutoPublishToggle(this)" class="topic-is-auto-published" name="topic_is_auto_published[]" id="topicIsAutoPublished" value="1" />
                                                            <label for="topicIsAutoPublished" class="badge-primary"></label>
                                                        </div>
                                                        <label style="padding-top: 5px">Auto Publish</label>
                                                    </div>
                                                </div>
                                                <div class="input-group topic-publish-at-input-group" style="width: 100%; display: none">
                                                    <span class="input-group-addon" style="width: 125px; text-align: left">Publish At <span style="color: red !important">*</span></span>
                                                    <input type="datetime-local" class="form-control topic-published-at" name="topic_published_at[]">
                                                </div>
                                            </div>
                                            <i onclick="removeTopic(this)" class="far fa-times-circle remove-icon"></i>
                                        </div>
                                    @endif
                                </div>

                                <button type="button" class="add-more" onclick="addTopic()">
                                    <i class="far fa-plus-circle"></i> ADD TOPIC
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="wizard-actions" style="display: flex; align-items: center; justify-content: space-between">
                        <a href="{{ route('cm.courses.faqs-update-or-create', $course_id) }}" class="btn btn-sm btn-prev">
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
