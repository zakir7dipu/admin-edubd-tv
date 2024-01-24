<script src="{{ asset('assets/custom_js/fetchStatesAndCities.js') }}"></script>



<script>
    var instructorStateId = null;
    var instructorCityId = null;
</script>





@isset($instructor)
    <script>
        instructorStateId = `{{ optional($instructor)->state_id != '' ? optional($instructor)->state_id : null }}`;
        instructorCityId = `{{ optional($instructor)->city_id != '' ? optional($instructor)->city_id : null }}`;
    </script>
@endisset





<script>
    const passwordToggle = (obj) => {

        let type = $(obj).data('type');

        if (type == 'show') {
            $(obj).data('type', 'hide');
            $('#password').attr('type', 'text');
            $('#icon').html(`<i class="far fa-eye-slash"></i>`)
        } else {
            $(obj).data('type', 'show');
            $('#password').attr('type', 'password');
            $('#icon').html(`<i class="far fa-eye"></i>`)
        }
    }





    $(document).ready(function () {
        let country_id = $('#country_id').find('option:selected').val() != '' ? $('#country_id').find('option:selected').val() : `{{ old('country_id') }}`;
        let state_id = $('#state_id').find('option:selected').val() != '' ? $('#state_id').find('option:selected').val() : (instructorStateId ? instructorStateId : `{{ old('state_id') }}`);
        let city_id = $('#city_id').find('option:selected').val() != '' ? $('#city_id').find('option:selected').val() : (instructorCityId ? instructorCityId : `{{ old('city_id') }}`);

        if (country_id != '' || state_id != '') {
            fetchStates(country_id, state_id);
        }

        if (country_id != '' || state_id != '' || city_id != '') {
            fetchCities(country_id, state_id, city_id);
        }
    })





    const removeSkill = (obj) => {
        $(obj).closest('.skill').remove();
    }





    const addSkill = () => {
        let skill   =   `<div class="col-sm-12 col-md-4 col-lg-2 mb-1 skill">
                            <input type="text" class="form-control" name="skills[]" style="position: relative" autocomplete="off" required>
                            <i class="far fa-times-circle" onclick="removeSkill(this)" style="position: absolute; top: 5px; right: 17px; color: rgb(176, 0, 0); cursor: pointer"></i>
                        </div>`;

        $('#instructorSkills').append(skill);
    }





    const removeEducation = (obj) => {
        $(obj).closest('.education').remove();
    }




    
    const addEducation = () => {
        const education =   `<div class="row education mb-1">
                                <div class="col-sm-12 col-md-9">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="input-group">
                                                <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Title <span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="title[]" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="input-group">
                                                <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Institute <span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="institute[]" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-10">
                                            <div class="input-group">
                                                <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Session <span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="session[]" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <i class="far fa-times-circle" onclick="removeEducation(this)" style="font-size: 20px; color: red; padding-top: 7px; cursor: pointer"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>`;

        $('#instructorEducations').append(education);
    }
</script>