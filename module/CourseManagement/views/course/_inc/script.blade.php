<script>
    const removeIntroduction = (obj) => {
        $(obj).closest('.introduction').remove();
    }





    const calculateCourseFee = (field) => {
        let regularFee = Number($('#regularFee').val());
        let discountAmount = Number($('#discountAmount').val());

        if (discountAmount > regularFee) {
            discountAmount = regularFee;

            if (field === 'discount') {
                warning('toastr', 'You can\'t add discount more than regular fee!')
            }

            $('#discountAmount').val(discountAmount.toFixed(2));
        }

        let courseFee = regularFee - discountAmount;

        $('#courseFee').val(courseFee.toFixed(2));
    }





    const addIntroduction = () => {
        let introduction =  `<div class="introduction">
                                <span class="introduction-label">Icon</span>
                                <input type="text" name="introduction_icon[]" class="form-control" style="width: 30%" autocomplete="off">
                                <span class="introduction-label">Text</span>
                                <input type="text" name="introduction_text[]" class="form-control" autocomplete="off">
                                <button
                                    onclick="removeIntroduction(this)"
                                    class="remove-btn"
                                >
                                    <i class="far fa-times-circle"></i>
                                </button>
                            </div>`;

        $('#introductions').append(introduction);
    }





    const checkInstructorExistOrNot = (obj) => {
        let thisId      = $(obj).find('option:selected').val();
        let currentId   = $(obj).data('current-id');
        let existCount  = 0;

        $('.course-instructor-id').each(function () {
            let eachId  = $(this).find('option:selected').val();

            if (eachId !== '' && thisId === $(this).find('option:selected').val()) {
                existCount += 1;
            } else if (thisId === eachId) {
                existCount += 1;
            }
        })

        if (existCount > 1) {
            warning('toastr', 'Instructor already exist!');

            if (currentId === '') {
                $(obj).data('placeholder', '- Select -');
                $(obj).append(`<option value=''></option>`).select2();
            }
            $(obj).find("option[value='" + currentId + "']").prop('selected', true);
        } else {
            $(obj).data('current-id', thisId);
        }

        return existCount;
    }





    const setInstructorInfos = (obj, forDocumentReady = false) => {

        let existCount      = checkInstructorExistOrNot(obj);

        let THIS            = $(obj).closest('.instructor');
        let OBJ             = $(obj).find('option:selected');

        if (forDocumentReady || existCount === 1) {
            let firstName       = OBJ.data('first-name');
            let lastName        = OBJ.data('last-name');
            let username        = OBJ.data('username');
            let email           = OBJ.data('email');
            let phone           = OBJ.data('phone');
            let image           = OBJ.data('image');
            let defaultImage    = `{{ asset('assets/img/default.png') }}`;

            if (image != '') {
                THIS.find('.instructor-image').attr('src', image);
            } else {
                THIS.find('.instructor-image').attr('src', defaultImage);
            }

            let dataContent     =`<div style="color: black !important; line-height: 13px; display: flex; align-items: center; gap: 5px; font-size: 12px">
                                    <div>
                                        <p>First Name</p>
                                        <p>Last Name</p>
                                        <p>Username</p>
                                        <p>Email</p>
                                        <p class="mb-0">Phone</p>
                                    </div>
                                    <div>
                                        <p>: ${firstName}</p>
                                        <p>: ${lastName}</p>
                                        <p>: ${username}</p>
                                        <p>: ${email}</p>
                                        <p class="mb-0">: ${phone}</p>
                                    </div>
                                </div>`;

            THIS.find('.instructor-infos').show();
            THIS.find('.instructor-infos').attr('data-content', dataContent);
        }

        select2();
        $('.instructor-infos').popover({html:true, container:'body'});
    }





    const removeInstructor = (obj) => {
        $(obj).closest('.instructor').remove();
    }





    const addInstructor = () => {
        let instructor  =   `<div class="instructor">
                                <img src="{{ asset('assets/img/default.png') }}" class="instructor-image img-thumbnail img-circle" width="80px" height="80px" alt="">
                                <select name="course_instructor_id[]" data-current-id="" class="form-control select2 course-instructor-id" onchange="setInstructorInfos(this)" data-placeholder="- Select -" style="width: 100%" required>
                                    <option></option>
                                    @isset($instructors)
                                        @foreach ($instructors as $instructor)
                                            <option
                                                value="{{ $instructor->id }}"
                                                data-first-name="{{ $instructor->first_name }}"
                                                data-last-name="{{ $instructor->last_name }}"
                                                data-username="{{ $instructor->username }}"
                                                data-email="{{ $instructor->email }}"
                                                data-phone="{{ $instructor->phone }}"
                                                data-image="{{ $instructor->image != '' && file_exists($instructor->image) ? asset($instructor->image) : '' }}"
                                            >
                                                {{ $instructor->first_name }} {{ $instructor->last_name }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                <button
                                    onclick="removeInstructor(this)"
                                    class="remove-btn"
                                >
                                    <i class="far fa-times-circle"></i>
                                </button>
                                <span class="popover-success instructor-infos"
                                    data-rel="popover"
                                    data-placement="bottom"
                                    data-trigger="hover"
                                    data-original-title="<div style='color: blue; font-weight: 600'>Instructor Information</div>"
                                    data-content=""
                                    style="display: none; margin-top: 5px"
                                >
                                    <i class="far fa-info-circle ml-2" style="cursor: help; font-size: 20px; color: black"></i>
                                </span>
                            </div>`;

        $('#instructors').append(instructor);

        select2();
        $('.instructor-infos').popover({html:true, container:'body'});
    }





    const removeOutcome = (obj) => {
        $(obj).closest('.outcome').remove();
    }





    const addOutcome = () => {
        let outcome =   `<div class="outcome">
                            <span class="outcome-label">Outcome</span>
                            <textarea class="form-control" name="outcome_text[]" class="form-control"></textarea>
                            <i onclick="removeOutcome(this)" class="far fa-times-circle remove-icon"></i>
                        </div>`;

        $('#outcomes').append(outcome);
    }





    const removeFAQ = (obj) => {
        $(obj).closest('.faq').remove();
    }





    const addFAQ = () => {
        let faq =   `<div class="faq">
                        <input type="text" name="faq_title[]" class="form-control" placeholder="Title">
                        <textarea type="text" name="faq_description[]" class="form-control" placeholder="Description" rows="5"></textarea>
                        <i onclick="removeFAQ(this)" class="far fa-times-circle remove-icon"></i>
                    </div>`;

        $('#faqs').append(faq);
    }





    const removeTopic = (obj) => {
        $(obj).closest('.topic').remove();
    }





    const topicIsPublishToggle = (obj) => {
        let THIS = $(obj).closest('.topic');
        let OBJ = $(obj);

        if (OBJ.is(":checked")) {
            THIS.find('.topic-not-published').prop('disabled', true);
            THIS.find('.topic-not-auto-published').prop('disabled', false);
            THIS.find('.topic-is-auto-published').prop('checked', false);
            THIS.find('.topic-publish-at-input-group').hide();
            THIS.find('.topic-published-at').val('');
        } else if (OBJ.is(":not(:checked)")) {
            THIS.find('.topic-not-published').prop('disabled', false);
            THIS.find('.topic-not-auto-published').prop('disabled', false);
            THIS.find('.topic-is-auto-published').prop('checked', false);
            THIS.find('.topic-publish-at-input-group').hide();
            THIS.find('.topic-published-at').val('');


            if (THIS.find('.topic-is-auto-published').is(":not(:checked)")) {
                THIS.find('.topic-published-at').prop('required', false);
            }
        }
    }





    const topicIsAutoPublishToggle = (obj) => {
        let THIS = $(obj).closest('.topic');
        let OBJ = $(obj);

        if (OBJ.is(":checked")) {
            THIS.find('.topic-not-published').prop('disabled', false);
            THIS.find('.topic-is-published').prop('checked', false);
            THIS.find('.topic-not-auto-published').prop('disabled', true);
            THIS.find('.topic-publish-at-input-group').show();
            THIS.find('.topic-published-at').prop('required', true);
        } else if (OBJ.is(":not(:checked)")) {
            THIS.find('.topic-not-published').prop('disabled', true);
            THIS.find('.topic-is-published').prop('checked', true);
            THIS.find('.topic-not-auto-published').prop('disabled', false);
            THIS.find('.topic-publish-at-input-group').hide();
            THIS.find('.topic-published-at').prop('required', false);
            THIS.find('.topic-published-at').val('');
        }
    }





    const addTopic = () => {

        let key = 1;
        $('.topic').each(function () {
            key += 1;
        });

        let topic = `<div class="topic">
                        <input type="hidden" name="topic_id[]" value="">
                        <div class="input-group" style="width: 100%">
                            <span class="input-group-addon" style="width: 125px; text-align: left">Topic Title <span style="color: red !important">*</span></span>
                            <input type="text" class="form-control" name="topic_title[]" required>
                        </div>
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; width: 100%">
                            <div style="display: flex; align-items: center; justify-content: space-between">
                                <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px">
                                    <div class="material-switch">
                                        <input type="hidden" class="topic-not-published" name="topic_is_published[]" value="0" disabled />
                                        <input type="checkbox" onclick="topicIsPublishToggle(this)" class="topic-is-published" name="topic_is_published[]" id="topicIsPublished${key}" value="1" checked />
                                        <label for="topicIsPublished${key}" class="badge-primary"></label>
                                    </div>
                                    <label style="padding-top: 5px">Publish</label>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px">
                                    <div class="material-switch">
                                        <input type="hidden" class="topic-not-auto-published" name="topic_is_auto_published[]" value="0" />
                                        <input type="checkbox" onclick="topicIsAutoPublishToggle(this)" class="topic-is-auto-published" name="topic_is_auto_published[]" id="topicIsAutoPublished${key}" value="1" />
                                        <label for="topicIsAutoPublished${key}" class="badge-primary"></label>
                                    </div>
                                    <label style="padding-top: 5px">Auto Publish</label>
                                </div>
                            </div>
                            <div class="input-group topic-publish-at-input-group" style="width: 100%; display: none">
                                <span class="input-group-addon" style="width: 125px; text-align: left">Publish At <span style="color: red !important">*</span></span>
                                <input type="datetime-local" class="form-control topic-published-at" name="topic_published_at[]">
                            </div>
                        </div>
                        <i onclick="removeTopic(this)" class="far fa-times-circle remove-icon"></i>
                    </div>`;

        $('#topics').append(topic);
    }




    const setLessonTitle = (obj) => {
        let title = $(obj).val() != '' ? $(obj).val() : 'Title goes here!';
        $(obj).closest('.lesson-panel').find('.accordion-title').text(title);
    }




    const lessonIsVideoToggle = (obj) => {
        let THIS = $(obj).closest('.lesson');
        let OBJ = $(obj);

        if (OBJ.is(":checked")) {
            THIS.find('.lesson-no-video').prop('disabled', true);
            THIS.find('.lesson-video').show();
            THIS.find('.lesson-video').prop('required', true);
            THIS.find('.lesson-video-note').hide();
            THIS.find('.lesson-is-attachment').prop('checked', false);
        } else if (OBJ.is(":not(:checked)")) {
            THIS.find('.lesson-no-video').prop('disabled', false);
            THIS.find('.lesson-video').hide();
            THIS.find('.lesson-video').prop('required', false);
            THIS.find('.lesson-video-note').show();
            THIS.find('.lesson-is-attachment').prop('checked', true);
        }

        lessonIsAttachmentToggle(THIS.find('.lesson-is-attachment'));
    }




    const lessonIsAttachmentToggle = (obj) => {
        let THIS = $(obj).closest('.lesson');
        let OBJ = $(obj);

        if (OBJ.is(":checked")) {
            THIS.find('.lesson-no-attachment').prop('disabled', true);
            THIS.find('.lesson-attachment').show();
            THIS.find('.lesson-attachment').prop('required', true);
            THIS.find('.lesson-attachment-note').hide();
            THIS.find('.lesson-is-video').prop('checked', false);
        } else if (OBJ.is(":not(:checked)")) {
            THIS.find('.lesson-no-attachment').prop('disabled', false);
            THIS.find('.lesson-attachment').hide();
            THIS.find('.lesson-attachment').prop('required', false);
            THIS.find('.lesson-attachment-note').show();
            THIS.find('.lesson-is-video').prop('checked', true);
        }

        lessonIsVideoToggle(THIS.find('.lesson-is-video'));
    }





    const lessonIsPublishToggle = (obj) => {
        let THIS = $(obj).closest('.lesson');
        let OBJ = $(obj);

        if (OBJ.is(":checked")) {
            THIS.find('.lesson-not-published').prop('disabled', false);
            THIS.find('.lesson-is-auto-published').prop('checked', false);
        } else if (OBJ.is(":not(:checked)")) {
            THIS.find('.lesson-not-published').prop('disabled', true);
            THIS.find('.lesson-is-auto-published').prop('checked', true);
        }

        lessonIsAutoPublishToggle(THIS.find('.lesson-is-auto-published'))
    }





    const lessonIsAutoPublishToggle = (obj) => {
        let THIS = $(obj).closest('.lesson');
        let OBJ = $(obj);

        if (OBJ.is(":checked")) {
            THIS.find('.lesson-is-published').prop('checked', false);
            THIS.find('.lesson-not-published').prop('disabled', false);
            THIS.find('.lesson-not-auto-published').prop('disabled', true);
            THIS.find('.lesson-auto-publish-note').hide();
            THIS.find('.lesson-published-at').show();
            THIS.find('.lesson-published-at').prop('required', true);
        } else if (OBJ.is(":not(:checked)")) {
            THIS.find('.lesson-auto-publish-note').show();

            if (THIS.find('.lesson-is-published').is(":not(:checked)")) {
                THIS.find('.lesson-not-published').prop('disabled', false);
            } else {
                THIS.find('.lesson-not-published').prop('disabled', true);
            }

            THIS.find('.lesson-not-auto-published').prop('disabled', false);
            THIS.find('.lesson-published-at').hide();
            THIS.find('.lesson-published-at').prop('required', false);
        }
    }





    const lessonIsFreeToggle = (obj) => {
        let THIS = $(obj).closest('.lesson');
        let OBJ = $(obj);

        if (OBJ.is(":checked")) {
            THIS.find('.lesson-no-free').prop('disabled', true);
        } else if (OBJ.is(":not(:checked)")) {
            THIS.find('.lesson-no-free').prop('disabled', false);
        }
    }





    const lessonIsQuizToggle = (obj) => {
        let THIS = $(obj).closest('.lesson');
        let OBJ = $(obj);

        if (OBJ.is(":checked")) {
            THIS.find('.lesson-no-quiz').prop('disabled', true);
        } else if (OBJ.is(":not(:checked)")) {
            THIS.find('.lesson-no-quiz').prop('disabled', false);
        }
    }





    const lessonIsAssignmentToggle = (obj) => {
        let THIS = $(obj).closest('.lesson');
        let OBJ = $(obj);

        if (OBJ.is(":checked")) {
            THIS.find('.lesson-no-assignment').prop('disabled', true);
            THIS.find('.lesson-assignment-description').show();
        } else if (OBJ.is(":not(:checked)")) {
            THIS.find('.lesson-no-assignment').prop('disabled', false);
            THIS.find('.lesson-assignment-description').hide();
        }
    }





    const removeLesson = (obj) => {
        $(obj).closest('.lesson-panel').remove();
    }





    const addLesson = () => {

        let key = 1;
        $('.lesson').each(function () {
            key += 1;
        });

        let lesson  =   `<div class="lesson-panel panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse${key}" aria-expanded="true">
                                        <i class="bigger-110 ace-icon fa fa-angle-down" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                        &nbsp;
                                        <span class="accordion-title">Title goes here!</span>
                                    </a>
                                </h4>
                                <i onclick="removeLesson(this)" class="far fa-times-circle remove-lesson"></i>
                            </div>
                            <div class="panel-collapse collapse in" id="collapse${key}" aria-expanded="true">
                                <div class="panel-body">
                                    <div class="lesson">
                                        <input type="hidden" name="course_lesson_id[]" value="">
                                        <div class="input-group" style="width: 100%">
                                            <span class="input-group-addon" style="width: 135px; text-align: left">Course Topic <span style="color: red !important">*</span></span>
                                            <select name="course_lesson_course_topic_id[]" class="form-control select2" data-placeholder="- Select Topic -" style="width: 100%" required>
                                                <option></option>
                                                @isset($courseTopics)
                                                    @foreach ($courseTopics as $id => $title)
                                                        <option value="{{ $id }}">{{ $title }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                        <div class="input-group" style="width: 100%">
                                            <span class="input-group-addon" style="width: 135px; text-align: left">Lesson Title <span style="color: red !important">*</span></span>
                                            <input type="text" class="form-control" onkeyup="setLessonTitle(this)" name="course_lesson_title[]" required autocomplete="off">
                                        </div>
                                        <div class="input-group" style="width: 100%; display: flex; align-items: center;">
                                            <span class="input-group-addon" style="width: 150px; text-align: left; height: 35px; line-height: 20px">Duration <span style="color: red !important">*</span></span>
                                            <input type="text" class="form-control duration" name="course_lesson_duration[]" required autocomplete="off" placeholder="HH:MM:SS">
                                            <i class="fas fa-info-circle" title="ex: HH:MM:SS ⇒ 00:10:11" data-toggle="tooltip" style="cursor: help; color: #696969; margin-left: 5px"></i>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 50px; width: 100%">
                                            <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px;">
                                                <div class="material-switch">
                                                    <input type="hidden" class="lesson-no-video" name="lesson_is_video[]" value="0" disabled />
                                                    <input type="checkbox" onclick="lessonIsVideoToggle(this)" class="lesson-is-video" name="lesson_is_video[]" id="lessonIsVideo${key}" value="1" checked />
                                                    <label for="lessonIsVideo${key}" class="badge-primary"></label>
                                                </div>
                                                <label style="padding-top: 5px">Video</label>
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 10px">
                                                <i class="fas fa-info-circle lesson-video-note" title="If you wanna add video instead of attachment please active video for enable this field." data-toggle="tooltip" style="cursor: help; color: #696969; display: none"></i>
                                            </div>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 50px; width: 100%">
                                            <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 150px;">
                                                <div class="material-switch">
                                                    <input type="hidden" class="lesson-no-attachment" name="lesson_is_attachment[]" value="0" />
                                                    <input type="checkbox" onclick="lessonIsAttachmentToggle(this)" class="lesson-is-attachment" name="lesson_is_attachment[]" id="lessonIsAttachment${key}" value="1" />
                                                    <label for="lessonIsAttachment${key}" class="badge-primary"></label>
                                                </div>
                                                <label style="padding-top: 5px">Attachment</label>
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 10px">
                                                <i class="fas fa-info-circle lesson-attachment-note" title="If you wanna add attachment instead of video please active attachment for enable this field." data-toggle="tooltip" style="cursor: help; color: #696969"></i>
                                            </div>
                                        </div>
                                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; width: 100%">
                                            <div style="display: flex; align-items: center; justify-content: space-between">
                                                <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 200px;">
                                                    <div class="material-switch">
                                                        <input type="hidden" class="lesson-not-published" name="lesson_is_published[]" value="0" disabled />
                                                        <input type="checkbox" onclick="lessonIsPublishToggle(this)" class="lesson-is-published" name="lesson_is_published[]" id="lessonIsPublished${key}" value="1" checked />
                                                        <label for="lessonIsPublished${key}" class="badge-primary"></label>
                                                    </div>
                                                    <label style="padding-top: 5px">Publish</label>
                                                </div>
                                                <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 200px">
                                                    <div class="material-switch">
                                                        <input type="hidden" class="lesson-not-auto-published" name="lesson_is_auto_published[]" value="0" />
                                                        <input type="checkbox" onclick="lessonIsAutoPublishToggle(this)" class="lesson-is-auto-published" name="lesson_is_auto_published[]" id="lessonIsAutoPublished${key}" value="1" />
                                                        <label for="lessonIsAutoPublished${key}" class="badge-primary"></label>
                                                    </div>
                                                    <label style="padding-top: 5px">Auto Publish</label>
                                                    <i class="fas fa-info-circle lesson-auto-publish-note" title="If you wanna enable auto publish it will show published at field which is required. Note: it will be disable publish field also!" data-toggle="tooltip" style="cursor: help; color: #696969"></i>
                                                </div>
                                            </div>
                                            <input type="datetime-local" class="form-control lesson-published-at" name="lesson_published_at[]" style="display: none">
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 20px; width: 100%; margin-top: 20px">
                                            <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                                <label>
                                                    <input name="lesson_is_free[]" class="lesson-no-free" value="0" type="hidden">
                                                    <input name="lesson_is_free[]" onclick="lessonIsFreeToggle(this)" value="1" type="checkbox" class="ace lesson-is-free">
                                                    <span class="lbl"> Free</span>
                                                </label>
                                            </div>
                                            <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                                <label>
                                                    <input name="lesson_is_quiz[]" class="lesson-no-quiz" value="0" type="hidden">
                                                    <input name="lesson_is_quiz[]" onclick="lessonIsQuizToggle(this)" value="1" type="checkbox" class="ace lesson-is-quiz">
                                                    <span class="lbl"> Quiz</span>
                                                </label>
                                            </div>
                                            <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                                <label>
                                                    <input name="lesson_is_assignment[]" value="0" class="lesson-no-assignment" type="hidden">
                                                    <input name="lesson_is_assignment[]" onclick="lessonIsAssignmentToggle(this)" value="1" type="checkbox" class="ace lesson-is-assignment">
                                                    <span class="lbl"> Assignment</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="lesson-assignment-description" style="width: 100%; margin-top: 20px; display: none">
                                            <textarea name="lesson_assignment_description[]" class="form-control tiny-editor" rows="10" style="width: 100%" placeholder="Assignment Description..."></textarea>
                                        </div>
                                        <div style="width: 100%; margin-top: 20px;">
                                            <textarea name="lesson_description[]" class="form-control tiny-editor" rows="10" style="width: 100%" placeholder="Lesson Description..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`

        $('.lessons').append(lesson);

        select2();
        tooltip();
        dataMask();
        tinyEditor();
    }






    const courseIsPublishToggle = (obj) => {
        let THIS = $(obj).closest('.course');
        let OBJ = $(obj);

        if (OBJ.is(":checked")) {
            THIS.find('.course-not-published').prop('disabled', false);
            THIS.find('.course-is-auto-published').prop('checked', false);
        } else if (OBJ.is(":not(:checked)")) {
            THIS.find('.course-not-published').prop('disabled', true);
            THIS.find('.course-is-auto-published').prop('checked', true);
        }

        courseIsAutoPublishToggle(THIS.find('.course-is-auto-published'))
    }





    const courseIsAutoPublishToggle = (obj) => {
        let THIS = $(obj).closest('.course');
        let OBJ = $(obj);

        if (OBJ.is(":checked")) {
            THIS.find('.course-is-published').prop('checked', false);
            THIS.find('.course-not-published').prop('disabled', false);
            THIS.find('.course-auto-publish-note').hide();
            THIS.find('.course-published-at').show();
            THIS.find('.course-published-at').prop('required', true);
        } else if (OBJ.is(":not(:checked)")) {
            THIS.find('.course-auto-publish-note').show();
            THIS.find('.course-published-at').hide();
            THIS.find('.course-published-at').prop('required', false);
        }
    }




    const courseAutoPublishToggle = (obj) => {
        let THIS = $(obj).closest('.publish');
        let OBJ = $(obj);

        if (OBJ.is(":checked")) {
            THIS.find('#coursePublishedAt').prop('required', false);
            THIS.find('#coursePublishedAt').prop('disabled', true);
            THIS.find('#coursePublishedAt').hide();
            THIS.find('#coursePublishedAtCustom').prop('disabled', false);
            THIS.find('#coursePublishedAtCustom').show();
        } else if (OBJ.is(":not(:checked)")) {
            THIS.find('#coursePublishedAt').prop('required', true);
            THIS.find('#coursePublishedAt').prop('disabled', false);
            THIS.find('#coursePublishedAt').show();
            THIS.find('#coursePublishedAtCustom').prop('disabled', true);
            THIS.find('#coursePublishedAtCustom').hide();
        }
    }





    const dataMask = () => {
        return Inputmask("99:99:99", {greedy: false}).mask('.duration');
    }





    $(document).ready(function () {
        $('.course-instructor-id').each(function () {
            setInstructorInfos($(this), true);
        })

        dataMask();
    })




    $(document).ready(function() {
        $("#color_mode").on("change", function () {
            colorModePreview(this);
        })
    });

    function colorModePreview(ele) {
        if($(ele).prop("checked") == true){
            $('body').addClass('dark-preview');
            $('body').removeClass('white-preview');
        }
        else if($(ele).prop("checked") == false){
            $('body').addClass('white-preview');
            $('body').removeClass('dark-preview');
        }
    }





    var $validation = false;
    $('#fuelux-wizard-container')
    .ace_wizard({})
    .on('actionclicked.fu.wizard' , function(e, info){
        if(info.step == 1 && $validation) {
            if(!$('#validation-form').valid()) e.preventDefault();
        }
    })
    .on('finished.fu.wizard', function(e) {
        bootbox.dialog({
            message: "Thank you! Your information was successfully saved!",
            buttons: {
                "success" : {
                    "label" : "OK",
                    "className" : "btn-sm btn-primary"
                }
            }
        });
    })
    .on('stepclick.fu.wizard', function(e) {});

      

    const toggleVideoUpload = (obj, courseLessonId) => {
        const THIS = $(obj).closest('.upload-container');
        const isYoutubeEmbedLink = $(obj).val();

        if (isYoutubeEmbedLink == 0) {
        THIS.find('.upload-in-aws-div').show();
        THIS.find('.video-link-div').hide();
        THIS.find('.all-link-div').hide();
    } else if (isYoutubeEmbedLink == 1) {
        THIS.find('.upload-in-aws-div').hide();
        THIS.find('.video-link-div').show();
        THIS.find('.all-link-div').hide();
    } else if (isYoutubeEmbedLink == 2) {
        THIS.find('.upload-in-aws-div').hide();
        THIS.find('.video-link-div').hide();
        THIS.find('.all-link-div').show();
    }   
    }

    const toggleIntroVideoUpload = (obj, courseLessonId) => {
        const THIS = $(obj).closest('.intro-video-container');
        const isYoutubeEmbedLink = $(obj).val();

        if (isYoutubeEmbedLink == 0) {
        THIS.find('.upload-in-aws-div').show();
        THIS.find('.video-link-div').hide();
        THIS.find('.all-link-div').hide();
    } else if (isYoutubeEmbedLink == 1) {
        THIS.find('.upload-in-aws-div').hide();
        THIS.find('.video-link-div').show();
        THIS.find('.all-link-div').hide();
    } else if (isYoutubeEmbedLink == 2) {
        THIS.find('.upload-in-aws-div').hide();
        THIS.find('.video-link-div').hide();
        THIS.find('.all-link-div').show();
    }   
    }
   



    const updateOrAddYoutubeEmbedLinkInVideo = async (obj, courseLessonId, courseTitle) => {
        const THIS = $(obj).closest('.upload-container');
        const youtubeEmbedLink = THIS.find('.youtube-embed-link').val();

        if (youtubeEmbedLink == '') {
            warning('toastr', `${courseTitle} Youtube Embed Link Required!`);
            return;
        }

        $(obj).hide();
        THIS.find('.btn-submitting').show();

        try {

            const route = `{{ route('cm.store-youtube-embed-link') }}`;
            const { data } = await axios.post(route, {
                id: courseLessonId,
                video: youtubeEmbedLink
            });

            const { status, title, video } = data || {};

            if (status) {
                THIS.find('.preview-youtube-embed-link').html(`
                    <iframe width="80" height="80" src="${video}" title="${title}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                `)

                THIS.find('.btn-successed').show();
            } else {
                THIS.find('.btn-failed').show();
            }

            $(obj).show();
            THIS.find('.btn-submitting').hide();

            setTimeout(() => {
                THIS.find('.btn-successed').hide();
                THIS.find('.btn-failed').hide();
            }, 3000);
        } catch (error) {
            console.error(error);
        }
    }
    const updateOrAddYoutubeEmbedLinkInIntroVideo = async (obj, courseId, courseTitle) => {
        const THIS = $(obj).closest('.intro-video-container');
        const youtubeEmbedLink = THIS.find('.youtube-embed-link').val();

        if (youtubeEmbedLink == '') {
            warning('toastr', `Youtube Embed Link Required!`);
            return;
        }

        $(obj).hide();
        THIS.find('.btn-submitting').show();

        try {

            const route = `{{ route('cm.store-intro-youtube-embed-link') }}`;
            const { data } = await axios.post(route, {
                id: courseId,
                intro_video: youtubeEmbedLink
            });

            const { status, title, intro_video } = data || {};

            if (status) {
                THIS.find('.preview-youtube-embed-link').html(`
                    <iframe width="80" height="80" src="${intro_video}" title="${title}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                `)

                THIS.find('.btn-successed').show();
            } else {
                THIS.find('.btn-failed').show();
            }

            $(obj).show();
            THIS.find('.btn-submitting').hide();

            setTimeout(() => {
                THIS.find('.btn-successed').hide();
                THIS.find('.btn-failed').hide();
            }, 3000);
        } catch (error) {
            console.error(error);
        }
    }

    const updateOrAddLinkInVideo = async (obj, courseLessonId, courseTitle) => {
        const THIS = $(obj).closest('.upload-container');
        const allLink = THIS.find('.all-link').val();

        if (allLink == '') {
            warning('toastr', `${courseTitle} Link Required!`);
            return;
        }

        $(obj).hide();
        THIS.find('.btn-submitting').show();

        try {

            const route = `{{ route('cm.all-link') }}`;
            const { data } = await axios.post(route, {
                id: courseLessonId,
                video: allLink
            });

            const { status, title, video } = data || {};

            if (status) {
                THIS.find('.preview-all-link').show()
                
                THIS.find('.btn-successed').show();
            } else {
                THIS.find('.btn-failed').show();
            }

            $(obj).show();
            THIS.find('.btn-submitting').hide();

            setTimeout(() => {
                THIS.find('.btn-successed').hide();
                THIS.find('.btn-failed').hide();
            }, 3000);
        } catch (error) {
            console.error(error);
        }
    }
    const updateOrAddLinkInIntroVideo = async (obj, courseId, courseTitle) => {
        const THIS = $(obj).closest('.intro-video-container');
        const allLink = THIS.find('.all-link').val();

        if (allLink == '') {
            warning('toastr', `Link Required!`);
            return;
        }

        $(obj).hide();
        THIS.find('.btn-submitting').show();

        try {

            const route = `{{ route('cm.intro-all-link') }}`;
            const { data } = await axios.post(route, {
                id: courseId,
                video: allLink
            });

            const { status, title, video } = data || {};

            if (status) {
                THIS.find('.preview-all-link').show()
                
                THIS.find('.btn-successed').show();
            } else {
                THIS.find('.btn-failed').show();
            }

            $(obj).show();
            THIS.find('.btn-submitting').hide();

            setTimeout(() => {
                THIS.find('.btn-successed').hide();
                THIS.find('.btn-failed').hide();
            }, 3000);
        } catch (error) {
            console.error(error);
        }
    }

