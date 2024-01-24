@extends('layouts.master')

@section('title', 'Today Sales Report')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-list"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Enroll Management</a></li>
            <li><a class="text-muted" href="{{ route('em.report.index') }}">Today Sales Report</a></li>
        </ul>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            @include('partials._alert_message')
            <table id="myTable" class="table table-bordered">
                <thead style="border-bottom: 3px solid #346cb0 !important">
                    <tr style="background: #e1ecff !important; color:black !important">
                        <th class="text-center" width="5%">SL</th>
                        <th width="15%">Course Name</th>
                        <th width="15%">Invoice Number</th>
                        <th width="15%">Payment Method</th>
                        <th width="15%">Grand Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($enrolls as $enroll)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $enroll->course->title}}</td>
                            <td>{{ $enroll->enrollment->invoice_no }}</td>
                            <td>{{ $enroll->enrollment->payment_method }}</td>
                            <td>{{ $enroll->course_fee }}</td>
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
