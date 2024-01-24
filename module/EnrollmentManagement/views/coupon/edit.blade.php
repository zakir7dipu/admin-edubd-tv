@extends('layouts.master')

@section('title', 'Coupon Edit')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Order Management</a></li>
            <li><a class="text-muted" href="{{ route('em.coupon.index') }}">Coupon</a></li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>

    <form action="{{ route('em.coupon.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('partials._alert_message')

        <div class="row mt-2" style="height:100%; display:flex; justify-content:center; align-items:center">
            <div class="col-md-6">

                {{-- <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Use Type<sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <select name="use_type" id="use_type" class=" select2 form-control" required>
                            <option value="Once"@if ($coupon->use_type == 'Once') selected='selected' @endif>Once</option>
                            <option value="Multiple"@if ($coupon->use_type == 'Multiple') selected='selected' @endif>Multiple
                            </option>
                        </select>
                    </div>
                </div> --}}
                <div class="form-group row mb-1">
                    <label class="col-sm-12 col-md-3 col-form-label">Course Name <span
                            style="color: red !important"></span></label>
                    <div class="col-sm-12 col-md-9">
                        <select name="course_id" class="form-control select2" width="100%" id="course_id">
                            <option value="" selected>- Select -</option>

                            @foreach ($courses as $id => $title)
                                <option value="{{ $id }}" {{ $coupon->course_id == $id ? 'selected' : '' }}>
                                    {{ $title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Name <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input id="name" type="text" class="form-control" name="name"
                            value="{{ old('name', $coupon->name) }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Code <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input id="code" type="text" class="form-control" name="code"
                            value="{{ old('code', $coupon->code) }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Start Date <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input id="start_date" type="date" class="form-control" name="start_date"
                            value="{{ old('start_date', $coupon->start_date) }}" min="{{ now()->toDateString() }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">End Date <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input id="end_date" type="date" class="form-control" name="end_date"
                            value="{{ old('end_date', $coupon->end_date) }}" min="{{ now()->toDateString() }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Use Type <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <select id="selectDiscountType" name="useType" class="form-control select2" width="100%" required>
                            <option value="">Please select an option</option>
                            <option value="amount" {{ $coupon->amount > 0 ? 'selected' : '' }}>Amount</option>
                            <option value="percentage" {{ $coupon->amount <= 0 ? 'selected' : '' }}>Percentage</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group row" id="amountOption" style="display:none;">
                        <label for="amount" class="col-sm-12 col-md-3 col-form-label">Amount:<sup style="color: red">*</sup></label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" id="amount" name="amount" class="form-control" value="{{ old('amount', $coupon->amount) }}">
                        </div>
                    </div>
                    <div class="form-group row" id="percentageOption" style="display:none;">
                        <label for="percentage" class="col-sm-12 col-md-3 col-form-label">Percentage:<sup style="color: red">*</sup></label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" id="percentage" name="percentage" class="form-control" value="{{ old('percentage', $coupon->percentage) }}">
                        </div>
                    </div>
                </div>


                {{-- <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Amount <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input id="amount" type="number" class="form-control" name="amount"
                            value="{{ old('amount', $coupon->amount) }}" required>
                    </div>
                </div> --}}
                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Use Times <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input id="uses_times" type="text" class="form-control only-number" name="uses_times"
                            value="{{ old('uses_times', $coupon->uses_times) }}">
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Percentage <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <input id="percentage" type="text" class="form-control only-number" name="percentage"
                            value="{{ old('percentage', $coupon->percentage) }}">
                    </div>
                </div> --}}

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Description <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <textarea id="description" name="description" class="form-control" rows="2">{{ old('description', $coupon->description) }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">Status <sup style="color: red"></sup></label>
                    <div class="col-sm-12 col-md-9">
                        <div class="material-switch pt-1">
                            <input type="checkbox" name="status" id="status" value="1"
                                {{ $coupon->status ? 'checked' : '' }} />
                            <label for="status" class="badge-primary"></label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label"></label>
                    <div class="col-sm-12 col-md-9">
                        <div class="btn-group" style="float: right; margin-top: 10px">
                            <button class="btn btn-sm btn-theme">
                                <i class="far fa-check-circle"></i>
                                SUBMIT
                            </button>
                            <a class="btn btn-sm btn-yellow ml-1" href="{{ route('em.coupon.index') }}">
                                <i class="far fa-long-arrow-left"></i>
                                BACK TO LIST
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection





@section('js')
<script>
    $(document).ready(function() {
        $('#selectDiscountType').change(function() {
            var selectedOption = $(this).val();

            if (selectedOption === 'amount') {
                $('#amountOption').show();
                $('#percentageOption').hide();
                $('#amount').val('{{ $coupon->amount }}'); // Auto fill amount value
            } else if (selectedOption === 'percentage') {
                $('#amountOption').hide();
                $('#percentageOption').show();
            } else {
                $('#amountOption').hide();
                $('#percentageOption').hide();
            }
        });
    $('#selectDiscountType').trigger('change');
    });
</script>


@endsection
