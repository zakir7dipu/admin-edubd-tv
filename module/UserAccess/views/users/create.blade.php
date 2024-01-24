@extends('layouts.master')

@section('title','Add New User')


@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
@stop


@section('content')

    <div class="row">

        <div class="col-sm-12">
            <div class="widget-box">

                <div class="widget-header">
                    <h4 class="widget-title"> 
                        <i class="fa fa-plus-circle"></i> Add New User
                    </h4>

                    <span class="widget-toolbar">
                        <a href="{{ route('users.index') }}">
                            <i class="ace-icon fa fa-list-alt"></i> User List
                        </a>
                    </span>
                </div>



                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <div style="margin: 20px;">
                            @include('partials._alert_message')
                        </div>

                        <form class="form-horizontal" id="userForm" action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    
                                    




                                @include('includes.input-label.input-field', ['name' => 'username', 'title' => "User Name", 'is_required' => 1])


                                @include('includes.input-label.input-field', ['name' => 'name', 'title' => "Name", 'is_required' => 1])


                                @include('includes.input-label.input-field', ['name' => 'phone', 'title' => "Mobile", 'is_required' => 1])

                                

                                {{-- @include('includes.input-label.chosen-select', ['name' => 'company_id', 'title' => "Company", 'required' => 1, 'items' => $companies]) --}}


                                @include('includes.input-label.input-field', ['name' => 'email', 'title' => "Email", 'is_required' => 1, 'type' => 'email'])
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right">Position</label>
                                
                                    <div class="col-sm-8">
                                        <select class="chosen-select form-control" name="position_id">
                                            <option value=""> select </option>
                                            @foreach ($positions as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right">Role</label>
                                
                                    <div class="col-sm-8">
                                        <select class="chosen-select form-control" name="role_id">
                                            <option value=""> select </option>
                                            @foreach ($roles as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @include('includes.input-label.input-field', ['name' => 'password', 'title' => "Password", 'is_required' => 1, 'type' => 'password'])


                                @include('includes.input-label.input-field', ['name' => 'confirm_password', 'title' => "Confirm Password", 'is_required' => 1, 'type' => 'password'])



                            <div class="center mb-3" style="text-align: right !important;">
                                <div class="btn-group">
                                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-backward"></i> Back List
                                    </a>
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="ace-icon fa fa-save icon-on-right bigger-110"></i>
                                        Save
                                    </button>
                                </div>
                                
                            </div>
                        </form>

                    </div>
                </div>
            </div>


        </div>
    </div>




@endsection

@section('js')
    <script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/custom_js/chosen-box.js') }}"></script>


    <script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/ace-elements.min.js') }}"></script>
    <script src="{{ asset('assets/js/ace.min.js') }}"></script>




    <!--Drag and drop-->
    <script type="text/javascript">
        jQuery(function($) {
            $('#id-input-file-3').ace_file_input({
                style: 'well',
                btn_choose: 'Drop files here or click to choose',
                btn_change: null,
                no_icon: 'ace-icon fa fa-cloud-upload',
                droppable: true,
                thumbnail: 'small'//large | fit
            }).on('change', function(){
                //console.log($(this).data('ace_input_files'));
                //console.log($(this).data('ace_input_method'));
            });
            // Start header, footer
            $('#header').ace_file_input({
                style: 'well',
                btn_choose: 'Drop files here or click to choose',
                btn_change: null,
                no_icon: 'ace-icon fa fa-cloud-upload',
                droppable: true,
                thumbnail: 'small'//large | fit
            });
            $('#footer').ace_file_input({
                style: 'well',
                btn_choose: 'Drop files here or click to choose',
                btn_change: null,
                no_icon: 'ace-icon fa fa-cloud-upload',
                droppable: true,
                thumbnail: 'small'//large | fit
            });
            // End header, footer
        });
    </script>
    {{--    select Box Search--}}
    <script type="text/javascript">
        jQuery(function($){
            if(!ace.vars['touch']) {
                $('.chosen-select').chosen({allow_single_deselect:true});
                //resize the chosen on window resize
                $(window)
                    .off('resize.chosen')
                    .on('resize.chosen', function() {
                        $('.chosen-select').each(function() {
                            var $this = $(this);
                            $this.next().css({'width': $this.parent().width()});
                        })
                    }).trigger('resize.chosen');
                //resize chosen on sidebar collapse/expand
                $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
                    if(event_name != 'sidebar_collapsed') return;
                    $('.chosen-select').each(function() {
                        var $this = $(this);
                        $this.next().css({'width': $this.parent().width()});
                    })
                });
                $('#chosen-multiple-style .btn').on('click', function(e){
                    var target = $(this).find('input[type=radio]');
                    var which = parseInt(target.val());
                    if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
                    else $('#form-field-select-4').removeClass('tag-input-style');
                });
            }
        })
    </script>


    <script type="text/javascript">
        $(document).ready(function () {
            var i = 0;
            $("#addrow").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";
                cols += '<td><input type="text" class="form-control input-sm" name="account_name[]' + i + '"/></td>';
                cols += '<td><input type="number" class="form-control input-sm" name="account_number[]' + i + '"/></td>';
                cols += '<td><input type="text" class="form-control input-sm" name="bank_name[]' + i + '"/></td>';
                cols += '<td><input type="text" class="form-control input-sm" name="branch[]' + i + '"/></td>';
                cols += '<td><input type="text" class="form-control input-sm" name="swift_code[]' + i + '"/></td>';
                cols += '<td><button type="button" class="ibtnDel btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>';
                newRow.append(cols);
                $("table.order-list").append(newRow);
                i++;
            });
            $("table.order-list").on("click", ".ibtnDel", function (event) {
                $(this).closest("tr").remove();
                i -= 1
            });
        });
    </script>



@stop