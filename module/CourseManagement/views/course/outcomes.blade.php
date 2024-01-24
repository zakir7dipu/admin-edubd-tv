@extends('layouts.master')

@section('title', 'Course Outcomes')


@section('style')
    @include('course/_inc/style')
@endsection


@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-bullseye-arrow"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.courses.index') }}">Courses</a></li>
            <li class=""><a href="javascript:void(0)">Outcomes</a></li>
        </ul>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            @include('partials._alert_message')

            <div id="fuelux-wizard-container">
                @include('course/_inc/wizard-heading')
                <hr />
                
                <form action="{{ route('cm.courses.outcomes-update-or-create', $course_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="step-pane active" data-step="5">
                        <div class="row">
                            <div class="col-sm-12 col-md-8 col-md-offset-2">
                                <div id="outcomes">
                                    @foreach ($courseOutcomes as $courseOutcome)
                                        <div class="outcome">
                                            <span class="outcome-label">Outcome</span>
                                            <textarea class="form-control" name="outcome_text[]" class="form-control">{{ $courseOutcome->text }}</textarea>
                                            <i onclick="removeOutcome(this)" class="far fa-times-circle remove-icon"></i>
                                        </div>
                                    @endforeach

                                    @if (old('outcome_text'))
                                        @foreach (old('outcome_text') as $outcomeText)
                                            <div class="outcome">
                                                <span class="outcome-label">Outcome</span>
                                                <textarea class="form-control" name="outcome_text[]" class="form-control">{{ $outcomeText }}</textarea>
                                                <i onclick="removeOutcome(this)" class="far fa-times-circle remove-icon"></i>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if (count($courseOutcomes) == 0)
                                        <div class="outcome">
                                            <span class="outcome-label">Outcome</span>
                                            <textarea class="form-control" name="outcome_text[]" class="form-control"></textarea>
                                            <i onclick="removeOutcome(this)" class="far fa-times-circle remove-icon"></i>
                                        </div>
                                    @endif
                                </div>
                    
                                <button type="button" class="add-more" onclick="addOutcome()">
                                    <i class="far fa-plus-circle"></i> ADD OUTCOME
                                </button>
                            </div>
                        </div>
                    </div>
                
                    <hr />
                
                    <div class="wizard-actions" style="display: flex; align-items: center; justify-content: space-between">
                        <a href="{{ route('cm.courses.instructors-update-or-create', $course_id) }}" class="btn btn-sm btn-prev">
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