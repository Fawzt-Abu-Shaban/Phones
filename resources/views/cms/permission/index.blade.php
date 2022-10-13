@extends('cms.parent')

@section('titel', 'Permission')
@section('page-large-name', 'Permission')
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
                            <h3 class="card-title">Count : {{ $permission->count() }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Guard</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Setting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($permission as $data)
                                        <tr>
                                            <td>{{ $data->id }}.</td>
                                            <td>{{ $data->name }}</td>
                                            <td> <span class="badge bg-info">{{ $data->guard_name }}</span>
                                            </td>
                                            <td>{{ $data->created_at->format('y-m-d H:ma') }}</td>
                                            <td>{{ $data->updated_at->format('y-m-d H:ma') }}</td>
                                            @canany(['Update-Permission', 'Delete-Permission'])
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('permission.edit', $data->id) }}"
                                                            class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a onclick="destroypermission({{ $data->id }} , this)"
                                                            class="btn btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            @endcanany

                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="6"> No Data </td>
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
        function destroypermission(id, reference) {
            confirmDestroy('/mobile/admin/permission', id, reference)
        }
    </script>

@endsection
