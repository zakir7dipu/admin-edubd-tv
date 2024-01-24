@extends('layouts.master')

@section('title', 'Edit Exam')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Exam Management</a></li>
            <li><a class="text-muted" href="{{ route('em.exams.index') }}">Exam</a></li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>
    <form action="{{ route('em.exams.update', $exam->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('partials._alert_message')
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Exam Category <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <select name="exam_category_id" id="exam_category_id" class=" select2 form-control">
                            <option value="">-- Select Category --</option>
                            @foreach ($examCategory as $id => $name)
                                <option value="{{ $id }}" {{ $exam->exam_category_id == $id ? ' selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Exam Year <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <select name="exam_year_id" id="exam_year_id" class=" select2 form-control">
                            <option value="">-- Select Year --</option>
                            @foreach ($examYear as $id => $year)
                                <option value="{{ $id }}" {{ $exam->exam_year_id == $id ? ' selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Institute<sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <select name="institute_id" id="institute_id" class=" select2 form-control">
                            <option value="">-- Select Institute --</option>
                            @foreach ($institute as $key => $institute)
                                <option value="{{ $institute->id }}" {{ $exam->institute_id == $institute->id ? ' selected' : '' }}>
                                    {{ $institute->name }} - {{ $institute->short_form }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>





            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Title <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="title" id="name"
                            value="{{ old('title', $exam->title) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Slug <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="slug" id="slug"
                            value="{{ old('slug', $exam->slug) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label"> Description</label>
                    <div class="col-sm-12 col-md-8">
                        <textarea name="description" class="form-control" rows="2" autocomplete="off">{{ old('description', $exam->description) }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Serial No <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <input type="text" name="serial_no" class="form-control only-number"
                            value="{{ old('serial_no', $exam->serial_no) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Status (Published) <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="status" id="status" value="1"
                                {{ $exam->status ? 'checked' : '' }} />
                            <label for="status" class="badge-primary"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <h4 class="mb-2" style="color: black">Chapter Information</h4>
                <div id="examChapter">
                    @if (old('chapterName'))
                        {{-- @foreach (old('chapterName') ?? [] as $key => $chapterName)
                            <input type="hidden" name="chapter_id[]" value="{{ old('chapter_id')[$key] }}">
                            <div class="row chapter mb-1">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <label
                                            class="input-group-addon"
                                            style="background: #dfdfdf; color: #000000"
                                        >
                                            Name: {{ $loop->iteration }} <span style="color: red">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="chapterName[]"
                                            value="{{ $chapterName }}"
                                            autocomplete="off"
                                            onkeyup="generateSlug(this)"
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Name
                                            <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="chapterSlug[]"
                                            value="{{ $chapter->slug }}" id="chapterSlug" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group" style="display: flex; justify-content: space-between;">
                                        <label class="col-form-label">Is Published</label>
                                        <div class="material-switch pt-1">
                                            <input
                                                type="hidden"
                                                class="is-published-default-value"
                                                name="is_published[]"
                                                value="0"
                                                {{ old('is_published')[$key] == 0 ? 'disabled' : '' }}
                                            />
                                            <input
                                                type="checkbox"
                                                class="is-published-checkbox"
                                                onchange="isPublishedToggle(this)"
                                                name="is_published[]"
                                                id="isPublished{{ $loop->iteration }}"
                                                value="1"
                                                {{ old('is_published')[$key] == 1 ? 'checked' : '' }}
                                            />
                                            <label for="isPublished{{ $loop->iteration }}" class="badge-primary"></label>
                                        </div>
                                    </div>
                                </div>
                                @if ($key > 1)
                                    <div class="col-md-2">
                                        <i class="far fa-times-circle" onclick="removeChapter(this)" style="font-size: 20px; color: red; padding-top: 7px; cursor: pointer"></i>
                                    </div>
                                @endif
                            </div>
                        @endforeach --}}
                    @else
                        @foreach ($exam->examChapters as $key => $chapter)
                            <input type="hidden" name="chapter_id[]" value="{{ $chapter->id }}">
                            <div class="row chapter mb-1">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label
                                            class="input-group-addon"
                                            style="background: #dfdfdf; color: #000000"
                                        >
                                            Name: <span style="color: red">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="chapterName[]"
                                            autocomplete="off"
                                            value="{{ $chapter->name }}"
                                            onkeyup="generateSlug(this)"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Slug
                                            <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="chapterSlug[]"
                                            value="{{ $chapter->slug }}" id="chapterSlug" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="input-group">
                                        <label class="input-group-addon" style="background: #dfdfdf; color: #000000"> Duration
                                            <span style="color: red"></span>
                                        </label>
                                        <input type="text" value="{{ $chapter->duration }}" id="duration-input" placeholder="HH:MM:SS" class="form-control " name="duration[]" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group" style="display: flex; justify-content: space-between;">
                                        <label class="col-form-label">Is Published</label>
                                        <div class="material-switch pt-1">
                                            <input
                                                type="hidden"
                                                class="is-published-default-value"
                                                name="is_published[]"
                                                value="0"
                                                {{ $chapter->is_published ? 'disabled' : '' }}
                                            />
                                            <input
                                                type="checkbox"
                                                class="is-published-checkbox"
                                                onclick="isPublishedToggle(this)"
                                                name="is_published[]"
                                                id="isPublished{{ $chapter->id }}"
                                                value="1"
                                                {{$chapter->is_published ? 'checked' : '' }}
                                            />
                                            <label for="isPublished{{ $chapter->id }}" class="badge-primary"></label>
                                        </div>
                                    </div>
                                </div>
                                @if ($key >= 1)
                                    <div class="col-md-2">
                                        <i class="far fa-trash" onclick="delete_item('{{ route('em.delete-exam-chapter', $chapter->id) }}')" style="font-size: 20px; color: red; padding-top: 7px; cursor: pointer"></i>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
                <button
                    type="button"
                    onclick="addChapter()"
                    class="add-option"
                    style="padding: 4px 8px;
                        border-radius: 5px;
                        background: #bfffd4 !important;
                        border: 2px solid #bfffd4;
                        color: black;
                        font-weight: 500;
                       "
                >
                    <i class="far fa-plus-circle"></i> ADD CHAPTER
                </button>
            </div>
        </div>
        <div class="row mt-3 ml-1">
            <div class="form-group row">
                <div class="col-sm-12 col-md-8">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-theme">
                            <i class="far fa-edit"></i>
                            UPDATE
                        </button>
                        <a class="btn btn-sm btn-yellow ml-1" href="{{ route('em.exams.index') }}">
                            <i class="far fa-long-arrow-left"></i>
                            BACK TO LIST
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    @include('exam/_inc/script')
@endsection
