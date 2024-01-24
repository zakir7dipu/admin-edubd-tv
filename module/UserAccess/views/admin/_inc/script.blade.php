<script src="{{ asset('assets/custom_js/fetchStatesAndCities.js') }}"></script>



<script>
    var adminStateId = null;
    var adminCityId = null;
</script>





@isset($admin)
    <script>
        adminStateId = `{{ optional($admin)->state_id != '' ? optional($admin)->state_id : null }}`;
        adminCityId = `{{ optional($admin)->city_id != '' ? optional($admin)->city_id : null }}`;
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


</script>
