@extends('layouts.master')

@section('title', 'Student Edit')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>
        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="javascript:void(0)">Course Management</a></li>
            <li><a class="text-muted" href="{{ route('cm.students.index') }}">Students</a></li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>

    <div class="mt-2">
        @include('partials._alert_message')
    </div>

    <form action="{{ route('cm.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h4 class="my-2" style="color: black">Basic Information</h4>
        <div class="row mb-2">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">First Name <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $student->first_name) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Last Name</label>
                    <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $student->last_name) }}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Username</label>
                    <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="username" value="{{ old('username', $student->username) }}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Email <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <input type="email" class="form-control" name="email" value="{{ $student->email }}" disabled autocomplete="off" style="background: #dfdfdf !important; color: #000000 !important; font-weight: 500; border-color: #dfdfdf">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Phone <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $student->phone) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Bio</label>
                    <div class="col-sm-12 col-md-8">
                        <textarea name="bio" class="form-control" rows="2">{{ old('bio', $student->bio) }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Gender <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <select class="form-select" name="gender">
                            @foreach (genders() as $gender)
                                <option value="{{ $gender }}" {{ old('gender', $student->gender) == $gender ? 'selected' : '' }}>{{ $gender }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Country <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <select class="form-select select2" name="country_id" onchange="fetchStatesAndCities()" id="country_id" data-placeholder="- Select Country -" style="width: 100%">
                            <option></option>
                            @foreach ($countries as $id => $name)
                                <option value="{{ $id }}" {{ old('country_id', $student->country_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">State</label>
                    <div class="col-sm-12 col-md-8">
                        <select class="form-select select2" name="state_id" id="state_id" onchange="fetchCities()" data-placeholder="- Select State -" style="width: 100%">
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">City <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <select class="form-select select2" name="city_id" id="city_id" data-placeholder="- Select City -" style="width: 100%">
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Street Address 1 <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="address_1" value="{{ old('address_1', $student->address_1) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Street Address 2</label>
                    <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="address_2" value="{{ old('address_2', $student->address_2) }}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Postcode <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control only-number" name="postcode" value="{{ old('postcode', $student->postcode) }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Status (Published) <sup style="color: red">*</sup></label>
                    <div class="col-sm-12 col-md-8">
                        <div class="material-switch" style="padding-top: 6px">
                            <input type="checkbox" name="status" id="status" value="1" {{ old('status') || $student->status ? 'checked' : '' }} />
                            <label for="status" class="badge-primary"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Image</label>
                    <div class="col-sm-12 col-md-8">
                        <div style="display: flex; align-items: center; justify-content:space-between">
                            <div>
                                <input type="file" name="image" accept="image/webp, image/png, image/gif, image/jpg, image/jpeg">
                                <small class="text-danger">Image size must be 450X450.</small>
                            </div>
                            @if ($student->image != '' && file_exists($student->image))
                                <br><img src="{{ asset($student->image) }}" class="img-thumbnail img-circle" width="50px" height="50px" alt="{{ $student->username }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <h4 class="mb-2" style="color: black">Auth Information</h4>
        <div class="row mb-2">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-4 col-form-label">Change Password</label>
                    <div class="col-sm-12 col-md-8">
                        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" style="position: absolute">
                        <span id="icon" style="position: absolute; top: 8px; right: 0; cursor: pointer" data-type="show" onclick="passwordToggle(this)">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                </div>
                <div class="form-group row" style="margin-top: -10px">
                    <label class="col-sm-12 col-md-4 col-form-label"></label>
                    <div class="col-sm-12 col-md-8">
                        <small>If you change your current password then add new one!</small>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <h4 class="mb-2" style="color: black">Education Information</h4>
        <div id="instructorEducations">
            {{-- ADD DYNAMICALLY --}}
            @if(old('title'))
                @foreach (old('title') as $key => $title)
                    <div class="row education mb-1">
                        <div class="col-sm-12 col-md-9">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="input-group">
                                        <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Title <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="title[]" value="{{ $title }}" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="input-group">
                                        <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Institute <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="institute[]" value="{{ old('institute')[$key] }}" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="row">
                                <div class="col-sm-12 col-md-10">
                                    <div class="input-group">
                                        <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Session <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="session[]" value="{{ old('session')[$key] }}" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <i class="far fa-times-circle" onclick="removeEducation(this)" style="font-size: 20px; color: red; padding-top: 7px; cursor: pointer"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            @foreach ($student->userEducations as $education)
                <div class="row education mb-1">
                    <div class="col-sm-12 col-md-9">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="input-group">
                                    <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Title <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="title[]" value="{{ $education->title }}" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="input-group">
                                    <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Institute <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="institute[]" value="{{ $education->institute }}" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="row">
                            <div class="col-sm-12 col-md-10">
                                <div class="input-group">
                                    <label class="input-group-addon" style="background: #dfdfdf; color: #000000">Session <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="session[]" value="{{ $education->session }}" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <i class="far fa-times-circle" onclick="removeEducation(this)" style="font-size: 20px; color: red; padding-top: 7px; cursor: pointer"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button
            type="button"
            style="padding: 4px 8px;
                border-radius: 5px;
                background: #bfffd4 !important;
                border: 2px solid #bfffd4;
                color: black;
                font-weight: 500"
            onclick="addEducation()"
        >
            <i class="far fa-plus-circle"></i> ADD EDUCATION
        </button>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group pull-right">
                    <button class="btn btn-sm btn-theme">
                        <i class="far fa-check-circle"></i>
                        UPDATE
                    </button>
                    <a class="btn btn-sm btn-yellow ml-1" href="{{ route('cm.students.index') }}">
                        <i class="far fa-long-arrow-left"></i>
                        BACK TO LIST
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection





@section('js')
    @include('student/_inc/script')
@endsection
