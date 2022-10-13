@extends('cms.parent')

@section('titel', 'Product')
@section('page-large-name', 'Product')
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
                            <h3 class="card-title">Count : {{ $product->count() }}</h3>
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
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        {{-- <th>Info</th> --}}
                                        <th>Color</th>
                                        <th>Quantity</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Setting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($product as $data)
                                        <tr>
                                            {{-- <td>{{ $data->id }}.</td> --}}
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>
                                                <img class="direct-chat-img" height="60" width="60"
                                                    src="{{ Storage::url('products/' . $data->image) }}"
                                                    alt="message user image">
                                            </td>
                                            <td>{{ $data->name_en }}</td>
                                            <td>{{ $data->name_ar }}</td>
                                            <td>{{ $data->type->name_en }}</td>
                                            <td> <span class="badge bg-info">{{ $data->price }} /$</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge
                                                @if ($data->discount) bg-success
                                                @else bg-danger @endif">{{ $data->visibility_status }}</span>
                                            </td>
                                            {{-- <td>
                                                {{ $data->info }}
                                            </td> --}}
                                            <td>
                                                <span
                                                    class="badge
                                                    @if ($data->color == 'Black') bg-black
                                                    @elseif ($data->color == 'White') bg-white
                                                    @elseif ($data->color == 'Gray') bg-gray
                                                    @elseif ($data->color == 'NavyBlue') bg-navy
                                                    @elseif ($data->color == 'Pink') bg-pink
                                                    @elseif ($data->color == 'Orange') bg-orange @endif">{{ $data->color }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">({{ $data->quantity }})Product/s</span>
                                            </td>
                                            <td>{{ $data->created_at->format('y-m-d H:ma') }}</td>
                                            <td>{{ $data->updated_at->format('y-m-d H:ma') }}</td>
                                            @canany(['Update-Product', 'Delete-Product'])
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('product.edit', $data->id) }}" class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if ($data->trashed())
                                                            <a onclick="destroyProduct({{ $data->id }})"
                                                                class="btn btn-warning">
                                                                <i class="fas fa-trash-restore"></i>
                                                            </a>
                                                        @else
                                                            <a onclick="destroyProduct({{ $data->id }})"
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
                                            <td colspan="13"> No Data </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                {{-- {{ $product->links() }} --}}

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
        function destroyProduct(id) {
            confirmDestroy('/mobile/admin/product', id)
        }
    </script>

@endsection
