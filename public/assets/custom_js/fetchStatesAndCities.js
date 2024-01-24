const fetchStates = async (country_id = null, state_id = null) => {
    try {
        if (country_id === null) {
            country_id = $('#country_id').find('option:selected').val();
        }

        $('#state_id').html(`<option value=''>Fetching...</option>`).select2();

        const { data } = await axios.get('/fetch-states', {
            params: {
                country_id
            }
        });
        
        const { status, states } = data || {};

        if (status === 1 && states?.length === 0) {
            $('#state_id').data('placeholder', '- No States Found! -');
        } else if (status === 1 && states?.length > 0) {

            $('#state_id').empty().select2();
            
            if (states?.length > 1) {
                $('#state_id').append(`<option value=''></option>`);
            }

            $('#state_id').append(
                states.map(state => {
                    return `<option value='${state.id}' ${ state_id != '' && state_id == state.id ? 'selected' : '' }>${state.name}</option>`;
                })
            ).select2();
        }

    } catch (error) {
        console.error(error);
    }
}





const fetchCities = async (country_id = null, state_id = null, city_id = null) => {
    try {
        if (country_id === null) {
            country_id = $('#country_id').find('option:selected').val();
        }

        if (state_id === null) {
            state_id = $('#state_id').find('option:selected').val();
        }
        
        $('#city_id').html(`<option value=''>Fetching...</option>`).select2();

        const { data } = await axios.get('/fetch-cities', {
            params: {
                country_id,
                state_id
            }
        });
        
        const { status, cities } = data || {};

        if (status === 1 && cities?.length === 0) {
            $('#city_id').data('placeholder', '- No Cities Found! -');
        } else if (status === 1 && cities?.length > 0) {
            $('#city_id').empty().select2();
            
            if (cities?.length > 1) {
                $('#city_id').append(`<option value=''></option>`);
            }

            $('#city_id').append(
                cities.map(city => {
                    return `<option value='${city.id}' ${ city_id != '' && city_id == city.id ? 'selected' : '' }>${city.name}</option>`;
                })
            ).select2();
        }

    } catch (error) {
        console.error(error);
    }
}





const fetchStatesAndCities = () => {
    fetchStates();
    fetchCities();
}