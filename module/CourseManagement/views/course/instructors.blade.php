@extends('layouts.master')

@section('title', 'Course Instructors')


@section('style')
    @include('course/_inc/style')
@endsection


@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-user-tie"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.courses.index') }}">Course</a></li>
            <li class=""><a href="javascript:void(0)">Instructors</a></li>
        </ul>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            @include('partials._alert_message')

            <div id="fuelux-wizard-container">
                @include('course/_inc/wizard-heading')
                <hr />
                
                <form action="{{ route('cm.courses.instructors-update-or-create', $course_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="step-pane active" data-step="4">
                        <div class="row">
                            <div class="col-sm-12 col-md-8 col-md-offset-2">
                                <div id="instructors">
                                    @foreach ($courseInstructors as $key => $courseInstructor)
                                        <div class="instructor">
                                            <img src="{{ asset('assets/img/default.png') }}" class="instructor-image img-thumbnail img-circle" width="80px" height="80px" alt="">
                                            <select name="course_instructor_id[]" data-current-id="{{ $courseInstructor->instructor_id }}" class="form-control select2 course-instructor-id" onchange="setInstructorInfos(this)" data-placeholder="- Select -" style="width: 100%" required>
                                                <option></option>
                                                @isset($instructors)
                                                    @foreach ($instructors as $instructor)
                                                        <option 
                                                            value="{{ $instructor->id }}" 
                                                            data-first-name="{{ $instructor->first_name }}"
                                                            data-last-name="{{ $instructor->last_name }}"
                                                            data-username="{{ $instructor->username }}"
                                                            data-email="{{ $instructor->email }}"
                                                            data-phone="{{ $instructor->phone }}"
                                                            data-image="{{ $instructor->image != '' && file_exists($instructor->image) ? asset($instructor->image) : '' }}"
                                                            {{ $courseInstructor->instructor_id == $instructor->id ? 'selected' : '' }}
                                                        >
                                                            {{ $instructor->first_name }} {{ $instructor->last_name }}
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            @if ($key != 0)
                                                <button 
                                                    onclick="removeInstructor(this)"
                                                    class="remove-btn"
                                                >
                                                    <i class="far fa-times-circle"></i>
                                                </button>
                                            @endif
                                            <span class="popover-success instructor-infos"
                                                data-rel="popover"
                                                data-placement="bottom"
                                                data-trigger="hover"
                                                data-original-title="<div style='color: blue; font-weight: 600'>{{ $key == 0 ? 'Primary Instructor Information' : 'Instructor Information' }}</div>"
                                                data-content=""
                                                style="margin-top: 5px"
                                            >
                                                <i class="far fa-info-circle ml-2" style="cursor: help; font-size: 20px; color: black"></i>
                                            </span>
                                        </div>
                                    @endforeach

                                    @if (old('course_instructor_id'))
                                        @foreach (old('course_instructor_id') as $courseInstructorId)
                                            <div class="instructor">
                                                <img src="{{ asset('assets/img/default.png') }}" class="instructor-image img-thumbnail img-circle" width="80px" height="80px" alt="">
                                                <select name="course_instructor_id[]" data-current-id="{{ $courseInstructorId }}" class="form-control select2 course-instructor-id" onchange="setInstructorInfos(this)" data-placeholder="- Select -" style="width: 100%" required>
                                                    <option></option>
                                                    @isset($instructors)
                                                        @foreach ($instructors as $instructor)
                                                            <option 
                                                                value="{{ $instructor->id }}" 
                                                                data-first-name="{{ $instructor->first_name }}"
                                                                data-last-name="{{ $instructor->last_name }}"
                                                                data-username="{{ $instructor->username }}"
                                                                data-email="{{ $instructor->email }}"
                                                                data-phone="{{ $instructor->phone }}"
                                                                data-image="{{ $instructor->image != '' && file_exists($instructor->image) ? asset($instructor->image) : '' }}"
                                                                {{ $courseInstructorId == $instructor->id ? 'selected' : '' }}
                                                            >
                                                                {{ $instructor->first_name }} {{ $instructor->last_name }}
                                                            </option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                @if ($key != 0)
                                                    <button 
                                                        onclick="removeInstructor(this)"
                                                        class="remove-btn"
                                                    >
                                                        <i class="far fa-times-circle"></i>
                                                    </button>
                                                @endif
                                                <span class="popover-success instructor-infos"
                                                    data-rel="popover"
                                                    data-placement="bottom"
                                                    data-trigger="hover"
                                                    data-original-title="<div style='color: blue; font-weight: 600'>{{ $key == 0 ? 'Primary Instructor Information' : 'Instructor Information' }}</div>"
                                                    data-content=""
                                                    style="margin-top: 5px"
                                                >
                                                    <i class="far fa-info-circle ml-2" style="cursor: help; font-size: 20px; color: black"></i>
                                                </span>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if (count($courseInstructors) == 0)
                                        <div class="instructor">
                                            <img src="{{ asset('assets/img/default.png') }}" class="instructor-image img-thumbnail img-circle" width="80px" height="80px" alt="">
                                            <select name="course_instructor_id[]" data-current-id="" class="form-control select2 course-instructor-id" onchange="setInstructorInfos(this)" data-placeholder="- Select -" style="width: 100%" required>
                                                <option></option>
                                                @foreach ($instructors as $instructor)
                                                    <option 
                                                        value="{{ $instructor->id }}" 
                                                        data-first-name="{{ $instructor->first_name }}"
                                                        data-last-name="{{ $instructor->last_name }}"
                                                        data-username="{{ $instructor->username }}"
                                                        data-email="{{ $instructor->email }}"
                                                        data-phone="{{ $instructor->phone }}"
                                                        data-image="{{ $instructor->image != '' && file_exists($instructor->image) ? asset($instructor->image) : '' }}"
                                                    >
                                                        {{ $instructor->first_name }} {{ $instructor->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="popover-success instructor-infos"
                                                data-rel="popover"
                                                data-placement="bottom"
                                                data-trigger="hover"
                                                data-original-title="<div style='color: blue; font-weight: 600'>Primary Instructor Information</div>"
                                                data-content=""
                                                style="display: none; margin-top: 5px"
                                            >
                                                <i class="far fa-info-circle ml-2" style="cursor: help; font-size: 20px; color: black"></i>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                    
                                <button type="button" class="add-more mt-1" onclick="addInstructor()">
                                    <i class="far fa-plus-circle"></i> ADD INSTRUCTOR
                                </button>
                            </div>
                        </div>
                    </div>
                
                    <hr />
                
                    <div class="wizard-actions" style="display: flex; align-items: center; justify-content: space-between">
                        <a href="{{ route('cm.courses.introductions-update-or-create', $course_id) }}" class="btn btn-sm btn-prev">
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