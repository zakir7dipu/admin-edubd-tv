<script>
    const removeChapter = (obj) => {
        $(obj).closest('.chapter').remove();
    }


    const chapterCount = () => {
        // let count = 1;
        let count = 0;

        $('.chapter').each(function() {
            count++;
        })

        return count;
    }

    const dataMask = () => {
        return Inputmask("99:99:99", {greedy: false}).mask('#duration-input');
    }





    const isPublishedToggle = (obj) => {
        let THIS = $(obj).closest('div');
        THIS.find('.is-published-default-value').prop('disabled', $(obj).is(":checked"));
    }


    const addChapter = () => {
        let nextNo = chapterCount() + 1;
        const chapter = `<div class="row chapter mb-1">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Name:
                                            <span style="color: red">*</span>
                                        </label>
                                        <input type="text" onkeyup="generateSlug(this)" class="form-control chapter-name" name="chapterName[]" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="input-group">
                                        <label class="input-group-addon" style="background: #dfdfdf; color: #000000"> Slug
                                            <span style="color: red">*</span>
                                        </label>
                                        <input type="text" class="form-control chapter-slug" name="chapterSlug[]" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                        <div class="input-group">
                                            <label class="input-group-addon" style="background: #dfdfdf; color: #000000"> Duration
                                                <span style="color: red">*</span>
                                            </label>
                                            <input type="text" id="duration-input" placeholder="HH:MM:SS" class="form-control" name="duration[]" autocomplete="off" required>
                                        </div>
                                    </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="display: flex; justify-content:space-between;">
                                        <label class="col-form-label">Is Published <sup style="color: red"></sup></label>
                                        <div class="material-switch pt-1">
                                                <input type="hidden" class="is-published-default-value" name="is_published[]" value="0" />
                                                <input type="checkbox" class="is-published-checkbox" onchange="isPublishedToggle(this)" name="is_published[]" id="is_published${nextNo}" value="1" />
                                                <label for="is_published${nextNo}" class="badge-primary"></label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <i class="far fa-times-circle" onclick="removeChapter(this)" style="font-size: 20px; color: red; padding-top: 7px; cursor: pointer"></i>
                                </div>

                        </div>`;

        $('#examChapter').append(chapter);
        chapterCount();
        dataMask();
    }





    $('.is_published').each(function(i) {
        $key = {},

        console.log("Item in index " + i + " has value " + $(v).val())
    })





    const generateSlug = (obj) => {
        let name = $(obj).val();
        name = name.toLowerCase();
        let regExp = /([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g;
        name = name.replace(regExp,'-');
        $(obj).closest('.chapter').find('.chapter-slug').val(name);
    }
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('#duration-input').inputmask("99:99:99", {greedy: false});
    });
    </script>
