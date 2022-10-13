@extends('cms.parent')

@section('titel', 'User')
@section('page-large-name', 'User')
@section('page-small-name', 'Index')

@section('style')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Count : {{ $users->count() }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Permissions</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Setting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $data)
                                        <tr>
                                            <td>{{ $data->id }}.</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->address }}</td>
                                            <td>{{ $data->phone }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $data->email }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('user.show', $data->id) }}"
                                                    class="btn btn-block bg-gradient-warning btn-sm">({{ $data->permissions->count() }})
                                                    Permission/s</a>
                                            </td>
                                            <td>{{ $data->created_at->format('y-m-d H:ma') }}</td>
                                            <td>{{ $data->updated_at->format('y-m-d H:ma') }}</td>
                                            @canany(['Update-User', 'Delete-User'])
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('users.edit', $data->id) }}" class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a onclick="usersDestroy({{ $data->id }} , this)"
                                                            class="btn btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            @endcanany

                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="9"> No Data </td>
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
        function usersDestroy(id, reference) {
            confirmDestroy('/mobile/admin/users', id, reference)
        }
    </script>

@endsection
