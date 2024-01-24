@extends('layouts.master')

@section('title', 'Create Lesson Quiz')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>
        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.lesson-quiz.index') }}">Course Lesson Quiz</a></li>
            <li class=""><a href="javascript:void(0)">Create</a></li>
        </ul>
    </div>


    <div class="mt-2">
        @include('partials._alert_message')
    </div>


    <form action="{{ route('cm.lesson-quiz.store') }}" method="POST">
        @csrf
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row mb-1">
                        <label class="col-sm-12 col-md-2 col-form-label">Question <span style="color: red !important"></span></label>
                        <div class="col-sm-12 col-md-10">
                            <input type="text" class="form-control" name="quiz_name" value="{{ old('quiz_name') }}">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-sm-12 col-md-2 col-form-label">Lesson Name <span style="color: red !important"></span></label>
                        <div class="col-sm-12 col-md-10">
                                <select name="lesson_id" id="courseLesson" class="form-control select2">
                                    <option value="">- Select Lesson -</option>
                                    @foreach($course_lessons as $lesson_id => $lesson_title)
                                        <option value="{{ $lesson_id }}">{{ $lesson_title }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Status (Published) <sup style="color: red"></sup></label>
                        <div class="col-sm-12 col-md-10">
                            <div class="material-switch pt-1">
                                <input type="checkbox" name="status" id="status" value="1" checked />
                                <label for="status" class="badge-primary"></label>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Quiz Marks <sup style="color: red">*</sup></label>
                        <div class="col-sm-12 col-md-10">
                            <div class=" pt-1">
                                <input type="number" name="marks" id="marks"/>
                                <label for="marks" class="badge-primary"></label>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

            <hr>

            <h4 class="mb-2" style="color: black"><i class="far fa-check-circle"></i> Answer Options</h4>
            <div id="quizOption">
                @if (old('option_name'))
                    @foreach (old('option_name') ?? [] as $key => $option_name)
                        <div class="row option">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <label
                                        class="input-group-addon"
                                        style="background: #dfdfdf; color: #000000"
                                    >
                                        Option {{ $loop->iteration }} <span style="color: red">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="option_name[]"
                                        value="{{ $option_name }}"
                                        autocomplete="off"
                                        required
                                    >
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="display: flex; justify-content: space-between;">
                                    <label class="col-form-label">Correct</label>
                                    <div class="material-switch pt-1">
                                        <input
                                            type="hidden"
                                            class="is-currect-option-default-value"
                                            name="option_is_true[]"
                                            value="0"
                                            {{ old('option_is_true')[$key] == 0 ? 'disabled' : '' }}
                                        />
                                        <input
                                            type="checkbox"
                                            class="is-correct-option-checked-value"
                                            onchange="currectOptionToggle(this)"
                                            name="option_is_true[]"
                                            id="isCurrectOption{{ $key + 1 }}"
                                            value="1"
                                            {{ old('option_is_true')[$key] == 1 ? 'checked' : '' }}
                                        />
                                        <label for="isCurrectOption{{ $key + 1 }}" class="badge-primary"></label>
                                    </div>
                                </div>
                            </div>
                            @if ($key > 1)
                                <div class="col-md-2">
                                    <i class="far fa-times-circle" onclick="removeOption(this)" style="font-size: 20px; color: red; padding-top: 7px; cursor: pointer"></i>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="row option">
                        <div class="col-md-8">
                            <div class="input-group">
                                <label
                                    class="input-group-addon"
                                    style="background: #dfdfdf; color: #000000"
                                >
                                    Option 1 <span style="color: red">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="option_name[]"
                                    autocomplete="off"
                                    required
                                >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" style="display: flex; justify-content: space-between;">
                                <label class="col-form-label">Correct</label>
                                <div class="material-switch pt-1">
                                    <input
                                        type="hidden"
                                        class="is-currect-option-default-value"
                                        name="option_is_true[]"
                                        value="0"
                                    />
                                    <input
                                        type="checkbox"
                                        class="is-correct-option-checked-value"
                                        onchange="currectOptionToggle(this)"
                                        name="option_is_true[]"
                                        id="isCurrectOption1"
                                        value="1"
                                    />
                                    <label for="isCurrectOption1" class="badge-primary"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row option">
                        <div class="col-md-8">
                            <div class="input-group">
                                <label
                                    class="input-group-addon"
                                    style="background: #dfdfdf; color: #000000"
                                >
                                    Option 2 <span style="color: red">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="option_name[]"
                                    autocomplete="off"
                                    required
                                >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" style="display: flex; justify-content: space-between;">
                                <label class="col-form-label">Correct</label>
                                <div class="material-switch pt-1">
                                    <input
                                        type="hidden"
                                        class="is-currect-option-default-value"
                                        name="option_is_true[]"
                                        value="0"
                                    />
                                    <input
                                        type="checkbox"
                                        class="is-correct-option-checked-value"
                                        onchange="currectOptionToggle(this)"
                                        name="option_is_true[]"
                                        id="isCurrectOption2"
                                        value="1"
                                    />
                                    <label for="isCurrectOption2" class="badge-primary"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <button
                type="button"
                onclick="addOption()"
                class="add-option"
                style="padding: 4px 8px;
                    border-radius: 5px;
                    background: #bfffd4 !important;
                    border: 2px solid #bfffd4;
                    color: black;
                    font-weight: 500"
            >
                <i class="far fa-plus-circle"></i> ADD OPTION
            </button>
        </div>
        <hr />
        <div class="form-group row">
            <label class="col-sm-12 col-md-3 col-form-label"></label>
            <div class="col-sm-12 col-md-9">
                <div class="btn-group" style='float:right'>
                    <button class="btn btn-sm btn-theme">
                        <i class="far fa-check-circle"></i>
                        SUBMIT
                    </button>
                    <a class="btn btn-sm btn-yellow ml-1" href="{{ route('em.exam-quizzes.index') }}">
                        <i class="far fa-long-arrow-left"></i>
                        BACK TO LIST
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection





@section('script')
    @include('lesson-quiz/_inc/script')
@endsection
