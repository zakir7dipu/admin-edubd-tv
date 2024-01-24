@extends('layouts.master')

@section('title', 'Course Category List')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-list"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.course-categories.index') }}">Course Category</a></li>
        </ul>
    </div>
    <form method="GET">
        <div class="row mt-2">
            <div class="col-md-5">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Parent Category
                    </span>
                    <select name="parent_id" class="form-control select2" width="100%">
                        <option value="" selected>- Select -</option>
                        <x-course-category.course-category-options />
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Search by Name
                    </span>
                    <input type="text" class="form-control" name="name" value="{{ request('name') }}">
                </div>
            </div>
            <div class="col-md-3 text-right">
                <div class="btn-group">
                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Search" class="btn btn-sm btn-yellow" style="height: 33px; width: 35px; border-top-left-radius: 2px; border-bottom-left-radius: 2px"><i class="fa fa-search"></i></button>
                    <button type="button" data-toggle="tooltip" data-placement="top" title="Reset" class="btn btn-sm btn-black" onclick="location.href='{{ request()->url() }}'" style="height: 33px; width: 35px; border-top-right-radius: 2px; border-bottom-right-radius: 2px"><i class="far fa-refresh"></i></button>
                    @if (hasPermission('course-category-create', $slugs))
                    <a class="btn btn-sm btn-theme" data-toggle="tooltip" data-placement="top" title="Add New" href="{{ route('cm.course-categories.create') }}" class="btn btn-sm btn-black" style="height: 33px; line-height: 22px; border-top-left-radius: 2px; border-bottom-left-radius: 2px">
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
                        <th width="20%">Category Name</th>
                        <th width="20%">Parent Category</th>
                        <th width="5%">Icon</th>
                        <th width="7%" class="text-center">Serial No</th>
                        <th width="11%" class="text-center">Child Category</th>
                        <th width="10%" class="text-center">Highlight</th>
                        <th width="10%" class="text-center">Show in Menu</th>
                        <th width="5%" class="text-center">Status</th>
                        <th width="5%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courseCategories as $courseCategory)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ $courseCategory->slug }}" target="_blank" style="font-weight: 600">
                                    {{ $courseCategory->name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('cm.course-categories.index') }}?id={{ $courseCategory->parent_id }}" style="color: #5000db; font-weight: 600">
                                    {{ optional($courseCategory->parentCourseCategory)->name }}
                                </a>
                            </td>
                            <td>
                                @if ($courseCategory->icon != '' && file_exists($courseCategory->icon))
                                    <img src="{{ asset($courseCategory->icon) }}" width="50px" height="50px" alt="{{ $courseCategory->slug }}">
                                @else
                                    <img src="{{ asset('assets/img/no-img.png') }}" width="50px" height="50px" alt="{{ $courseCategory->slug }}">
                                @endif
                            </td>
                            <td class="text-center" style="font-weight: 600">{{ $courseCategory->serial_no }}</td>
                            <td class="text-center">
                                <a href="{{ route('cm.course-categories.index') }}?parent_id={{ $courseCategory->id }}" class="badge" style="background: #5000db; font-weight: 600">
                                    {{ $courseCategory->totalChildCourseCategories }}
                                </a>
                            </td>
                            <td class="text-center">
                                <span class="badge label-{{ $courseCategory->is_highlighted ? 'primary' : 'danger' }}">
                                    {{ $courseCategory->is_highlighted ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge label-{{ $courseCategory->show_in_menu ? 'primary' : 'danger' }}">
                                    {{ $courseCategory->show_in_menu ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <x-status status="{{ $courseCategory->status }}" id="{{ $courseCategory->id }}" table="{{ $table }}" />
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <a href="javascript:void(0)" class="fas fa-ellipsis-h" type="button" data-toggle="dropdown" style="font-size: 20px; color: #1265D7; text-decoration: none"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if (hasPermission('course-category-edit', $slugs))
                                        <li>
                                            <a href="{{ route('cm.course-categories.edit', $courseCategory->id) }}" title="Edit">
                                                <i class="far fa-edit"></i> Edit
                                            </a>
                                        </li>
                                        @endif
                                        @if (hasPermission('course-category-delete', $slugs))
                                        <li>
                                            <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('cm.course-categories.destroy', $courseCategory->id) }}')" type="button">
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
            @include('partials._paginate', ['data' => $courseCategories])
        </div>
    </div>
@endsection





@section('js')
@endsection