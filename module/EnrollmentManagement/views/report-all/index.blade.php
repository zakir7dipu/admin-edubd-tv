@extends('layouts.master')

@section('title', 'Sales Report')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-list"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Enroll Management</a></li>
            <li><a class="text-muted" href="{{ route('em.report.index') }}">Sales Report</a></li>
        </ul>
    </div>
    <form method="GET">
        @csrf
        <div class="row mt-2">
            {{-- <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Student
                    </span>
                   
                    <select name="enrollment_id" class="form-control select2" width="100%">
                        <option value="" selected>- Select -</option>
                        @foreach ($students as $id => $first_name)
                            <option value="{{ $id }}" {{ $id == request('student_id') ? 'selected' : '' }}>
                                {{ $first_name }}</option>
                        @endforeach
                    </select> 
                </div>
            </div> --}}
           
            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Invoice No
                    </span>
                    <select name="enrollment_id" class="form-control select2" width="100%">
                        <option value="" selected>- Select -</option>
                        @foreach ($enrollment as $id => $invoice_no)
                            <option value="{{ $id }}" {{ $id == request('enrollment_id') ? 'selected' : '' }}>
                                {{ $invoice_no }}</option>
                        @endforeach
                    </select> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Course Name 
                    </span>
                    <select name="course_id" class="form-control select2" width="100%">
                        <option value="" selected>- Select -</option>
                        @foreach ($courses as $id => $title)
                            <option value="{{ $id }}" {{ $id == request('course_id') ? 'selected' : '' }}>
                                {{ $title }}</option>
                        @endforeach
                    </select>               
                 </div>
            </div>
        </div>

        <div class="row mt-2">

            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Start Date...
                    </span>
                    <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        End Date...
                    </span>
                    <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
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
                        <th width="15%">Student Name</th>
                        <th width="15%">Course Name</th>
                        <th width="15%">Date</th>
                        <th width="15%">Invoice Number</th>
                        <th width="15%">Payment Method</th>
                        <th width="15%">Grand Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($enrolls as $enroll)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ optional(optional($enroll->enrollment)->student)->first_name ?? 'N/A' }}</td>                      
                            <td>{{ optional($enroll->course)->title}}</td>
                            <td>{{ $enroll->created_date}}</td>
                            <td>{{ optional($enroll->enrollment)->invoice_no }}</td>
                            <td>{{ optional($enroll->enrollment)->payment_method }}</td>
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
        <div class="pull-left" style="margin-top:10px; margin-left:10px">
            <a class="hidden-print" href="{{ url()->current() }}?export_type=excel&{{ request()->getQueryString() }}" target="_blank" style="margin: 18px 0 0 20px; display: inline-block;">
                <img src="{{ asset('assets/images/export-icons/excel-icon.png') }}">
            </a>
            <a class="hidden-print" href="{{ url()->current() }}?pdf_type=excel&{{ request()->getQueryString() }}" target="_blank" style="margin: 18px 0 0 20px; display: inline-block;">
                <img src="{{ asset('assets/images/export-icons/pdf-icon.png') }}">
            </a>
        </div>
    </div>
@endsection





@section('js')

<script type="text/javascript">
    function exportData(url) {
        $('#exportForm').attr('action', url).submit();
    }
</script>
@endsection
