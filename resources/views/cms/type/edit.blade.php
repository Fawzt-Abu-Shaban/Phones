@extends('cms.parent')

@section('titel', 'Type')
@section('page-large-name', 'Type')
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
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Type</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="name_en">Name EN</label>
                                    <input type="text" name="name_en" value="{{ old('name_en', $type->name_en) }}"
                                        class="form-control" id="name_en" placeholder="Name EN">
                                </div>

                                <div class="form-group">
                                    <label for="name_ar">Name ar</label>
                                    <input type="text" name="name_ar" value="{{ old('name_ar', $type->name_ar) }}"
                                        class="form-control" id="name_ar" placeholder="Name AR">
                                </div>

                                <div class="form-group">
                                    <label for="bio">Bio</label>
                                    <input type="text" placeholder="Bio" value="{{ old('bio', $type->bio) }}"
                                        name="bio" class="form-control" id="bio">
                                </div>

                                <div class="form-group">
                                    <label>Categories</label>
                                    <select class="form-control categories" id="category_id" style="width: 100%;">
                                        <option value="{{ $type->category->id }}" selected disabled>
                                            {{ $type->category->name_en }}</option>
                                        @foreach ($category as $categories)
                                            <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_visible"
                                            @if ($type->is_visible) checked @endif>
                                        <label class="custom-control-label" for="is_visible">Visible</label>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="updateItem({{ $type->id }})"
                                    class="btn btn-primary">Update</button>
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
        $('.categories').select2({
            theme: 'bootstrap4'
        })
        $('.colors').select2({
            theme: 'bootstrap4'
        })

        function updateItem(id) {
            let data = {
                name_en: document.getElementById('name_en').value,
                name_ar: document.getElementById('name_ar').value,
                bio: document.getElementById('bio').value,
                category_id: document.getElementById('category_id').value,
                is_visible: document.getElementById('is_visible').checked,
            }
            update('/mobile/admin/type', id, data, '/mobile/admin/type')
        }
    </script>

@endsection
