@extends('layouts.master')

@section('title', 'Create Exam')



{{-- style section  --}}
@section('style')
    @include('exam/_inc/style')
@endsection




@section('content')

    {{-- breadcrumbs section  --}}

    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Exam Management</a></li>
            <li><a class="text-muted" href="{{ route('em.exams.index') }}">Exams</a></li>
            <li class=""><a href="javascript:void(0)">Create</a></li>
        </ul>
    </div>




    <div style="margin-top: 20px">
        {{-- form section --}}
        <form action="{{ route('em.exams.store') }}" method="POST">
            @csrf
            @include('partials._alert_message')
            <div>
                <div class="row">
                    <div class="col-md-12">
                        {{-- exam title --}}
                        <div class="form-group row mb-1">
                            <label class="col-sm-12 col-md-2 col-form-label">Exam Title <span
                                    style="color: red !important">*</span></label>
                            <div class="col-sm-12 col-md-8">
                                <input type="text" class="form-control" name="title" id="name" required>
                            </div>
                        </div>


                        {{-- exam slug --}}
                        <div class="form-group row mb-1">
                            <label class="col-sm-12 col-md-2 col-form-label">Exam Slug <span
                                    style="color: red !important">*</span></label>
                            <div class="col-sm-12 col-md-8">
                                <input type="text" class="form-control" name="slug" id="slug" required>
                            </div>
                        </div>


                        {{-- description  --}}
                        <div class="form-group row mb-1">
                            <label class="col-sm-12 col-md-2 col-form-label">Description <span
                                    style="color: red !important">*</span></label>
                            <div class="col-sm-12 col-md-8">
                                <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12">

                        {{-- exam category --}}

                        <div class="form-group row mb-1">
                            <label class="col-sm-12 col-md-2 col-form-label">Exam Category <span
                                    style="color: red !important">*</span></label>
                            <div class="col-sm-12 col-md-8">
                                <select name="exam_category_id" class="form-control select2" data-placeholder="- Select -"
                                    width="100%" required>
                                    <option></option>
                                    @foreach ($examCategories as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('exam_category_id') == $id ? 'selected' : '' }}>{{ $name }}
                                        </option>
                                    @endforeach
                                    {{-- <x-course-category.course-category-options /> --}}
                                </select>
                            </div>
                        </div>



                        {{-- exam year --}}


                        <div class="form-group row mb-1">
                            <label class="col-sm-12 col-md-2 col-form-label">Exam Year <span
                                    style="color: red !important">*</span></label>
                            <div class="col-sm-12 col-md-8">
                                <select name="exam_year_id" class="form-control select2" data-placeholder="- Select -"
                                    width="100%" required>
                                    <option></option>

                                    @foreach ($examYears as $id => $year)
                                        <option value="{{ $id }}"
                                            {{ old('exam_year_id') == $id ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        {{-- institue name --}}


                        <div class="form-group row mb-1">
                            <label class="col-sm-12 col-md-2 col-form-label">Institute Name <span
                                    style="color: red !important">*</span></label>
                            <div class="col-sm-12 col-md-8">
                                <select name="institute_id" class="form-control select2" data-placeholder="- Select -"
                                    width="100%" required>
                                    <option></option>
                                    @foreach ($institutes as $key => $institute)
                                        <option value="{{ $institute->id }}"
                                            {{ old('institute_id') == $institute->id ? 'selected' : '' }}>
                                            {{ $institute->name }} - {{ $institute->short_form }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        {{-- serial number --}}


                        <div class="form-group row mb-1">
                            <label class="col-sm-12 col-md-2 col-form-label">Serial No <sup
                                    style="color: red">*</sup></label>
                            <div class="col-sm-12 col-md-8">
                                <input type="text" name="serial_no" class="form-control only-number"
                                    value="{{ old('serial_no', $nextSerialNo) }}" autocomplete="off" required>
                            </div>
                        </div>



                        {{-- status section  --}}


                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Status (Published) <sup style="color: red">*</sup></label>
                            <div class="col-sm-12 col-md-3">
                                <div class="material-switch pt-1">
                                    <input type="checkbox" name="status" id="status" value="1" checked />
                                    <label for="status" class="badge-primary"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <hr>
                <div class="">
                    <div class="">
                        <h4 class="mb-2" style="color: black">Chapter Information</h4>
                        <div id="examChapter">
                            @if (old('chapterName'))
                                @foreach (old('chapterName') ?? [] as $key => $chapterName)
                                    <div class="row chapter mb-1">
                                        <div class="col-md-3">
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
                                        <div class="col-sm-12 col-md-3">
                                            <div class="input-group">
                                                <label class="input-group-addon" style="background: #dfdfdf; color: #000000"> Slug
                                                    <span style="color: red">*</span>
                                                </label>
                                                <input type="text" class="form-control chapter-slug" name="chapterSlug[]" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="input-group">
                                                <label class="input-group-addon" style="background: #dfdfdf; color: #000000"> Duration
                                                    <span style="color: red">*</span>
                                                </label>
                                                <input type="text" id="duration-input" placeholder="HH:MM:SS" class="form-control duration" name="duration[]" autocomplete="off" required>
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
                                                        id="is_published{{ $key + 1 }}"
                                                        value="1"
                                                        {{ old('is_published')[$key] == 1 ? 'checked' : '' }}
                                                    />
                                                    <label for="is_published{{ $key + 1 }}" class="badge-primary"></label>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($key > 1)
                                            <div class="col-md-2">
                                                <i class="far fa-times-circle" onclick="removeChapter(this)" style="font-size: 20px; color: red; padding-top: 7px; cursor: pointer"></i>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="row chapter">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <label
                                                class="input-group-addon"
                                                style="background: #dfdfdf; color: #000000"
                                            > Name
                                                 <span style="color: red">*</span>
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="chapterName[]"
                                                autocomplete="off"
                                                onkeyup="generateSlug(this)"
                                                required
                                            >
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="input-group">
                                            <label class="input-group-addon" style="background: #dfdfdf; color: #000000"> Slug
                                                <span style="color: red">*</span>
                                            </label>
                                            <input type="text" class="form-control chapter-slug" name="chapterSlug[]" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="input-group">
                                            <label class="input-group-addon" style="background: #dfdfdf; color: #000000"> Duration
                                                <span style="color: red">*</span>
                                            </label>
                                            <input type="text" id="duration-input" placeholder="HH:MM:SS" class="form-control " name="duration[]" autocomplete="off" required>
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
                                                />
                                                <input
                                                    type="checkbox"
                                                    class="is-published-checkbox"
                                                    onchange="isPublishedToggle(this)"
                                                    name="is_published[]"
                                                    id="is_published1"
                                                    value="1"
                                                />
                                                <label for="is_published1" class="badge-primary"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button
                            type="button"
                            onclick="addChapter()"
                            class="add-chapter"
                            style="padding: 4px 8px;
                                border-radius: 5px;
                                background: #bfffd4 !important;
                                border: 2px solid #bfffd4;
                                color: black;
                                font-weight: 500"
                        >
                            <i class="far fa-plus-circle"></i> ADD CHAPTER
                        </button>

                        <hr>
                    </div>

                </div>
                {{-- chapter information section end --}}



            </div>

            <hr />

            {{-- submit section  --}}

            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label"></label>
                <div class="col-sm-12 col-md-9">
                    <div class="btn-group" style='float:right'>
                        <button class="btn btn-sm btn-theme">
                            <i class="far fa-check-circle"></i>
                            SUBMIT
                        </button>
                        <a class="btn btn-sm btn-yellow ml-1" href="{{ route('em.exams.index') }}">
                            <i class="far fa-long-arrow-left"></i>
                            BACK TO LIST
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection



{{-- script section  --}}
@section('script')
    @include('exam/_inc/script')
@endsection
