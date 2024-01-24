
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js" integrity="sha512-6rE6Bx6fCBpRXG/FWpQmvguMWDLWMQjPycXMr35Zx/HRD9nwySZswkkLksgyQcvrpYMx0FELLJVBvWFtubZhDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.0.3/tinymce.min.js" integrity="sha512-DB4Mu+YChAdaLiuKCybPULuNSoFBZ2flD9vURt7PgU/7pUDnwgZEO+M89GjBLvK9v/NaixpswQtQRPSMRQwYIA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('assets/js/jquery-2.1.4.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/jquery.query-object.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/ace-extra.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/sweetalert2.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.bootstrap.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/custom_js/key-event.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/custom_js/custom-datatable.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/custom_js/confirm_delete_dialog.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/jquery.ba-throttle-debounce.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/bootstrap-timepicker.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/daterangepicker.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/bootstrap-colorpicker.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/export-excel-file.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/export-pdf-file.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/ace-elements.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/ace.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/jquery.inputmask.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/fontawesome-iconpicker.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/menu-auto-activation.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/js/wizard.min.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/custom_js/message-display.js') }}?time={{ time() }}"></script>
<script src="{{ asset('assets/custom_js/update-status.js') }}?time={{ time() }}"></script>

@include('layouts.toastr')

<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('assets/js/jquery.mobile.custom.min.js') }}'>"+"<"+"/script>");

    $('[data-rel=popover]').popover({html:true, container:'body'});
    $('.success').fadeIn('slow').delay(10000).fadeOut('slow');
    $('#color-picker-component').colorpicker();
    $('.colorpicker-element').colorpicker();
    $('#hover-color-picker-component').colorpicker();
    $('[data-toggle="popover"]').popover()
    $('.fontawesome').iconpicker();
    $('.choose-icon-title').text('Choose Icon');
    $('.date-picker').datepicker({
        autoclose: true,
        format:'yyyy-mm-dd',
        viewMode: "days",
        minViewMode: "days",
        todayHighlight: true
    });




    
    const tinyEditor = () => {
        return tinymce.init({
            selector: 'textarea.tiny-editor',

            plugins: [
                'a11ychecker', 'advlist', 'advcode', 'advtable', 'print', 'hr', 'autolink', 'pagebreak', 'checklist', 'export',
                'lists', 'link', 'charmap', 'image', 'preview', 'anchor', 'searchreplace', 'visualblocks',
                'powerpaste', 'fullscreen', 'formatpainter', 'image code', 'insertdatetime', 'nonbreaking', 'table', 'help',
                'wordcount'
            ],

            toolbar: 'undo redo | styleselect | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist checklist outdent indent | print preview fullscreen | ' +
                'forecolor backcolor emoticons | removeformat | help',
            menu: {
                favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons'}
            },

            images_upload_url: 'postAcceptor.php',

            menubar: 'favs file edit view insert format tools table help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    };





    // tinymce.init({
    //     selector: 'textarea.tiny-editor-with-media',
    //     plugins: [
    //         'a11ychecker', 'advlist', 'advcode', 'advtable', 'print', 'hr', 'autolink', 'pagebreak', 'checklist', 'export',
    //         'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
    //         'powerpaste', 'fullscreen', 'formatpainter', 'image code', 'insertdatetime', 'media', 'code', 'nonbreaking', 'table', 'help',
    //         'wordcount'
    //     ],

    //     toolbar: 'undo redo | styleselect | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | ' +
    //         'bullist numlist checklist outdent indent | print preview fullscreen | ' +
    //         'forecolor backcolor emoticons | removeformat | help',
    //     menu: {
    //         favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons'}
    //     },

    //     images_upload_url: 'postAcceptor.php',

    //     menubar: 'favs file edit view insert format tools table help',
    //     content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    // });



    

    const tooltip = () => {
        return  $('[data-toggle="tooltip"]').tooltip();
    }





    const select2 = () => {
       return $('.select2').select2();
    }
    select2();





    const showAlertMessage = (message, time = 1000, type = 'error') => {
        swal.fire({
            title: type.toUpperCase(),
            html: "<b>" + message + "</b>",
            type: type,
            timer: time
        });
    }





    const onlyNumber = (event) => {
        let keyCode = event.charCode
        let str = event.target.value
        let n = str.includes(".")

        if (keyCode === 13) {
            event.preventDefault();
        }

        if (keyCode === 46 && n) {
            return false
        }

        if (str.length > 12) {
            showAlertMessage('Number length out of range', 3000)
            return false
        }

        return (keyCode >= 48 && keyCode <= 57) || keyCode === 13 || keyCode === 46
    }





    $('.only-number').keypress(function() {
        return onlyNumber(event)
    });
    




    const delete_check = (id) => {
        Swal.fire({
            title: 'Are you sure ?',
            html: "<b>You want to delete permanently !</b>",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            width:400,
        }).then((result) =>{
            if(result.value){
                $('#deleteCheck_'+id).submit();
            }
        })
    }





    const generateGoogleDriveUrl = (id) => {
        return 'https://drive.google.com/uc?id=' + id + '&export=media';
    }
    




    $("#name").on('keyup', function(){
        let name = $(this).val();
        name = name.toLowerCase();
        let regExp = /([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g;
        name = name.replace(regExp,'-');
        $("#slug").val(name);
    });





    $('.file').ace_file_input({
        no_file:'No File ...',
        btn_choose:'Choose',
        btn_change:'Change',
        droppable:false,
        onchange:null,
        thumbnail:false
    });





    window.FontAwesomeConfig = {
        searchPseudoElements: true
    }
    




    $(document).ready(function() {
        tooltip();
        tinyEditor();
    });


    


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>


@yield('js')
@yield('script')