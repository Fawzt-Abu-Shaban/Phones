@extends('cms.parent')

@section('titel', 'Product')
@section('page-large-name', 'Product')
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

                    @if (session('msg'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Success!</h5>
                            {{ session()->get('msg') }}
                        </div>
                    @endif

                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Product</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form {{-- method="POST" action="{{ route('product.update', $product->id) }}" --}}
                             enctype="multipart/form-data" id="reset_form">
                            @csrf
                            {{-- @method('put') --}}

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="name_en">Name EN</label>
                                    <input type="text" name="name_en" value="{{ old('name_en', $product->name_en) }}"
                                        class="form-control" id="name_en" placeholder="Name EN">
                                </div>

                                <div class="form-group">
                                    <label for="name_ar">Name AR</label>
                                    <input type="text" name="name_ar" value="{{ old('name_ar', $product->name_ar) }}"
                                        class="form-control" id="name_ar" placeholder="Name AR">
                                </div>

                                <div class="form-group">
                                    <label>Types</label>
                                    <select class="form-control types" name="type_id" id="type_id" style="width: 100%;">
                                        {{-- <option value="{{ $product->type->id }}" selected disabled>
                                            {{ $product->type->name }}
                                        </option> --}}
                                        @foreach ($type as $types)
                                            <option value="{{ $types->id }}"
                                                @if ($types->id == $product->type_id) selected @endif>
                                                {{ $types->name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="info">Info</label>
                                    <input type="text" name="info" placeholder="Info"
                                        value="{{ old('bio', $product->info) }}" class="form-control" id="info">
                                </div>

                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input" id="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="album">Album</label>
                                    <div class="custom-file">
                                        <input type="file" multiple name="album[]" class="custom-file-input"
                                            id="album[]">
                                        <label class="custom-file-label" for="album[]">Choose file</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                        class="form-control" id="price" placeholder="Price">
                                </div>

                                <div class="form-group">
                                    <label>Colors</label>
                                    <select id="color" name="color" class="form-control colors" style="width: 100%;">
                                        <option value="{{ $product->color }}" selected>{{ $product->color }}</option>
                                        <option value="Black">Black</option>
                                        <option value="White">White</option>
                                        <option value="Gray">Gray</option>
                                        <option value="NavyBlue">NavyBlue</option>
                                        <option value="Pink">Pink</option>
                                        <option value="Orange">Orange</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" placeholder="Quantity"
                                        value="{{ old('quantity', $product->quantity) }}" class="form-control"
                                        id="quantity">
                                </div>

                                <div class="col-md-6">
                                    <div class="card card-warning collapsed-card">
                                        <div class="card-header">
                                            <h3 class="card-title">Discount</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <!-- /.card-tools -->
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body" style="display: none;">
                                            <div class="form-group">
                                                <label for="discount">Discount</label>
                                                <input type="number" name="discount"
                                                    value="{{ old('discount', $product->discount) }}"
                                                    class="form-control" id="discount" placeholder="Discount %">
                                            </div>
                                            <div class="form-group">
                                                <label for="old_price">Old Price</label>
                                                <input type="number" name="old_price"
                                                    value="{{ old('old_price', $product->old_price) }}"
                                                    class="form-control" id="old_price" placeholder="Old-Price">
                                            </div>
                                        </div>

                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="updateItem()" class="btn btn-primary">Update</button>
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
        $('.types').select2({
            theme: 'bootstrap4'
        })
        $('.colors').select2({
            theme: 'bootstrap4'
        })

        function updateItem() {

            let formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('name_en', document.getElementById('name_en').value);
            formData.append('name_ar', document.getElementById('name_ar').value);
            formData.append('type_id', document.getElementById('type_id').value);
            formData.append('info', document.getElementById('info').value);
            formData.append('price', document.getElementById('price').value);
            formData.append('color', document.getElementById('color').value);
            formData.append('quantity', document.getElementById('quantity').value);
            formData.append('discount', document.getElementById('discount').value);
            formData.append('old_price', document.getElementById('old_price').value);
            if (document.getElementById('image').files[0] != undefined) {
                formData.append('image', document.getElementById('image').files[0]);
            }
            if (document.getElementById('album[]').files[0] != undefined) {
                formData.append('album', document.getElementById('album[]').files[0]);
            }

            axios.post('/mobile/admin/product/{{ $product->id }}', formData)
                .then(function(response) {
                    // handle success 2xx
                    console.log(response);
                    if ('/mobile/admin/product' != undefined) {
                        window.location.href = '/mobile/admin/product';
                    } else {
                        toastr.success(response.data.message)
                    }
                })
                .catch(function(error) {
                    // handle error 4xx , 5xx
                    console.log(error);
                    toastr.error(error.response.data.message)

                });
        }
    </script>

@endsection
