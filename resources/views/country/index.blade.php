@extends('layouts.master')

@section('title', 'Country List')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-list"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Country</a></li>
            <li><a class="text-muted" href="{{ route('country.index') }}"></a></li>
        </ul>
    </div>
    <form method="GET">
        <div class="row mt-2">
            <div class="col-md-2">
            </div>
            <div class="col-md-6">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Search..
                    </span>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4 text-right">
                <div class="btn-group">
                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Search" class="btn btn-sm btn-yellow" style="height: 33px; width: 35px; border-top-left-radius: 2px; border-bottom-left-radius: 2px"><i class="fa fa-search"></i></button>
                    <button type="button" data-toggle="tooltip" data-placement="top" title="Reset" class="btn btn-sm btn-black" onclick="location.href='{{ request()->url() }}'" style="height: 33px; width: 35px; border-top-right-radius: 2px; border-bottom-right-radius: 2px"><i class="far fa-refresh"></i></button>

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
                        <th width="25%">Country Name</th>
                        <th width="25%">Country Code</th>
                        <th width="5%">State</th>
                        <th width="5%">City</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($countries as $key=> $country)

                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $country->name }}</td>
                            <td>
                             {{ $country->code }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('state.index') }}?country_id={{ $country->id }}" class="badge" style="background: #5000db; font-weight: 600">
                                    {{-- @dd(optional($country->totalStates)) --}}
                                    {{ $country->totalStates}}
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('city.index') }}?country_id={{ $country->id }}" class="badge" style="background: #5000db; font-weight: 600">
                                    {{ $country->totalCity}}
                                </a>
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
            @include('partials._paginate', ['data' => $countries])
        </div>
    </div>
@endsection





@section('js')
@endsection
