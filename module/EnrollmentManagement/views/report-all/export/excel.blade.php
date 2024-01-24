<table id="dynamic-table" class="table table-striped table-bordered table-hover">
    <thead>
        @if (request('export_type') == 'excel')
            <tr>
                <th colspan="9" style="text-align: center">Report List</th>
            </tr>
        @endif
                <tr>
                    <th>SL</th>
                    <th>Student Name</th>
                    <th >Course Name</th>
                    <th>Date</th>
                    <th >Invoice Number</th>
                    <th>Payment Method</th>
                    <th >Grand Total</th>
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
                <td colspan="30" class="text-center text-danger py-3"
                    style="background: #eaf4fa80 !important; font-size: 18px">
                    <strong>No records found!</strong>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
