@php 
    $hasCoursePermission  = hasAnyPermission(['course-view'], $slugs);
    $hasLessonQuizPermission       = hasAnyPermission(['lesson-quiz-view'], $slugs);
    $hasCategoryPermission       = hasAnyPermission(['course-category-view'], $slugs);
    $hasInstructorCreatePermission       = hasAnyPermission(['instructor-create'], $slugs);
    $hasInstructorListPermission       = hasAnyPermission(['instructor-view'], $slugs);
    $hasStudentCreatePermission       = hasAnyPermission(['student-create'], $slugs);
    $hasStudentListPermission       = hasAnyPermission(['student-view'], $slugs);
@endphp

@if (($hasCoursePermission || $hasLessonQuizPermission || $hasCategoryPermission  ))

<li>
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon far fa-book-alt"></i>
        <span class="menu-text" style="font-size: 11.5px">Course Management</span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>

    <ul class="submenu">
        @if (hasPermission('course-view', $slugs))
        <li>
            <a href="{{ route('cm.courses.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Course
            </a>
        </li>
        @endif
        @if (hasPermission('lesson-quiz-view', $slugs))
        <li>
            <a href="{{ route('cm.lesson-quiz.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Lesson Quiz
            </a>
        </li>
        @endif
        @if (hasPermission('lesson-quiz-view', $slugs))
        <li>
            <a href="{{ route('cm.course-categories.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Category
            </a>
        </li>
        @endif
    </ul>
</li>

@endif
@if (($hasInstructorCreatePermission || $hasInstructorListPermission ))

<li>
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fal fa-chalkboard-teacher"></i>
        <span class="menu-text" style="font-size: 11.5px">Instructor</span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>

    <ul class="submenu">
        @if (hasPermission('instructor-create', $slugs))

        <li>
            <a href="{{ route('cm.instructors.create') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Create
            </a>
        </li>
        @endif
        @if (hasPermission('instructor-view', $slugs))
        <li>
            <a href="{{ route('cm.instructors.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                List
            </a>
        </li>
        @endif
    </ul>
</li>
@endif
@if (($hasStudentCreatePermission || $hasStudentListPermission ))

<li>
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fas fa-users-class"></i>
        <span class="menu-text" style="font-size: 11.5px">Student</span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>

    <ul class="submenu">
        @if (hasPermission('student-create', $slugs))
        <li>
            <a href="{{ route('cm.students.create') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Create
            </a>
        </li>
        @endif
        @if (hasPermission('student-view', $slugs))
        <li>
            <a href="{{ route('cm.students.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                List
            </a>
        </li>
        @endif
    </ul>
</li>
@endif