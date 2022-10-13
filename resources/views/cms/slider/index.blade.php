@extends('cms.parent')

@section('titel', 'Slider')
@section('page-large-name', 'Slider')
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
                            <h3 class="card-title">Count : {{ $slider->count() }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Iamge</th>
                                        <th>Name EN</th>
                                        <th>Name AR</th>
                                        <th>Price</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Setting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($slider as $data)
                                        <tr>
                                            <td>{{ $data->id }}.</td>
                                            <td>
                                                <img class="direct-chat-img" height="60" width="60"
                                                    src="{{ Storage::url('sliders/' . $data->image) }}"
                                                    alt="message user image">
                                            </td>
                                            <td>{{ $data->name_en }}</td>
                                            <td>{{ $data->name_ar }}</td>
                                            <td> <span class="badge bg-info">{{ $data->price }} /$</span>
                                            </td>
                                            <td>{{ $data->created_at->format('y-m-d H:ma') }}</td>
                                            <td>{{ $data->updated_at->format('y-m-d H:ma') }}</td>
                                            @canany(['Update-Slider', 'Delete-slider'])
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('slider.edit', $data->id) }}" class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if ($data->trashed())
                                                            <a onclick="destroyslider({{ $data->id }})"
                                                                class="btn btn-warning">
                                                                <i class="fas fa-trash-restore"></i>
                                                            </a>
                                                        @else
                                                            <a onclick="destroyslider({{ $data->id }})"
                                                                class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        @endif

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
        function destroyslider(id) {
            confirmDestroy('/mobile/admin/slider', id)
        }
    </script>

@endsection
