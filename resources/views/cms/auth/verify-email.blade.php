<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mobile | Verify </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('cms/dist/css/adminlte.min.css') }}" />
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}" />
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="{{ asset('img\mobile.png') }}" width="350" height="200" alt="User Image">
            </div>
            <div class="card-body">
                <p class="login-box-msg">Verify Email Address</p>

                <form>
                    @csrf
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="button" onclick="verifyEmailAddress()" class="btn btn-primary btn-block">
                            Resend Verification Email
                        </button>
                    </div>
                    <!-- /.col -->
            </div>
            </form>


        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('cms/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('cms/dist/js/adminlte.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('jss/axios.js') }}"></script>

    <script>
        function verifyEmailAddress() {
            axios.post('/email/verification-notification')
                .then(function(response) {
                    // handle success 2xx
                    console.log(response);
                    toastr.success(response.data.message)
                    // window.location.href = '/mobile/admin'
                })
                .catch(function(error) {
                    // handle error 4xx , 5xx
                    console.log(error);
                    toastr.error(error.response.data.message)
                });
        }
    </script>


</body>

</html>
