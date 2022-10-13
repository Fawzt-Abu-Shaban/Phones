@extends('cms.parent')

@section('titel', 'Change-Password')
@section('page-large-name', 'Change-Password')
@section('page-small-name', 'change-password')

@section('style')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Change-Password</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="change-password-form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="password">Current Password</label>
                                    <input type="password" class="form-control" id="current_password"
                                        placeholder="Current Password">
                                </div>
                                <div class="form-group">
                                    <label for="name">New Password</label>
                                    <input type="password" class="form-control" id="new_password"
                                        placeholder="New Password">
                                </div>
                                <div class="form-group">
                                    <label for="name">New Password Confirmation</label>
                                    <input type="password" class="form-control" id="new_password_confirmation"
                                        placeholder="New Password Confirmation">
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="changePassword()" class="btn btn-primary">Change</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('script')
    <script>
        function changePassword() {
            axios.post('/mobile/admin/changepassword', {
                    current_password: document.getElementById('current_password').value,
                    new_password: document.getElementById('new_password').value,
                    new_password_confirmation: document.getElementById('new_password_confirmation').value,
                })
                .then(function(response) {
                    // handle success 2xx
                    console.log(response);
                    document.getElementById('change-password-form').reset();
                    toastr.success(response.data.message)
                })
                .catch(function(error) {
                    // handle error 4xx , 5xx
                    console.log(error);
                    toastr.error(error.response.data.message)
                });
        }
    </script>
@endsection
