@extends('layouts.master')

@section('title', 'Course Introductions')


@section('style')
    @include('course/_inc/style')
@endsection


@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-info-circle"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.courses.index') }}">Courses</a></li>
            <li class=""><a href="javascript:void(0)">Introductions</a></li>
        </ul>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            @include('partials._alert_message')

            <div id="fuelux-wizard-container">
                @include('course/_inc/wizard-heading')
                <hr />
                
                <form action="{{ route('cm.courses.introductions-update-or-create', $course_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="step-pane active" data-step="3">
                        <div class="row">
                            <div class="col-sm-12 col-md-8 col-md-offset-2">
                                <div class="mb-3" style="display: flex; align-items: center; justify-content: space-between">
                                    <div>Icon Reference Link: <a href="https://ionic.io/ionicons" target="_blank">ionicons <i class="far fa-external-link-alt"></i></a></div>
                                    
                                    <div class="display: flex; align-items: center;">
                                        <i class="far fa-info-circle" title="When you go to the reference link and after choose an icon then it will be popup an icon tag. You should be copy the name of icon and use in Icon field. This is a reference image for what should you do!" data-toggle="tooltip" style="cursor: help; color: #696969"></i>
                                        <img src="{{ asset('assets/img/icon-ref.png') }}" style="border-radius: 5px" alt="">    
                                    </div>                                    
                                </div>
                                <div id="introductions">
                                    @foreach ($courseIntroductions as $introduction)
                                        <div class="introduction">
                                            <span class="introduction-label">Icon</span>
                                            <input type="text" name="introduction_icon[]" class="form-control" value="{{ $introduction->icon }}" style="width: 30%" autocomplete="off">
                                            <span class="introduction-label">Text</span>
                                            <input type="text" name="introduction_text[]" class="form-control" value="{{ $introduction->text }}" autocomplete="off">
                                            <button 
                                                onclick="removeIntroduction(this)"
                                                class="remove-btn"
                                            >
                                                <i class="far fa-times-circle"></i>
                                            </button>
                                        </div>
                                    @endforeach

                                    @if (old('introduction_icon'))
                                        @foreach (old('introduction_icon') as $key => $introductIcon)
                                            <div class="introduction">
                                                <span class="introduction-label">Icon</span>
                                                <input type="text" name="introduction_icon[]" class="form-control" value="{{ $introductIcon }}" style="width: 30%" autocomplete="off">
                                                <span class="introduction-label">Text</span>
                                                <input type="text" name="introduction_text[]" class="form-control" value="{{ old('introduction_icon')[$key] }}" autocomplete="off">
                                                <button 
                                                    onclick="removeIntroduction(this)"
                                                    class="remove-btn"
                                                >
                                                    <i class="far fa-times-circle"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                                
                                    @if (count($courseIntroductions) == 0)
                                        <div class="introduction">
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
                                        </div>
                                    @endif
                                </div>
                    
                                <button type="button" class="add-more" onclick="addIntroduction()">
                                    <i class="far fa-plus-circle"></i> ADD INTRODUCTION
                                </button>
                            </div>
                        </div>
                    </div>
                
                    <hr />
                
                    <div class="wizard-actions" style="display: flex; align-items: center; justify-content: space-between">
                        <a href="{{ route('cm.courses.intro-video', $course_id) }}" class="btn btn-sm btn-prev">
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