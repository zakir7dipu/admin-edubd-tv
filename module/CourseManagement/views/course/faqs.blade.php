@extends('layouts.master')

@section('title', 'Course FAQs')


@section('style')
    @include('course/_inc/style')
@endsection


@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-question-circle"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.courses.index') }}">Course</a></li>
            <li class=""><a href="javascript:void(0)">FAQs</a></li>
        </ul>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            @include('partials._alert_message')

            <div id="fuelux-wizard-container">
                @include('course/_inc/wizard-heading')
                <hr />
                
                <form action="{{ route('cm.courses.faqs-update-or-create', $course_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="step-pane active" data-step="6">
                        <div class="row">
                            <div class="col-sm-12 col-md-8 col-md-offset-2">
                                <div id="faqs">
                                    @foreach ($courseFAQs as $courseFAQ)
                                        <div class="faq">
                                            <input type="text" name="faq_title[]" class="form-control" value="{{ $courseFAQ->title }}" placeholder="Title">
                                            <textarea type="text" name="faq_description[]" class="form-control" placeholder="Description" rows="5">{{ $courseFAQ->description }}</textarea>
                                            <i onclick="removeFAQ(this)" class="far fa-times-circle remove-icon"></i>
                                        </div>
                                    @endforeach

                                    @if (old('faq_title'))
                                        @foreach (old('faq_title') as $key => $faq_title)
                                            <div class="faq">
                                                <input type="text" name="faq_title[]" class="form-control" value="{{ $faq_title }}" placeholder="Title">
                                                <textarea type="text" name="faq_description[]" class="form-control" placeholder="Description" rows="5">{{ old('faq_description')[$key] }}</textarea>
                                                <i onclick="removeFAQ(this)" class="far fa-times-circle remove-icon"></i>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if (count($courseFAQs) == 0)
                                        <div class="faq">
                                            <input type="text" name="faq_title[]" class="form-control" placeholder="Title">
                                            <textarea type="text" name="faq_description[]" class="form-control" placeholder="Description" rows="5"></textarea>
                                            <i onclick="removeFAQ(this)" class="far fa-times-circle remove-icon"></i>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="add-more" onclick="addFAQ()">
                                    <i class="far fa-plus-circle"></i> ADD FAQ
                                </button>
                            </div>
                        </div>
                    </div>
                
                    <hr />
                
                    <div class="wizard-actions" style="display: flex; align-items: center; justify-content: space-between">
                        <a href="{{ route('cm.courses.outcomes-update-or-create', $course_id) }}" class="btn btn-sm btn-prev">
                            <i class="ace-icon fa fa-arrow-left"></i>
                            PREVIOUS
                        </a>
                    
                        <button type="submit" class="btn btn-sm btn-theme">
                            SAVE & NEXT
                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection




@section('script')
    @include('course/_inc/script')
@endsection