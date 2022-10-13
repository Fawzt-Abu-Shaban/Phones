@extends('cms.parent')

@section('titel', 'Slider')
@section('page-large-name', 'Slider')
@section('page-small-name', 'Create')

@section('style')

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
                            <h3 class="card-title">Create Slider</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="reset_form">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="name_en">Name EN</label>
                                    <input type="text" value="{{ old('name_en') }}" class="form-control" id="name_en"
                                        placeholder="Name EN">
                                </div>

                                <div class="form-group">
                                    <label for="name_ar">Name AR</label>
                                    <input type="text" value="{{ old('name_ar') }}" class="form-control" id="name_ar"
                                        placeholder="Name AR">
                                </div>

                                <div class="form-group">
                                    <label for="price">Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" value="{{ old('price') }}" class="form-control" id="price"
                                        placeholder="Price">
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="createItem()" class="btn btn-primary">Create</button>
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

    <script>
        function createItem() {

            let formData = new FormData();
            formData.append('name_en', document.getElementById('name_en').value);
            formData.append('name_ar', document.getElementById('name_ar').value);
            formData.append('price', document.getElementById('price').value);
            formData.append('image', document.getElementById('image').files[0]);

            store('/mobile/admin/slider', formData)
        }
    </script>
@endsection
