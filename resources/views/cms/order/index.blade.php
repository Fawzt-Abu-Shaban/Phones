@extends('cms.parent')

@section('titel', 'Order')
@section('page-large-name', 'Order')
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
                            <h3 class="card-title">Count : {{ $order->count() }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Item</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Invoice_Number</th>
                                        <th>Created_At</th>
                                        <th>Updated_At</th>
                                        <th>Setting</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($order as $data)
                                        <tr>
                                            <td>
                                                <a href="{{ route('orders.show', $data->id) }}">OR{{ $data->id }}</a>
                                            </td>

                                            <td>{{ $data->user->email }}</td>

                                            <td>
                                                <div class="sparkbar" data-color="#00a65a" data-height="20">
                                                    {{ $data->total }} $
                                                </div>
                                            </td>

                                            <td>
                                                <span
                                                    class="badge
                                                    @if ($data->status == 'Waiting') bg-warning
                                                    @elseif ($data->status == 'Processing') bg-primary
                                                    @elseif ($data->status == 'Delivered') bg-success
                                                    @elseif ($data->status == 'Combleted') bg-success
                                                    @elseif ($data->status == 'Canceled') bg-danger @endif">{{ $data->status }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge
                                                    @if ($data->payment_type == 'FromStore') bg-black
                                                    @elseif ($data->payment_type == 'Delivery') bg-gray @endif">{{ $data->payment_type }}</span>
                                            </td>
                                            <td>
                                                <div class="sparkbar" data-color="#00a65a" data-height="20">
                                                    {{ $data->invoice_number }}
                                                </div>
                                            </td>
                                            <td>{{ $data->created_at->format('y-m-d H:ma') }}</td>
                                            <td>{{ $data->updated_at->format('y-m-d H:ma') }}</td>
                                            @canany(['Update-Order'])
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('orders.edit', $data->id) }}" class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        {{-- <a class="btn btn-warning" href="{{ route('notify', $data->id) }}">
                                                            Send Notification
                                                            <i class="fas fa-solid fa-bell"></i>
                                                        </a> --}}
                                                    </div>
                                                </td>
                                            @endcanany

                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="10"> No Data </td>
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

    {{-- <script>
        function destroyType(id, reference) {
            confirmDestroy('/mobile/admin/orders', id, reference)
        }
    </script> --}}

@endsection
