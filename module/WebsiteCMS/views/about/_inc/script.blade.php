<script>
    const removeCount = (obj) => {
        $(obj).closest('.aboutcount').remove();
        showOrHide();
    }





    const addCount = () => {
        const countdown =  `<div class="row aboutcount mb-1">
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <div class="input-group">
                                                <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Title <span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="count_title[]"  autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-5">
                                            <div class="input-group">
                                                <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Count <span style="color: red">*</span></label>
                                                <input type="text" class="form-control only-number" name="count[]" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <i class="far fa-times-circle" onclick="removeCount(this)" style="font-size: 20px; color: red; padding-top: 7px; cursor: pointer"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>`;


              $('#aboutCounting').append(countdown);

              showOrHide();

    }

    function showOrHide(){
        let total = countAboutSection();

        if(total >= 4){
            $('.add-count').hide();

        }else{
            $('.add-count').show();
        }
    }


    function countAboutSection(){

        let count = 0;

        $('.aboutcount').each(function(){
            count++;

        });

        return count;
    }


    $(document).ready(function () {
        showOrHide()
    })


</script>
