@extends('cms.parent')

@section('titel', 'Role')
@section('page-large-name', 'Role')
@section('page-small-name', 'Update')

@section('style')
    <!-- Select2 -->
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
                            <h3 class="card-title">Update Role</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="reset_form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" value="{{ old('name', $role->name) }}" class="form-control"
                                        id="name" placeholder="name">
                                </div>

                                <div class="form-group">
                                    <label>Guard</label>
                                    <select id="guard" class="form-control guard" style="width: 100%;">
                                        <option value="{{ $role->guard_name }}" selected>{{ $role->guard_name }}</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="updateItem({{ $role->id }})"
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

    !--Select2-- >
    <script src="{{ asset('cms/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.guard').select2({
            theme: 'bootstrap4'
        })

        function updateItem(id) {
            let data = {
                name: document.getElementById('name').value,
                guard: document.getElementById('guard').value,
            }
            update('/mobile/admin/role', id, data, '/mobile/admin/role')
        }
    </script>

@endsection
