<style>
    /* Define the CSS styles for the PDF table */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    th {
        background-color: #f5f5f5;
        font-weight: bold;
    }

    .text-center {
        text-align: center;
    }

    .text-danger {
        color: red;
    }

    .py-3 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    .text-success {
        color: green;
    }

    .text-info {
        color: blue;
    }
</style>

<table id="dynamic-table" class="table table-striped table-bordered table-hover">
    <thead>
        @if (request('pdf_type') == 'pdf')
            <tr>
                <th colspan="7" style="text-align: center; background-color: #f5f5f5; font-weight: bold;">Sales Report List</th>
            </tr>
        @endif
        <tr>
            <tr>
                <th colspan="7" style="text-align: center; background-color: #f5f5f5; font-weight: bold;">Sales Report List</th>
            </tr>
            <th class="text-center" width="5%">SL</th>
            <th>Student Name</th>
            <th>Course Name</th>
            <th>Date</th>
            <th>Invoice Number</th>
            <th>Payment Method</th>
            <th>Grand Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($enrolls as $enroll)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ optional(optional($enroll->enrollment)->student)->first_name ?? 'N/A' }}</td>                      
                <td>{{ optional($enroll->course)->title }}</td>
                <td>{{ $enroll->created_date }}</td>
                <td>{{ optional($enroll->enrollment)->invoice_no }}</td>
                <td>{{ optional($enroll->enrollment)->payment_method }}</td>
                <td>{{ $enroll->course_fee }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-danger py-3">
                    <strong>No records found!</strong>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
