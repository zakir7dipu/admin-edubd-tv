const updateStatus = (obj, id) => {
    const status = $(obj).children("i").attr("status");
    const route = $(obj).attr("route");

    axios.post(route, {
        id,
        status,
    })
    .then(function ({data}) {
        if (data == 0) {
            $(obj).html(`<i class="fa fa-toggle-off text-danger" style="font-size: 20px" status="0"></i>`);

            swal.fire({
                icon: 'success',
                title: "Status Inactive Successfully",
                type: "success",
                timer: 1500
            });
        } else if (data == 1) {
            $(obj).html(`<i class="fa fa-toggle-on text-success" style="font-size: 20px" status="1"></i>`);

            swal.fire({
                icon: 'success',
                title: "Status Active Successfully",
                type: "success",
                timer: 1500
            });
        }
    })
    .catch(function (error) {
        console.log(error);
    });
}
