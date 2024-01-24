@if ((hasAnyPermission(['slider-view'], $slugs) || hasAnyPermission(['social-link-view'], $slugs) || hasAnyPermission(['tstimonials-view'], $slugs)||
hasAnyPermission(['faq-view'], $slugs)|| hasAnyPermission(['support-view'], $slugs)|| hasAnyPermission(['page-view'], $slugs)|| hasAnyPermission(['subscriber-view'], $slugs) || 
hasAnyPermission(['blog-view'], $slugs)|| hasAnyPermission(['about-view'], $slugs)|| hasAnyPermission(['terms-and-condition-view'], $slugs)||
 hasAnyPermission(['return-and-refund-policy-view'], $slugs)|| hasAnyPermission(['privacy-policy-view'], $slugs)|| hasAnyPermission(['become-instructor-view'], $slugs)|| hasAnyPermission(['site-info'], $slugs)))

<li>
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fal fa-globe"></i>
        <span class="menu-text">Website CMS</span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>

    <ul class="submenu">
        @if (hasPermission('slider-view', $slugs))
        <li>
            <a href="{{ route('wc.sliders.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Slider
            </a>
        </li>@endif
        @if (hasPermission('social-link-view', $slugs))
        <li>
            <a href="{{ route('wc.social-links.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Social Link
            </a>
        </li>@endif
        @if (hasPermission('tstimonials-view', $slugs))
        <li>
            <a href="{{ route('wc.testimonials.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Testimonials
            </a>
        </li>@endif
        @if (hasPermission('faq-view', $slugs))
        <li>
            <a href="{{ route('wc.faqs.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                FAQ
            </a>
        </li>@endif
        @if (hasPermission('support-view', $slugs))
        <li>
            <a href="{{ route('wc.support.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Support
            </a>
        </li>@endif
        @if (hasPermission('page-view', $slugs))
        <li>
            <a href="{{ route('wc.pages.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Page
            </a>
        </li>@endif
        @if (hasPermission('subscriber-view', $slugs))
        <li>
            <a href="{{ route('wc.subscribers.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Subscriber
            </a>
        </li>@endif
        @if (hasPermission('blog-view', $slugs) || hasPermission('blog-create', $slugs)||hasPermission('blog-cetegory-view', $slugs) )
        <li>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon far fa-rss-square"></i>
                <span class="menu-text">Blog</span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                @if (hasPermission('blog-cetegory-view', $slugs))
                <li>
                    <a href="{{ route('wc.blog-category.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Category
                    </a>
                </li>
                @endif
                @if (hasPermission('blog-crate', $slugs))
                <li>
                    <a href="{{ route('wc.blog.create') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Create
                    </a>
                </li>@endif
                @if (hasPermission('blog-view', $slugs))
                <li>
                    <a href="{{ route('wc.blog.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        List
                    </a>
                </li>@endif

            </ul>
        </li>@endif
        @if (hasPermission('about-view', $slugs))
        <li>
            <a href="{{ route('wc.about.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                About
            </a>
        </li>@endif
        @if (hasPermission('terms-and-condition-view', $slugs))
        <li>
            <a href="{{ route('wc.terms-and-condition.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Terms and Condition
            </a>
        </li>@endif
        @if (hasPermission('return-and-refund-policy-view', $slugs))
        <li>
            <a href="{{ route('wc.return-refund-policy.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Return & Refund policy
            </a>
        </li>@endif
        @if (hasPermission('privacy-policy-viewy', $slugs))
        <li>
            <a href="{{ route('wc.privacy-policy.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Privacy policy
            </a>
        </li>@endif
        {{-- @if (hasPermission('become-instructor-view', $slugs))
        <li>
            <a href="{{ route('wc.become-instructor.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Become Instructor
            </a>
        </li>@endif --}}
        @if (hasPermission('site-info', $slugs))
        <li>
            <a href="{{ route('wc.siteinfo.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Site Info
            </a>
        </li>
        @endif
    </ul>
</li>
@endif