//     function uploadFile(id) {
//     var form = document.getElementById('uploadForm-'+id);
//     var progressBar = document.getElementById('progressBar-'+id);
//     var submitBtn = document.getElementById('submitBtn-'+id);
//     var submittingBtn = document.getElementById('submittingBtn-'+id);
//     var successBtn = document.getElementById('successBtn-'+id);
//     var failedBtn = document.getElementById('failedBtn-'+id);

//     var xhr = new XMLHttpRequest();
//     xhr.open(form.method, form.action);
//     xhr.upload.onprogress = function(event) {
//         if (event.lengthComputable) {
//             var progress = (event.loaded / event.total) * 100;
//             progressBar.value = progress;
//         }
//     };

//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === XMLHttpRequest.DONE) {
//             progressBar.value = 100;
//             submitBtn.style.display = 'none';
//             submittingBtn.style.display = 'none';
//             if (xhr.status === 200) {
//                 successBtn.style.display = 'block';
//             } else {
//                 failedBtn.style.display = 'block';
//             }
//         }
//     };

//     xhr.upload.onerror = function() {
//         failedBtn.style.display = 'block';
//     };

//     var formData = new FormData(form);
//     xhr.send(formData);

//     submitBtn.style.display = 'none';
//     submittingBtn.style.display = 'block';
// }
function uploadFile(key) {
    var form = document.getElementById('uploadForm-' + key);
    var progressBar = document.getElementById('progressBar-' + key);
    var progressPercent = document.getElementById('progressPercent-' + key);

    var xhr = new XMLHttpRequest();
    xhr.open(form.method, form.action);

    xhr.upload.onprogress = function (event) {
        if (event.lengthComputable) {
            var percentComplete = (event.loaded / event.total) * 100;
            progressBar.value = percentComplete;
            progressPercent.textContent = percentComplete.toFixed(2) + '%';
        }
    };

    xhr.onload = function () {
        if (xhr.status === 200) {
            // File uploaded successfully
            document.getElementById('submitBtn-' + key).style.display = 'none';
            document.getElementById('submittingBtn-' + key).style.display = 'none';
            document.getElementById('successBtn-' + key).style.display = 'block';
            
            setTimeout(function () {
            window.location.reload();
        }, 2000); 

        } else {
            // Failed to upload file
            document.getElementById('submitBtn-' + key).style.display = 'none';
            document.getElementById('submittingBtn-' + key).style.display = 'none';
            document.getElementById('failedBtn-' + key).style.display = 'block';
        }
    };

    xhr.onerror = function () {
        // Error occurred during the upload
        document.getElementById('submitBtn-' + key).style.display = 'none';
        document.getElementById('submittingBtn-' + key).style.display = 'none';
        document.getElementById('failedBtn-' + key).style.display = 'block';
    };

    xhr.upload.onloadstart = function () {
        // Display the "Submitting..." message and hide the other buttons
        document.getElementById('submitBtn-' + key).style.display = 'none';
        document.getElementById('submittingBtn-' + key).style.display = 'block';
        document.getElementById('successBtn-' + key).style.display = 'none';
        document.getElementById('failedBtn-' + key).style.display = 'none';
    };

    var formData = new FormData(form);
    formData.append('video', document.getElementById('videoInput-' + key).files[0]);
    xhr.send(formData);
}
function introUploadFile() {
    var form = document.getElementById('uploadForm');
    var progressBar = document.getElementById('progressBar');
    var progressPercent = document.getElementById('progressPercent');

    var xhr = new XMLHttpRequest();
    xhr.open(form.method, form.action);

    xhr.upload.onprogress = function (event) {
        if (event.lengthComputable) {
            var percentComplete = (event.loaded / event.total) * 100;
            progressBar.value = percentComplete;
            progressPercent.textContent = percentComplete.toFixed(2) + '%';
        }
    };

    xhr.onload = function () {
        if (xhr.status === 200) {
            // File uploaded successfully
            document.getElementById('submitBtn').style.display = 'none';
            document.getElementById('submittingBtn').style.display = 'none';
            document.getElementById('successBtn').style.display = 'block';
            
            setTimeout(function () {
            window.location.reload();
        }, 2000); 

        } else {
            // Failed to upload file
            document.getElementById('submitBtn').style.display = 'none';
            document.getElementById('submittingBtn').style.display = 'none';
            document.getElementById('failedBtn').style.display = 'block';
        }
    };

    xhr.onerror = function () {
        // Error occurred during the upload
        document.getElementById('submitBtn').style.display = 'none';
        document.getElementById('submittingBtn').style.display = 'none';
        document.getElementById('failedBtn').style.display = 'block';
    };

    xhr.upload.onloadstart = function () {
        // Display the "Submitting..." message and hide the other buttons
        document.getElementById('submitBtn').style.display = 'none';
        document.getElementById('submittingBtn').style.display = 'block';
        document.getElementById('successBtn').style.display = 'none';
        document.getElementById('failedBtn').style.display = 'none';
    };

    var formData = new FormData(form);
    formData.append('intro_video', document.getElementById('videoInput').files[0]);
    xhr.send(formData);
}



    $(document).on('submit', '.attachment-upload-form', function(e) {
        e.preventDefault();

        const THIS = $(this).closest('.upload-container');
        let formData = new FormData(this);

        $.ajax({
            url: `{{ route('cm.insert-or-update-attachment') }}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(xhr) {
                THIS.find('.btn-submit').hide();
                THIS.find('.btn-submitting').show();
            },
            success: function({status, attachment}) {

                if (status) {
                    THIS.find('.attachment-initial-view').hide();
                    THIS.find('.attachment-after-insert-or-update-view').show();

                    THIS.find('.attachment-after-insert-or-update-view').html(`
                        <a href="${generateGoogleDriveUrl(attachment)}" target="_blank">
                            <img src="{{ asset('assets/img/pdf.png') }}" width="80" height="80" alt="title">
                        </a>
                    `)

                    THIS.find('.btn-successed').show();
                } else {
                    THIS.find('.btn-failed').show();
                }
            },
            error: function(xhr, status, error) {
                THIS.find('.btn-failed').show();
            },
            complete: function(xhr, status) {
                THIS.find('.remove').click();
                THIS.find('.btn-submit').show();
                THIS.find('.btn-submitting').hide();

                setTimeout(() => {
                    THIS.find('.btn-successed').hide();
                    THIS.find('.btn-failed').hide();
                }, 3000);
            }
        });
    });
</script>
