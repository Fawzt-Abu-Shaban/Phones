@extends('cms.parent')

@section('titel', 'User')
@section('page-large-name', 'User')
@section('page-small-name', 'Update')

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
                            <h3 class="card-title">Update User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        class="form-control" id="name" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                        class="form-control" id="address" placeholder="Address">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                                        class="form-control" id="phone" placeholder="Phone Number">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" value="{{ old('email', $user->email) }}" class="form-control"
                                        id="email" placeholder="Email">
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="updateUser({{ $user->id }})"
                                    class="btn btn-primary">Update</button>
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

        function updateUser(id) {
            let data = {
                name: document.getElementById('name').value,
                address: document.getElementById('address').value,
                phone: document.getElementById('phone').value,
                email: document.getElementById('email').value,
            }
            update('/mobile/admin/users', id, data, '/mobile/admin/users')
        }
    </script>

@endsection
