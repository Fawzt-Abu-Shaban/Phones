@extends('cms.parent')

@section('titel', 'Slider')
@section('page-large-name', 'Slider')
@section('page-small-name', 'Update')

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
                            <h3 class="card-title">Update Slider</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" id="reset_form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name_en">Name EN</label>
                                    <input type="text" value="{{ old('name_en', $slider->name_en) }}"
                                        class="form-control" id="name_en" placeholder="Name EN">
                                </div>

                                <div class="form-group">
                                    <label for="name_ar">Name AR</label>
                                    <input type="text" value="{{ old('name_ar', $slider->name_ar) }}"
                                        class="form-control" id="name_ar" placeholder="Name AR">
                                </div>

                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" value="{{ old('price', $slider->price) }}" class="form-control"
                                        id="price" placeholder="Price">
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

    <script>
        function updateItem() {

            let formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('name_en', document.getElementById('name_en').value);
            formData.append('name_ar', document.getElementById('name_ar').value);
            formData.append('price', document.getElementById('price').value);

            if (document.getElementById('image').files[0] != undefined) {
                formData.append('image', document.getElementById('image').files[0]);
            }

            axios.post('/mobile/admin/slider/{{ $slider->id }}', formData)
                .then(function(response) {
                    // handle success 2xx
                    console.log(response);
                    if ('/mobile/admin/slider' != undefined) {
                        window.location.href = '/mobile/admin/slider';
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
