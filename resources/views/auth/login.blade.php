@php
    $siteInfo = optional(\Module\WebsiteCMS\Models\SiteInfo::find(1));
@endphp


<!DOCTYPE html>
<html lang="en">
<head>
    <title>LOGIN</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        a {
            text-decoration: none;
        }

        .login-page {
            width: 100%;
            height: 100vh;
            display: inline-block;
            display: flex;
            align-items: center;
        }

        .form-right i {
            font-size: 100px;
        }

        .cursor-pointer {
            cursor: pointer
        }
    </style>
</head>
<body>
    <div class="login-page bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="bg-white shadow rounded">
                        <div class="row">
                            <div class="col-md-5 ps-0 d-none d-md-block">
                                <div class="d-flex flex-col align-items-center justify-content-center form-right h-100 text-dark text-center" style="background: #eff6ff">
                                    @if (file_exists($siteInfo->logo))
                                    <img src="{{ asset($siteInfo->logo) }}" alt="logo" width="200">
                                @else
                                    <h2 style="font-weight: 600; color: #1265D7">
                                       Site Logo
                                    </h2>
                                @endif
                                </div>
                            </div>
                            <div class="col-md-7 pe-0">
                                <div class="form-left h-100 py-5 px-5">
                                    <h3 class="mb-3">Login Now</h3>
                                    <form method="POST" action="{{ route('login') }}" class="row g-4">
                                        @csrf
                                        <div class="col-12">
                                            <label>Email Address<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="bi bi-envelope"></i></div>
                                                <input type="email" name="email" class="form-control input-field @error('email') is-invalid @enderror" placeholder="Enter Email Address">
                                            </div>
                                            @error('email')
                                                <span class="text-danger" style="font-size: 12px; font-weight: 500">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label>Password<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="bi bi-lock"></i></div>
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password" >
                                            </div>
                                            @error('password')
                                                <span class="text-danger" style="font-size: 12px; font-weight: 500">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label cursor-pointer" for="remember">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-primary px-4 float-end">LOGIN</button>
                                        </div>
                                    </form>
                                    <div style="line-height: 8px; font-size: 12px; font-weight: 600">
                                        <p class="text-center text-secondary mt-3">Copyright &copy; {{ date('Y') }} All Rights Reserved.</p>
                                        <p class="text-center">Developed By: <a href="https://www.smartsoftware.com.bd/" target="_blank">Smart Software Ltd.</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
