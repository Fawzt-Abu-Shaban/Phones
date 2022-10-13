@extends('cms.parent')

@section('titel', 'Category')
@section('page-large-name', 'Category')
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
                            <h3 class="card-title">Update Category</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{ route('category.update', $category->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="name_en">Name EN</label>
                                    <input type="text" name="name_en" value="{{ old('name_en', $category->name_en) }}"
                                        class="form-control" id="name_en" placeholder="Name EN">
                                </div>

                                <div class="form-group">
                                    <label for="name_ar">Name AR</label>
                                    <input type="text" name="name_ar" value="{{ old('name_ar', $category->name_ar) }}"
                                        class="form-control" id="name_ar" placeholder="Name AR">
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="is_visible" class="custom-control-input" id="visible"
                                            @if ($category->is_visible) checked @endif>
                                        <label class="custom-control-label" for="visible">Visible</label>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
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

@endsection
