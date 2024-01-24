<div>
    <ul class="steps">
        <li data-step="1" class="{{ in_array(Route::currentRouteName(), ['cm.courses.create', 'cm.courses.edit']) ? 'active' : '' }}">
            <a 
                @if (Route::currentRouteName() === 'cm.courses.create' || $course_id == 0)
                    href="{{ route('cm.courses.create') }}"
                @else
                    href="{{ route('cm.courses.edit', $course_id) }}"
                @endif
            >
                <span class="step">1</span>
                <span class="title">Basic Info</span>
            </a>
        </li>
        <li data-step="2" >
            <a href="{{ route('cm.courses.intro-video', $course_id ?? 0) }}">
                <span class="step">2</span>
                <span class="title">Intro Video</span>
            </a>
        </li>
        <li data-step="3" class="{{ Route::is('cm.courses.introductions-update-or-create') ? 'active' : '' }}">
            <a href="{{ route('cm.courses.introductions-update-or-create', $course_id ?? 0) }}">
                <span class="step">3</span>
                <span class="title">Introduction</span>
            </a>
        </li>

        <li data-step="4" class="{{ Route::is('cm.courses.instructors-update-or-create') ? 'active' : '' }}">
            <a href="{{ route('cm.courses.instructors-update-or-create', $course_id ?? 0) }}">
                <span class="step">4</span>
                <span class="title">Instructor</span>
            </a>
        </li>

        <li data-step="5" class="{{ Route::is('cm.courses.outcomes-update-or-create') ? 'active' : '' }}">
            <a href="{{ route('cm.courses.outcomes-update-or-create', $course_id ?? 0) }}">
                <span class="step">5</span>
                <span class="title">Outcome</span>
            </a>
        </li>

        <li data-step="6" class="{{ Route::is('cm.courses.faqs-update-or-create') ? 'active' : '' }}">
            <a href="{{ route('cm.courses.faqs-update-or-create', $course_id ?? 0) }}">
                <span class="step">6</span>
                <span class="title">FAQ</span>
            </a>
        </li>

        <li data-step="7" class="{{ Route::is('cm.courses.topics-update-or-create') ? 'active' : '' }}">
            <a href="{{ route('cm.courses.topics-update-or-create', $course_id ?? 0) }}">
                <span class="step">7</span>
                <span class="title">Topic</span>
            </a>
        </li>

        <li data-step="8" class="{{ Route::is('cm.courses.lessons-update-or-create') ? 'active' : '' }}">
            <a href="{{ route('cm.courses.lessons-update-or-create', $course_id ?? 0) }}">
                <span class="step">8</span>
                <span class="title">Lesson</span>
            </a>
        </li>

        <li data-step="9">
            <a href="{{ route('cm.courses.upload', $course_id ?? 0) }}">
                <span class="step">9</span>
                <span class="title">Upload</span>
            </a>
        </li>

        <li data-step="10">
            <a href="{{ route('cm.courses.publish', $course_id ?? 0) }}">
                <span class="step">10</span>
                <span class="title">Publish</span>
            </a>
        </li>
    </ul>
</div>