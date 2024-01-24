@if ((hasAnyPermission(['exam-category'], $slugs) || hasAnyPermission(['exam-year'], $slugs) || hasAnyPermission(['exam-institute'], $slugs)|| hasAnyPermission(['exam-view'], $slugs)|| hasAnyPermission(['exam-quiz'], $slugs) ))

<li>
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon far fa-book-alt"></i>
        <span class="menu-text" style="font-size: 11.5px">Exam Management</span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>

    <ul class="submenu">
        @if (hasPermission('exam-category', $slugs))
        <li>
            <a href="{{ route('em.exam-categories.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Exam Category
            </a>
        </li>
        @endif
        @if (hasPermission('exam-year', $slugs))
        <li>
            <a href="{{ route('em.exam-years.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Exam Year
            </a>
        </li>
        @endif
        {{-- <li>
            <a href="{{ route('em.exam-types.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Exam Type
            </a>
        </li> --}}
        @if (hasPermission('exam-institute', $slugs))
        <li>
            <a href="{{ route('em.institutes.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Institute
            </a>
        </li>
        @endif
        @if (hasPermission('exam-view', $slugs))
        <li>
            <a href="{{ route('em.exams.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Exam
            </a>
        </li>
        @endif
        @if (hasPermission('exam-quiz', $slugs))
        <li>
            <a href="{{ route('em.exam-quizzes.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Quiz
            </a>
        </li>
        @endif
    </ul>
</li>
@endif