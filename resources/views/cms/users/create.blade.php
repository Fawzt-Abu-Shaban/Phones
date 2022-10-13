@extends('cms.parent')

@section('titel', 'User')
@section('page-large-name', 'User')
@section('page-small-name', 'Create')

@section('style')
    <link rel="stylesheet" href="{{ asset('cms/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

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
                            <h3 class="card-title">Create User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="reset_form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" value="{{ old('name') }}" class="form-control" id="name"
                                        placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" value="{{ old('address') }}" class="form-control" id="address"
                                        placeholder="Address">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" value="{{ old('phone') }}" class="form-control" id="phone"
                                        placeholder="Phone Number">
                                </div>

                                <div class="form-group">
                                    <label for="name">Email</label>
                                    <input type="email" value="{{ old('email') }}" class="form-control" id="email"
                                        placeholder="Email">
                                </div>

                                {{-- <div class="form-group">
                                    <label>Roles</label>
                                    <select class="form-control roles" id="role_id" style="width: 100%;">
                                        <option value="" selected disabled>Select Role</option>
                                        @foreach ($role as $roles)
                                            <option value="{{ $roles->id }}">{{ $roles->name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                            </div>

                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="createUser()" class="btn btn-primary">Create</button>
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

    <script src="{{ asset('cms/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $('.roles').select2({
            theme: 'bootstrap4'
        })

        function createUser() {
            let data = {
                name: document.getElementById('name').value,
                address: document.getElementById('address').value,
                phone: document.getElementById('phone').value,
                email: document.getElementById('email').value,
            }
            store('/mobile/admin/users', data)
        }
    </script>

@endsection
