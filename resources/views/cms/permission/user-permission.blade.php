@extends('cms.parent')

@section('titel', 'User-Permission')
@section('page-large-name', 'User-Permission')
@section('page-small-name', 'Index')

@section('style')
    <link rel="stylesheet" href="{{ asset('cms/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $user->name }}-Permissions</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Permission Name</th>
                                        <th>Permission Guard</th>
                                        <th>Assigned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($permission as $data)
                                        <tr>
                                            <td>{{ $data->id }}.</td>
                                            <td>{{ $data->name }}</td>
                                            <td> <span class="badge bg-info">{{ $data->guard_name }}</span>
                                            </td>
                                            <td>
                                                {{-- checked="" --}}
                                                <div class="form-group clearfix">
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox"
                                                            onclick="assignPermission('{{ $user->id }}' , '{{ $data->id }}')"
                                                            id="Permission_{{ $data->id }}"
                                                            @if ($data->assigned) checked @endif>
                                                        <label for="Permission_{{ $data->id }}">
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="4"> No Data </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">

                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
    </section>
@endsection

@section('script')
    <script>
        function assignPermission(userId, permissionId) {
            axios.post('/mobile/admin/permission/user', {
                    user_id: userId,
                    permission_id: permissionId,
                })
                .then(function(response) {
                    // handle success 2xx
                    console.log(response);
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
