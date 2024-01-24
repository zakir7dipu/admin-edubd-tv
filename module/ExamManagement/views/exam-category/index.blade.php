@extends('layouts.master')

@section('title', 'Exam Category List')

@section('content')

    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-list"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('em.exam-categories.index') }}">Course Category</a></li>
        </ul>
    </div>
    <form method="GET">
        <div class="row mt-2">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-7">
                        <div class="input-group width-100" style="width: 100%">
                            <span class="input-group-addon" style="text-align: left">
                                Parent Category
                            </span>
                            <select name="parent_id" class="form-control select2" width="100%">
                                <option value="" selected>- Select -</option>
                                <x-exam-category.exam-category-options />
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group width-100" style="width: 100%">
                            <span class="input-group-addon" style="text-align: left">
                                Search by Name
                            </span>
                            <input type="text" class="form-control" name="name" value="{{ request('name') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-right">
                <div class="btn-group">
                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Search" class="btn btn-sm btn-yellow" style="height: 33px; width: 35px; border-top-left-radius: 2px; border-bottom-left-radius: 2px"><i class="fa fa-search"></i></button>
                    <button type="button" data-toggle="tooltip" data-placement="top" title="Reset" class="btn btn-sm btn-black" onclick="location.href='{{ request()->url() }}'" style="height: 33px; width: 35px; border-top-right-radius: 2px; border-bottom-right-radius: 2px"><i class="far fa-refresh"></i></button>
                    @if (hasPermission('exam-category-create', $slugs))
                    <a class="btn btn-sm btn-theme" data-toggle="tooltip" data-placement="top" title="Add New" href="{{ route('em.exam-categories.create') }}" class="btn btn-sm btn-black" style="height: 33px; line-height: 22px; border-top-left-radius: 2px; border-bottom-left-radius: 2px">
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
                        <th width="19%">Category Name</th>
                        <th width="20%">Short Description</th>
                        <th width="19%">Parent Category</th>
                        <th width="7%" class="text-center">Serial No</th>
                        <th width="12%" class="text-center">Child Category</th>
                        <th width="10%" class="text-center">Show in Menu</th>
                        <th width="5%" class="text-center">Status</th>
                        <th width="5%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($examCategories as $examCategory)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ $examCategory->slug }}" target="_blank" style="font-weight: 600">
                                    {{ $examCategory->name }}
                                </a>
                            </td>
                            <td>{{ $examCategory->short_description }}</td>
                            <td>
                                <a href="{{ route('em.exam-categories.index') }}?id={{ $examCategory->parent_id }}" style="color: #5000db; font-weight: 600">
                                    {{ optional($examCategory->parentExamCategory)->name }}
                                </a>
                            </td>
                            <td class="text-center" style="font-weight: 600">{{ $examCategory->serial_no }}</td>
                            <td class="text-center">
                                <a href="{{ route('em.exam-categories.index') }}?parent_id={{ $examCategory->id }}" class="badge" style="background: #5000db; font-weight: 600">
                                    {{ $examCategory->totalChildExamCategories }}
                                </a>
                            </td>
                            <td class="text-center">
                                <span class="badge label-{{ $examCategory->show_in_menu ? 'primary' : 'danger' }}">
                                    {{ $examCategory->show_in_menu ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <x-status status="{{ $examCategory->status }}" id="{{ $examCategory->id }}" table="{{ $table }}" />
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <a href="javascript:void(0)" class="fas fa-ellipsis-h" type="button" data-toggle="dropdown" style="font-size: 20px; color: #1265D7; text-decoration: none"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if (hasPermission('exam-category-edit', $slugs))
                                        <li>
                                            <a href="{{ route('em.exam-categories.edit', $examCategory->id) }}" title="Edit">
                                                <i class="far fa-edit"></i> Edit
                                            </a>
                                        </li>
                                        @endif
                                        @if (hasPermission('exam-category-delete', $slugs))
                                        <li>
                                            <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('em.exam-categories.destroy', $examCategory->id) }}')" type="button">
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
            @include('partials._paginate', ['data' => $examCategories])
        </div>
    </div>
@endsection





@section('js')
@endsection
