@extends('cms.parent')

@section('titel', 'Category')
@section('page-large-name', 'Category')
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
                            <h3 class="card-title">Count : {{ $category->count() }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name EN</th>
                                        <th>Name AR</th>
                                        <th>Types</th>
                                        <th>Visible</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Setting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($category as $data)
                                        <tr>
                                            <td>{{ $data->id }}.</td>
                                            <td>{{ $data->name_en }}</td>
                                            <td>{{ $data->name_ar }}</td>
                                            <td>
                                                <span class="badge bg-info">({{ $data->type_count }}) Type/s</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge
                                                @if ($data->is_visible) bg-success
                                                @else bg-danger @endif">{{ $data->visibility_status }}</span>
                                            </td>
                                            <td>{{ $data->created_at->format('y-m-d H:ma') }}</td>
                                            <td>{{ $data->updated_at->format('y-m-d H:ma') }}</td>
                                            @canany(['Update-Category', 'Delete-Category'])
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('category.edit', $data->id) }}" class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        
                                                        <a onclick="categoryDestroy({{ $data->id }} , this)"
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
        function categoryDestroy(id, reference) {
            confirmDestroy('/mobile/admin/category', id, reference)
        }
    </script>

@endsection
