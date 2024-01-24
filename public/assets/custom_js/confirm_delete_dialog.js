const delete_item = (url, message = null) => {
        Swal.fire({
        title: 'Are you sure?',
        html: `${message != null ? '<b style="font-size: 16px">'+ message +'</b>' : '<b>You will delete this record permanently !</b>'}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $('#deleteItemForm').attr('action', url).submit();
        }
    })
}
