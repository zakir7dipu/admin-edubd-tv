<div class="step-pane" data-step="9">
    <div class="course" style="display: flex; align-items: center; justify-content: space-between; gap: 20px; width: 100%">
        <div style="display: flex; align-items: center; justify-content: space-between">
            <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 200px;">
                <div class="material-switch">
                    <input type="hidden" class="course-not-published" name="course_is_published[]" value="0" disabled />
                    <input type="checkbox" onclick="courseIsPublishToggle(this)" class="course-is-published" name="course_is_published[]" id="courseIsPublished" value="1" checked />
                    <label for="courseIsPublished" class="badge-primary"></label>
                </div>
                <label style="padding-top: 5px">Publish</label>
            </div>
            <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; width: 200px">
                <div class="material-switch">
                    <input type="hidden" class="course-not-auto-published" name="course_is_auto_published[]" value="0" />
                    <input type="checkbox" onclick="courseIsAutoPublishToggle(this)" class="course-is-auto-published" name="course_is_auto_published[]" id="courseIsAutoPublished" value="1" />
                    <label for="courseIsAutoPublished" class="badge-primary"></label>
                </div>
                <label style="padding-top: 5px">Auto Publish</label>
                <i class="fas fa-info-circle course-auto-publish-note" title="If you wanna enable auto publish it will show published at field which is required. Note: it will be disable publish field also!" data-toggle="tooltip" style="cursor: help; color: #696969"></i>
            </div>
        </div>
        <input type="datetime-local" class="form-control course-published-at" name="course_published_at[]" style="display: none">
    </div>
</div>