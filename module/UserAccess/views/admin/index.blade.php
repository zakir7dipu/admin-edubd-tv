@extends('layouts.master')

@section('title', 'Admin List')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-list"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">User Access</a></li>
            <li><a class="text-muted" href="{{ route('ua.admin.index') }}">Admin</a></li>
        </ul>
    </div>
    <form method="GET">
        <div class="row mt-2">

            <div class="col-md-8">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Search...
                    </span>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4 text-right">
                <div class="btn-group">
                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Search"
                        class="btn btn-sm btn-yellow"
                        style="height: 33px; width: 35px; border-top-left-radius: 2px; border-bottom-left-radius: 2px"><i
                            class="fa fa-search"></i></button>
                    <button type="button" data-toggle="tooltip" data-placement="top" title="Reset"
                        class="btn btn-sm btn-black" onclick="location.href='{{ request()->url() }}'"
                        style="height: 33px; width: 35px; border-top-right-radius: 2px; border-bottom-right-radius: 2px"><i
                            class="far fa-refresh"></i></button>
                            @if (hasPermission('admin-create', $slugs))
                    <a class="btn btn-sm btn-theme" data-toggle="tooltip" data-placement="top" title="Add New"
                        href="{{ route('ua.admin.create') }}" class="btn btn-sm btn-black"
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
                        <th class="text-center" width="2%">SL</th>
                        <th class="text-center" width="10%">Name</th>

                        <th class="text-center" width="10%">email</th>
                        <th width="5%" class="text-center">Status</th>
                        <th width="5%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $admin)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 5px">
                                    @if ($admin->image != '' && file_exists($admin->image))
                                        <img src="{{ asset($admin->image) }}" class="img-thumbnail img-circle" width="50px" height="50px" alt="{{ $admin->username }}">
                                    @else
                                        <img src="{{ asset('assets/img/default.png') }}" class="img-thumbnail img-circle" width="50px" height="50px" alt="{{ $admin->username }}">
                                    @endif
                                    <div style="display: flex; flex-direction: column; gap: 2px; line-height: 10px">
                                        <p style="color: black; font-weight: 500">{{ $admin->first_name }} {{ $admin->last_name }}</p>
                                        <b style="color: blue">{{ '@' . $admin->username }}</b>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                {{ $admin->email }}
                            </td>


                            <td class="text-center">
                                <x-status status="{{ $admin->status }}" id="{{ $admin->id }}"
                                    table="{{ $table }}" />
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-corner">
                                    @if(hasPermission("admin-edit", $slugs))

                                    <a href="{{ route('ua.admin.edit', $admin->id) }}" class="btn btn-xs btn-sm btn-success" title="Edit">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    @endif
                                    @if(hasPermission("admin-delete", $slugs))
                                    <button type="button" onclick="delete_item('{{ route('ua.admin.destroy', $admin->id) }}')" class="btn btn-xs btn-sm btn-danger" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    @endif
                                    @if(hasPermission("permission-edit", $slugs))
                                    <a href="{{ route('ua.permission-access.edit',$admin->id) }}" class="btn btn-xs btn-info pull-center" title="Change Permission">
                                        <i class="fa fa-lock"></i>
                                    </a>
                                @endif
                                </div>

                               
                            </td>
                            {{-- <td class="text-center">
                                <div class="dropdown">
                                    <a href="javascript:void(0)" class="fas fa-ellipsis-h" type="button"
                                        data-toggle="dropdown"
                                        style="font-size: 20px; color: #1265D7; text-decoration: none"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if (hasPermission('admin-create', $slugs))
                                        <li>
                                            <a href="{{ route('ua.admin.edit', $admin->id) }}" title="Edit">
                                                <i class="far fa-edit"></i> Edit
                                            </a>
                                        </li>
                                        @endif
                                        <li>
                                            <a href="javascript:void(0)" title="Delete"
                                                onclick="delete_item('{{ route('ua.admin.destroy', $admin->id) }}')"
                                                type="button">
                                                <i class="far fa-trash"></i> Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td> --}}
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
            @include('partials._paginate', ['data' => $admins])
        </div>
    </div>
@endsection





@section('js')
@endsection
