@extends('cms.parent')

@section('titel', 'Admins')
@section('page-large-name', 'Admins')
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
                            <h3 class="card-title">Count : {{ $admins->count() }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Setting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($admins as $data)
                                        <tr>
                                            <td>{{ $data->id }}.</td>
                                            <td>{{ $data->name }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $data->email }}</span>
                                            </td>
                                            <td>{{ $data->created_at->format('y-m-d H:ma') }}</td>
                                            <td>{{ $data->updated_at->format('y-m-d H:ma') }}</td>
                                            @canany(['Update-Admin' , 'Delete-Admin'])
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('admins.edit', $data->id) }}" class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a onclick="adminsDestroy({{ $data->id }} , this)"
                                                            class="btn btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            @endcanany

                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="5"> No Data </td>
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
        function adminsDestroy(id, reference) {
            confirmDestroy('/mobile/admin/admins', id, reference)
        }
    </script>

@endsection
