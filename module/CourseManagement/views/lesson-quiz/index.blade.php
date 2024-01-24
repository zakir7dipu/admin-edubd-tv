@extends('layouts.master')

@section('title', 'Lesson Quiz List')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-list"></i> @yield('title')</h4>
        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.lesson-quiz.index') }}">Course Lesson Quiz</a></li>
        </ul>
    </div>
    <form method="GET">
        <div class="row mt-2 mb-1">
            <div class="col-md-5">
                <div class="input-group" style="width: 100%">
                    <span class="input-group-addon width-30" style="text-align: left">
                       Course Lesson
                    </span>
                    <select name="lesson_id" id="courseLesson" class="form-control select2">
                        <option value="">- Select Lesson -</option>
                        @foreach($course_lessons as $lesson_id => $lesson_title)
                            <option value="{{ $lesson_id }}">{{ $lesson_title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-7">
                <div class="row">
                    {{-- <div class="col-md-6">
                        <div class="input-group" style="width: 100%">
                            <span class="input-group-addon">
                                Exam
                            </span>
                            <select name="exam_id" id="exams" onchange="fetchChapters(this)" class="form-control select2" data-placeholder="- Select -" width="100%">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group" style="width: 100%">
                            <span class="input-group-addon ">
                                Chapter
                            </span>
                            <select name="chapter_id" id="chapters" class="form-control select2" data-placeholder="- Select -" width="100%">
                                <option></option>
                            </select>
                        </div>
                    </div> --}}
                </div>
            </div>
        
            {{-- <div class="col-md-5">
                <div class="input-group" style="width: 100%">
                    <span class="input-group-addon width-30">
                        Search Title
                    </span>
                    <input type="text" class="form-control" name="title" value="{{ request('title') }}">
                </div>
            </div> --}}
            <div class="col-md-7 text-right">
                <div class="btn-group">
                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Search"
                        class="btn btn-sm btn-yellow"
                        style="height: 33px; width: 35px; border-top-left-radius: 2px; border-bottom-left-radius: 2px"><i
                            class="fa fa-search"></i></button>
                    <button type="button" data-toggle="tooltip" data-placement="top" title="Reset"
                        class="btn btn-sm btn-black" onclick="location.href='{{ request()->url() }}'"
                        style="height: 33px; width: 35px; border-top-right-radius: 2px; border-bottom-right-radius: 2px"><i
                            class="far fa-refresh"></i></button>
                            @if (hasPermission('lesson-quiz-create', $slugs))
                    <a class="btn btn-sm btn-theme" data-toggle="tooltip" data-placement="top" title="Add New"
                        href="{{ route('cm.lesson-quiz.create') }}" class="btn btn-sm btn-black"
                        style="height: 33px; line-height: 22px; border-top-left-radius: 2px; border-bottom-left-radius: 2px">
                        <i class="far fa-plus-circle"></i>
                        ADD NEW
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
    <div class="row mt-2">
        <div class="col-md-12">
            @include('partials._alert_message')
            <table id="myTable" class="table table-bordered">
                <thead style="border-bottom: 3px solid #346cb0 !important">
                    <tr style="background: #e1ecff !important; color:black !important">
                        <th class="text-center" width="3%">SL</th>
                        <th width="20%">Lesson</th>
                        <th width="20%">Course</th>
                        <th width="20%">Quiz Title</th>
                        <th width="20%" class="text-center">Status</th>
                        <th width="5%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lesson_quiz as $quiz)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ optional($quiz->lesson)->title }}</td>
                            <td>{{ optional($quiz->lesson->course)->title }}</td>
                            <td>{{ $quiz->name }}</td>
                            {{-- <td>{{ optional($quiz->exam)->title }}</td> --}}


                            <td class="text-center">
                                <x-status status="{{ $quiz->status }}" id="{{ $quiz->id }}" table="{{ $table }}" />
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <a href="javascript:void(0)" class="fas fa-ellipsis-h" type="button"
                                        data-toggle="dropdown"
                                        style="font-size: 20px; color: #1265D7; text-decoration: none"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if (hasPermission('lesson-quiz-edit', $slugs))
                                        <li>
                                            <a href="{{ route('cm.lesson-quiz.edit', $quiz->id) }}" title="Edit">
                                                <i class="far fa-edit"></i> Edit
                                            </a>
                                        </li>
                                        @endif
                                        @if (hasPermission('lesson-quiz-delete', $slugs))
                                        <li>
                                            <a href="javascript:void(0)" title="Delete"
                                                onclick="delete_item('{{ route('cm.lesson-quiz.destroy', $quiz->id) }}')"
                                                type="button">
                                                <i class="far fa-trash"></i> Delete
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="40" class="text-center text-danger">
                                <b>No Item Found!</b>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @include('partials._paginate', ['data' => $lesson_quiz])
        </div>
    </div>
@endsection





@section('script')
    @include('exam-quiz/_inc/script')
@endsection
