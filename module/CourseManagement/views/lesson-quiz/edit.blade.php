@extends('layouts.master')

@section('title', 'Edit Lesson Quiz')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>
        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.lesson-quiz.index') }}">Course Lesson Quiz</a></li>
            <li class=""><a href="javascript:void(0)">edit</a></li>
        </ul>
    </div>


    <div class="mt-2">
        @include('partials._alert_message')
    </div>


    <form action="{{ route('cm.lesson-quiz.update', $lesson_quiz->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row mb-1">
                        <label class="col-sm-12 col-md-2 col-form-label">Quiz Title <span style="color: red !important"></span></label>
                        <div class="col-sm-12 col-md-10">
                            <input type="text" class="form-control" name="quiz_name" value="{{ old('quiz_name', $lesson_quiz->name) }}" >
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-sm-12 col-md-2 col-form-label">Lesson Name <span style="color: red !important"></span></label>
                        <div class="col-sm-12 col-md-10">
                            <select name="lesson_id" id="courseLesson" class="form-control select2">
                                <option value="">- Select Lesson -</option>
                                @foreach($course_lessons as $lesson_id => $lesson_title)
                                    <option value="{{ $lesson_id }}" {{ $lesson_quiz->lesson_id == $lesson_id ? 'selected' : '' }}>
                                        {{ $lesson_title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Status (Published)<sup style="color: red">*</sup></label>
                        <div class="col-sm-12 col-md-10">
                            <div class="material-switch pt-1">
                                <input type="checkbox" name="status" id="status" value="1" {{ $lesson_quiz->status ? 'checked' : '' }} />
                                <label for="status" class="badge-primary"></label>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <hr>

            <h4 class="mb-2" style="color: black"><i class="far fa-check-circle"></i> Answer Options</h4>
            <div id="quizOption">
                @if (old('option_name'))
                    @foreach (old('option_name') ?? [] as $key => $option_name)
                        <input type="hidden" name="option_id[]" value="{{ old('option_id')[$key] }}">
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
                                            id="isCurrectOption{{ $loop->iteration }}"
                                            value="1"
                                            {{ old('option_is_true')[$key] == 1 ? 'checked' : '' }}
                                        />
                                        <label for="isCurrectOption{{ $loop->iteration }}" class="badge-primary"></label>
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
                    @foreach ($lesson_quiz->lessonQuizOption as $key => $option)
                        <input type="hidden" name="option_id[]" value="{{ $option->id }}">
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
                                        autocomplete="off"
                                        value="{{ $option->name }}"
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
                                            {{ $option->answer ? 'disabled' : '' }}
                                        />
                                        <input
                                            type="checkbox"
                                            class="is-correct-option-checked-value"
                                            onchange="currectOptionToggle(this)"
                                            name="option_is_true[]"
                                            id="isCurrectOption{{ $loop->iteration }}"
                                            value="1"
                                            {{ $option->answer ? 'checked' : '' }}
                                        />
                                        <label for="isCurrectOption{{ $loop->iteration }}" class="badge-primary"></label>
                                    </div>
                                </div>
                            </div>
                            @if ($key > 1)
                                <div class="col-md-2">
                                    <i class="far fa-trash" onclick="delete_item('{{ route('cm.delete-quiz-option', $option->id) }}')" style="font-size: 20px; color: red; padding-top: 7px; cursor: pointer"></i>
                                </div>
                            @endif
                        </div>
                    @endforeach
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
                    font-weight: 500;
                    display: {{ count($lesson_quiz->lessonQuizOption) == 4 ? 'none' : '' }}"
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
                        UPDATE
                    </button>
                    <a class="btn btn-sm btn-yellow ml-1" href="{{ route('cm.lesson-quiz.index') }}">
                        <i class="far fa-long-arrow-left"></i>
                        BACK TO LIST
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection





@section('script')
    @include('exam-quiz/_inc/script')
@endsection
