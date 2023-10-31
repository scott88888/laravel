<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>

    @include('layouts/head')
</head>



<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="page-container">
        @include('layouts/sidebar')
        <div class="main-content">
            @include('layouts/headerarea')
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                          
                            @if (session('message') == 'change password')
                            
                            <div class="alert alert-warning " role="alert">
                                <h4 class="alert-heading">{{ $langArray->請先修改預設密碼 }}</h4>

                            </div>
                            @endif
                            <div class="card-header">{{ $langArray->修改密碼 }}</div>

                            <div class="card-body">

                                <form method="POST" action="userPasswordUpdate">
                                    @csrf

                                    <!-- Current Password -->
                                    <div class="form-group row">
                                        <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ $langArray->原密碼 }}</label>

                                        <div class="col-md-6">
                                            <input id="current_password" type="password" value='{{ $def_pass }}' class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="current-password">

                                            @error('current_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- New Password -->
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ $langArray->新密碼 }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Confirm New Password -->
                                    <div class="form-group row">
                                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ $langArray->確認密碼 }}</label>

                                        <div class="col-md-6">
                                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ $langArray->更新密碼 }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts/footer')
    </div>
    @include('layouts/settings')
</body>
@include('layouts/footerjs')

</html>