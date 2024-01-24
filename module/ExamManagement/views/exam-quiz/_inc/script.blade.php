<script>
    const removeOption = (obj) => {
        $(obj).closest('.option').remove();
        countOption();
    }

    



    const countOption = () => {
        let count = 0;

        $('.option').each(function() {
            count++;
        });

        if (count == 4) {
            $('.add-option').hide();
        } else {
            $('.add-option').show();
        }

        return count;
    }





    const isOptionStatusToggle = (obj) => {
        let THIS = $(obj).closest('div');
        let OBJ = $(obj);

        if (OBJ.is(":checked")) {
            THIS.find('.is-option_status-default-value').prop('disabled', true);
        } else if (OBJ.is(":not(:checked)")) {
            THIS.find('.is-option_status-default-value').prop('disabled', false);
        }
    }





    const currectOptionToggle = (obj) => {
        let THIS = $(obj).closest('div');
        THIS.find('.is-currect-option-default-value').prop('disabled', $(obj).is(":checked"));
    }



    

    const addOption = () => {

        let nextNo = countOption() + 1;

        const option = `<div class="row option">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <label 
                                        class="input-group-addon" 
                                        style="background: #dfdfdf; color: #000000"
                                    >
                                        Option ${nextNo} <span style="color: red">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="option_name[]" 
                                        autocomplete="off" 
                                        required
                                    >
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="display: flex; justify-content: space-between;">
                                    <label class="col-form-label">Correct</label>
                                    <div class="material-switch pt-1">
                                        <input 
                                            type="hidden" 
                                            class="is-currect-option-default-value" 
                                            name="option_is_true[]" 
                                            value="0" 
                                        />
                                        <input 
                                            type="checkbox" 
                                            class="is-correct-option-checked-value" 
                                            onchange="currectOptionToggle(this)" 
                                            name="option_is_true[]" 
                                            id="isCurrectOption${nextNo}" 
                                            value="1" 
                                        />
                                        <label for="isCurrectOption${nextNo}" class="badge-primary"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <i class="far fa-times-circle" onclick="removeOption(this)" style="font-size: 20px; color: red; padding-top: 7px; cursor: pointer"></i>
                            </div>
                        </div>`;

        $('#quizOption').append(option);

        countOption()
    }





    const fetchExams = async (obj) => {

        let examCategoryId = $(obj).find('option:selected').val();
        let oldExamCategoryId = `{{ old('exam_category_id') }}` != undefined ? `{{ old('exam_category_id') }}` : null;
        
        let requestExamId = `{{ request('exam_id') }}` != undefined ? `{{ request('exam_id') }}` : null;
        let oldExamId = `{{ old('exam_id') }}` != undefined ? `{{ old('exam_id') }}` : null;
        let examId = $('#examId').val() != undefined ? $('#examId').val() : null;

        let selectedExamId = requestExamId ? requestExamId : (oldExamId ? oldExamId : examId);
        
        if (oldExamCategoryId) {
            examCategoryId = oldExamCategoryId;
        }
       
        if (examCategoryId) {
            try {

                let route = `{{ route('fetch-exams', ':id') }}`;
                route = route.replace(':id', examCategoryId);

                const { data: exams } = await axios.get(route);

                if (exams?.length > 0) {
                    $('#exams').html(`<option></option>`);
                    $('#chapters').html(`<option></option>`);

                    exams.map(function (exam) {
                        const { id, title } = exam || {};
                        $('#exams').append(`<option value="${id}" ${ selectedExamId == id ? 'selected' : '' }>${title}</option>`);
                    });
                } else {
                    $('#exams').html(`<option>No Items Found</option>`);
                    $('#chapters').html(`<option>No Items Found</option>`);
                }

                select2();

            } catch (error) {
                console.error(error);
            }
        }
    }





    const fetchChapters = async (obj) => {

        let examId = $(obj).find('option:selected').val();
        let oldExamId = `{{ old('exam_id') }}` != undefined ? `{{ old('exam_id') }}` : null;

        let requestChapterId = `{{ request('chapter_id') }}` != undefined ? `{{ request('chapter_id') }}` : null;
        let oldChapterId = `{{ old('chapter_id') }}` != undefined ? `{{ old('chapter_id') }}` : null;
        let chapterId = $('#chapterId').val() != undefined ? $('#chapterId').val() : null;

        let selectedChapterId = requestChapterId ? requestChapterId : (oldChapterId ? oldChapterId : chapterId);
        
        if (oldExamId) {
            examId = oldExamId;
        }

        if (examId) {
            try {

                let route = `{{ route('fetch-chapters', ':id') }}`;
                route = route.replace(':id', examId);

                const { data: chapters } = await axios.get(route);

                if (chapters?.length > 0) {
                    $('#chapters').html(`<option></option>`);

                    chapters.map(function (chapter) {
                        const { id, name } = chapter || {};
                        $('#chapters').append(`<option value="${id}" ${ selectedChapterId == id ? 'selected' : '' }>${name}</option>`);
                    });
                } else {
                    $('#chapters').html(`<option>No Items Found</option>`);
                }

                select2();

            } catch (error) {
                console.error(error);
            }
        }
    }





    $(document).ready(function () {
        fetchExams($('#examCategories'));
        setTimeout(() => {
            fetchChapters($('#exams'));
        }, 1000);
    });
</script>