@extends('cms.parent')

@section('titel', 'Type')
@section('page-large-name', 'Type')
@section('page-small-name', 'Index')

@section('style')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">

            @if (session('msg'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    {{ session()->get('msg') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Count : {{ $type->count() }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name EN</th>
                                        <th>Name AR</th>
                                        <th>Category</th>
                                        <th>Product</th>
                                        <th>Visible</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Setting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($type as $data)
                                        <tr>
                                            <td>{{ $data->id }}.</td>
                                            <td>{{ $data->name_en }}</td>
                                            <td>{{ $data->name_ar }}</td>
                                            <td>{{ $data->category->name_en }}</td>
                                            <td>
                                                <span class="badge bg-info">({{ $data->product_count }}) Product/s</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge
                                                @if ($data->is_visible) bg-success
                                                @else bg-danger @endif">{{ $data->visibility_status }}</span>
                                            </td>
                                            <td>{{ $data->created_at->format('y-m-d H:ma') }}</td>
                                            <td>{{ $data->updated_at->format('y-m-d H:ma') }}</td>
                                            @canany(['Update-Type', 'Delete-Type'])
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('type.edit', $data->id) }}" class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a onclick="destroyType({{ $data->id }} , this)"
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
        function destroyType(id, reference) {
            confirmDestroy('/mobile/admin/type', id, reference)
        }
    </script>

@endsection
