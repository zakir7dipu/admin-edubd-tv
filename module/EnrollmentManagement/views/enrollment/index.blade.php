@extends('layouts.master')

@section('title', 'Enrollment List')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-list"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Enroll Management</a></li>
            <li><a class="text-muted" href="{{ route('em.enrollment.index') }}">Enrollment</a></li>
        </ul>
    </div>
    <form method="GET" action="">
        <div class="row mt-2">
            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Student
                    </span>
                    <select name="student_id" class="form-control select2" width="100%">
                        <option value="" selected>- Select -</option>
                        @foreach ($students as $id => $first_name)
                            <option value="{{ $id }}" {{ $id == request('student_id') ? 'selected' : '' }}>
                                {{ $first_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Payment Method
                    </span>
                    <select name="payment_method_id" class="form-control select2" width="100%">
                        <option value="" selected>- Select -</option>
                        @foreach ($paymentMethods as $id => $name)
                            <option value="{{ $id }}" {{ $id == request('payment_method_id') ? 'selected' : '' }}>
                                {{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Start Date...
                    </span>
                    <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                </div>
            </div>


        </div>
        <div class="row mt-2">

            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        End Date...
                    </span>
                    <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                </div>
            </div>
            <div class="col-md-4">
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
                            class="fa fa-search"></i>
                    </button>
                    <button type="button" data-toggle="tooltip" data-placement="top" title="Reset"
                        class="btn btn-sm btn-black" onclick="location.href='{{ request()->url() }}'"
                        style="height: 33px; width: 35px; border-top-right-radius: 2px; border-bottom-right-radius: 2px"><i
                            class="far fa-refresh"></i>
                    </button>
                    {{-- <a class="btn btn-sm btn-theme" data-toggle="tooltip" data-placement="top" title="Add New"
                        href="{{ route('em.coupon.create') }}" class="btn btn-sm btn-black"
                        style="height: 33px; line-height: 22px; border-top-left-radius: 2px; border-bottom-left-radius: 2px">
                        <i class="far fa-plus-circle"></i>
                        ADD NEW
                    </a> --}}
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
                        <th width="15%">Invoice Number</th>
                        <th width="15%">Student Name</th>
                        <th width="15%">Payment Method</th>
                        <th width="15%">date</th>
                        <th width="15%">Quantity</th>
                        <th width="15%">Grand Total</th>
                        <th width="15%">Payment Status</th>
                        <th width="5%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($enrolls as $enroll)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $enroll->invoice_no }}</td>
                            <td>{{ optional($enroll->student)->first_name }}</td>
                            <td>{{ $enroll->payment_method }}</td>
                            {{-- <td>{{ optional($enroll->paymentMethod)->name }}</td> --}}
                            <td>{{ $enroll->date }}</td>
                            <td>{{ $enroll->total_quantity }}</td>
                            <td>{{ $enroll->grand_total }}</td>
                            <td>

                                <button data-id="{{ $enroll->id }}"
                                    class="status-button btn {{ $enroll->payment_status === 'Paid' ? 'btn-success' : 'btn-danger' }}">
                                    {{ $enroll->payment_status === 'Paid' ? 'Paid' : 'Due' }}
                                </button>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <a href="javascript:void(0)" class="fas fa-ellipsis-h" type="button"
                                        data-toggle="dropdown"
                                        style="font-size: 20px; color: #1265D7; text-decoration: none"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        {{-- <li>
                                            <a href="{{ route('em.coupon.edit', $enroll->id) }}" title="Edit">
                                                <i class="far fa-edit"></i> Edit
                                            </a>
                                        </li> --}}
                                        @if (hasPermission('enrollment-list-delete', $slugs))
                                        <li>
                                            <a href="javascript:void(0)" title="Delete"
                                                onclick="delete_item('{{ route('em.enrollment.destroy', $enroll->id) }}')"
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
            @include('partials._paginate', ['data' => $enrolls])
        </div>
    </div>
@endsection





@section('js')

    <script>
        $(document).on('click', '.status-button', function() {
            var $button = $(this);
            var id = $button.data('id');
            var payment_status = ($button.hasClass('btn-success')) ? 'due' : 'paid';
            $.ajax({
                url: '/enrollments/' + id + '/status',
                type: 'PUT',
                data: {
                    payment_status: payment_status
                },
                success: function() {
                    $button.removeClass('btn-success btn-danger');
                    $button.addClass((payment_status === 'paid') ? 'btn-success' : 'btn-danger');
                    $button.text((payment_status === 'paid') ? 'Paid' : 'Due');
                },
                error: function(xhr, payment_status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
