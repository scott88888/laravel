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

                         
                            @error('createErr')

                            <div class="alert alert-warning " role="alert">
                                <h4 class="alert-heading">建立帳號失敗</h4>

                            </div>
                            @enderror
                            <div class="card-header">建立帳號</div>

                            <div class="card-body">

                                <form method="POST" action="userCreateAccount">
                                    @csrf


                                    <div class="form-group row">
                                        <label for="employee_id" class="col-md-4 col-form-label text-md-right">員工編號</label>

                                        <div class="col-md-6">
                                            <input id="employee_id" value='' class="form-control" name="employee_id">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">員工姓名</label>

                                        <div class="col-md-6">
                                            <input id="name" class="form-control" name="name">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">信箱</label>

                                        <div class="col-md-6">
                                            <input id="email" class="form-control" name='email'>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                建立帳號
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