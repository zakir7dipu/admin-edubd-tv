@extends('layouts.master')

@section('title', 'State List')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-list"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">State</a></li>
            <li><a class="text-muted" href="{{ route('state.index') }}"></a></li>
        </ul>
    </div>
    <form method="GET">
        <div class="row mt-2">
            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Select Country
                    </span>
                    <select name="country_id" id="country" class="js-example-basic-single select2 form-control">
                        <option value="">-- Select Country --</option>
                        @foreach ($countries as $id => $name)
                            <option value="{{ $id }}" {{ request('country_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        State Name
                    </span>
                    <input type="text" class="form-control" name="name" value="{{ request('name') }}">
                </div>
            </div>
            <div class="col-md-4 text-right">
                <div class="btn-group">
                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Search" class="btn btn-sm btn-yellow" style="height: 33px; width: 35px; border-top-left-radius: 2px; border-bottom-left-radius: 2px"><i class="fa fa-search"></i></button>
                    <button type="button" data-toggle="tooltip" data-placement="top" title="Reset" class="btn btn-sm btn-black" onclick="location.href='{{ request()->url() }}'" style="height: 33px; width: 35px; border-top-right-radius: 2px; border-bottom-right-radius: 2px"><i class="far fa-refresh"></i></button>
                    @if (hasPermission('sate-create', $slugs))
                    <a class="btn btn-sm btn-theme" data-toggle="tooltip" data-placement="top" title="Add New" href="{{ route('state.create') }}" class="btn btn-sm btn-black" style="height: 33px; line-height: 22px; border-top-left-radius: 2px; border-bottom-left-radius: 2px">
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
                        <th class="text-center" width="5%">SL</th>
                        <th width="40%">State Name</th>
                        <th width="40%">Country Name</th>
                        <th width="40%">City</th>
                        <th width="5%" class="text-center">Status</th>

                        <th width="10%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($states as $state)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $state->name }}</td>
                            <td>
                             <a href="{{ route('country.index') }}">
                                {{ $state->country->name }}
                             </a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('city.index') }}?country_id={{ $state->country->id }}" class="badge" style="background: #5000db; font-weight: 600">
                                    {{ $state->totalCity}}
                                </a>
                            </td>

                            <td class="text-center">
                                <x-status status="{{ $state->status }}" id="{{ $state->id }}" table="{{ $table }}" />
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <a href="javascript:void(0)" class="fas fa-ellipsis-h" type="button" data-toggle="dropdown" style="font-size: 20px; color: #1265D7; text-decoration: none"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if (hasPermission('sate-edit', $slugs))
                                        <li>
                                            <a href="{{ route('state.edit', $state->id) }}" title="Edit">
                                                <i class="far fa-edit"></i> Edit
                                            </a>
                                        </li>
                                        @endif
                                        @if (hasPermission('sate-delete', $slugs))
                                        <li>
                                            <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('state.destroy', $state->id) }}')" type="button">
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
            @include('partials._paginate', ['data' => $states])
        </div>
    </div>
@endsection





@section('js')
@endsection
