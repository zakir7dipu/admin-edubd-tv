@extends('layouts.master')

@section('title', 'Course List')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-list"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.courses.index') }}">Course</a></li>
        </ul>
    </div>
    <form method="GET">
        <div class="row mt-2">
            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Category
                    </span>
                    <select name="course_category_id" class="form-control select2" width="100%">
                        <option value="" selected>- Select -</option>
                        <x-course-category.course-category-options />
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Type
                    </span>
                    <select name="course_type" class="form-control select2" width="100%">
                        <option value="" selected>- Select -</option>
                        @foreach (courseTypes() as $type)
                            <option value="{{ $type }}" {{ $type == request('course_type') ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Level
                    </span>
                    <select name="course_level_id" class="form-control select2" width="100%">
                        <option value="" selected>- Select -</option>
                        @foreach ($courseLevels as $id => $name)
                            <option value="{{ $id }}" {{ $id == request('course_level_id') ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Language
                    </span>
                    <select name="course_language_id" class="form-control select2" width="100%">
                        <option value="" selected>- Select -</option>
                        @foreach ($courseLanguages as $id => $name)
                            <option value="{{ $id }}" {{ $id == request('course_language_id') ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Title
                    </span>
                    <input type="text" class="form-control" name="title" value="{{ request('title') }}">
                </div>
            </div>
            <div class="col-md-4 text-right">
                <div class="btn-group">
                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Search" class="btn btn-sm btn-yellow" style="height: 33px; width: 35px; border-top-left-radius: 2px; border-bottom-left-radius: 2px"><i class="fa fa-search"></i></button>
                    <button type="button" data-toggle="tooltip" data-placement="top" title="Reset" class="btn btn-sm btn-black" onclick="location.href='{{ request()->url() }}'" style="height: 33px; width: 35px; border-top-right-radius: 2px; border-bottom-right-radius: 2px"><i class="far fa-refresh"></i></button>
                    @if (hasPermission('course-create', $slugs))
                    <a class="btn btn-sm btn-theme" data-toggle="tooltip" data-placement="top" title="Add New" href="{{ route('cm.courses.create') }}" class="btn btn-sm btn-black" style="height: 33px; line-height: 22px; border-top-left-radius: 2px; border-bottom-left-radius: 2px">
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
                        <th class="text-center" width="2%">SL</th>
                        <th width="200px">Course Info</th>
                        <th width="10%">Type</th>
                        <th width="10%">Level</th>
                        <th width="80px">Category</th>
                        <th width="10%">Language</th>
                        {{-- <th width="5%" class="text-center">Intro</th> --}}
                        <th width="5%" class="text-center">Status</th>
                        <th width="5%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                        <tr>
                            <td class="text-center" style="padding-top: 24px">{{ $loop->iteration }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 5px; width: 100%">
                                    @if ($course->thumbnail_image != '' && file_exists($course->thumbnail_image))
                                        <img src="{{ asset($course->thumbnail_image) }}" width="50px" height="50px" alt="{{ $course->slug }}">
                                    @else
                                        <img src="{{ asset('assets/img/no-img.png') }}" width="50px" height="50px" alt="{{ $course->slug }}">
                                    @endif
                                    <div style="background: #dfdfdf; width: 1px !important; height: 50px !important"></div>
                                    <div style="display: flex; flex-direction: column; width: 100%">
                                        <p style="color: black; font-weight: 500; line-height: 15px;">
                                            {{ $course->title }}
                                            @if ($course->is_published)
                                                <i class="fas fa-badge-check" style="color: blue"></i>
                                            @endif
                                        </p>
                                        <div style="display: flex; align-items: center !important; justify-content: space-between;">
                                            <div style="color: #f43f5e; display: flex; align-items: center !important; font-size: 11px; font-weight: 600; gap: 3px; border-radius: 50px">
                                                <i class="fas fa-star" style="font-size: 9px; "></i> <span>{{ $course->average_rating }}</span>
                                            </div>
                                            <div>
                                                <!-- @if ($course->is_premier)
                                                    <small style="color: #000470; font-weight: 600"><i class="fal fa-check-double"></i> Premier</small>
                                                @endif -->
                                                @if ($course->is_popular)
                                                    <small style="color: #135902; font-weight: 600"><i class="fal fa-award"></i> Popular</small>
                                                @endif
                                            </div>
                                            <div class="text-right" style="color: rgb(0, 0, 196); margin-bottom: 0px">
                                                <b>৳ {{ number_format($course->course_fee, 2, '.', '') }}</b>
                                                @if ($course->discount_amount > 0)
                                                    <br>
                                                    <del style="color: black">৳ {{ number_format($course->regular_fee, 2, '.', '') }}</del>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </td>
                            <td>{{ $course->course_type }}</td>
                            <td>{{ optional($course->level)->name }}</td>
                            <td>{{ optional($course->category)->name }}</td>
                            <td>{{ optional($course->language)->name }}</td>
                            {{-- <td>
                                @if ($course->intro_video != '')
                                    <iframe height="50" width="50" src="{{ $course->intro_video }}" title="{{ $course->title }}" frameBorder="0" allowFullScreen></iframe>
                                @endif
                            </td> --}}
                            <td class="text-center">
                                @if ($course->is_published)
                                    <x-status status="{{ $course->status }}" id="{{ $course->id }}" table="{{ $table }}" />
                                @else
                                    <a href="javascript:void(0)" onclick="alert('You can not change status because this is a unpublished course!')">
                                        <i class="fa fa-toggle-on" style="font-size: 20px; color: #dfdfdf"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="text-center" colspan="6">
                                <div class="dropdown">
                                    <a href="javascript:void(0)" class="fas fa-ellipsis-h" type="button" data-toggle="dropdown" style="font-size: 20px; color: #1265D7; text-decoration: none"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if (hasPermission('course-edit', $slugs))
                                        <li>
                                            <a href="{{ route('cm.courses.edit', $course->id) }}" title="Edit">
                                                <i class="far fa-edit"></i> Edit
                                            </a>
                                        </li>
                                        @endif
                                        @if (hasPermission('course-delete', $slugs))
                                        <li>
                                            <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('cm.courses.destroy', $course->id) }}')" type="button">
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
            @include('partials._paginate', ['data' => $courses])
        </div>
    </div>
@endsection





@section('js')
@endsection