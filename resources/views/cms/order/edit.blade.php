@extends('cms.parent')

@section('titel', 'Order')
@section('page-large-name', 'Order')
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
                            <h3 class="card-title">Update Order</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form method="POST">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" value="{{ old('name', $order->name) }}"
                                        class="form-control" id="name" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" value="{{ old('address', $order->address) }}"
                                        class="form-control" id="address" placeholder="Address">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="tel" name="phone" value="{{ old('phone', $order->phone) }}"
                                        class="form-control" id="phone" placeholder="Phone">
                                </div>

                                <div class="form-group">
                                    <label>Payment Type</label>
                                    <select id="payment_type" class="form-control payment_type" style="width: 100%;">
                                        <option value="{{ $order->payment_type }}" selected>{{ $order->payment_type }}
                                        </option>
                                        <option value="FromStore">From Store</option>
                                        <option value="Delivery">Delivery</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select id="status" class="form-control status" style="width: 100%;">
                                        <option value="{{ $order->status }}" selected>{{ $order->status }}</option>
                                        <option value="Processing">Processing</option>
                                        <option value="Waiting">Waiting</option>
                                        <option value="Delivered">Delivered</option>
                                        <option value="Combleted">Combleted</option>
                                        <option value="Canceled">Canceled</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="updateItem({{ $order->id }})"
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
        $('.payment_type').select2({
            theme: 'bootstrap4'
        })
        $('.status').select2({
            theme: 'bootstrap4'
        })

        function updateItem(id) {
            let data = {
                name: document.getElementById('name').value,
                address: document.getElementById('address').value,
                phone: document.getElementById('phone').value,
                payment_type: document.getElementById('payment_type').value,
                status: document.getElementById('status').value,
            }
            update('/mobile/admin/orders', id, data, '/mobile/admin/orders')
        }
    </script>

@endsection
