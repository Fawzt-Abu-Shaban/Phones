@extends('cms.parent')

@section('titel', 'DashBoard')
@section('page-large-name', 'DashBoard')
@section('page-small-name', 'DashBoard')

@section('style')

@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $productCount }}</h3>

                            <p>Products</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('product.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>

                            <p>Bounce Rate</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $userCount }}</h3>

                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('user.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>

                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div><!-- /.container-fluid -->
        <div class="card collapsed-card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Latest Orders</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0" style="display: none;">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Item</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Invoice_Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order as $data)
                                <tr>
                                    <td><a href="{{ route('orders.show', $data->id) }}">OR{{ $data->id }}</a></td>
                                    <td>{{ $data->cart }}</td>
                                    <td>
                                        <div class="sparkbar" data-color="#00a65a" data-height="20">
                                            {{ $data->total }}
                                        </div>
                                    </td>

                                    <td>
                                        <span
                                            class="badge
                                                    @if ($data->status == 'Waiting') bg-warning
                                                    @elseif ($data->status == 'Processing') bg-primery
                                                    @elseif ($data->status == 'Delivered') bg-success
                                                    @elseif ($data->status == 'Combleted') bg-success
                                                    @elseif ($data->status == 'Canceled') bg-danger @endif">{{ $data->status }}</span>
                                    </td>
                                    <td>
                                        <div class="sparkbar" data-color="#00a65a" data-height="20">
                                            {{ $data->payment_type }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="sparkbar" data-color="#00a65a" data-height="20">
                                            {{ $data->invoice_number }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix" style="display: none;">
                {{-- <a href="{{ route('orders.create') }}" class="btn btn-sm btn-info float-left">Place New Order</a> --}}
                {{-- <a href="{{ route('orders.index') }}" class="btn btn-sm btn-secondary float-right">Invoice Printing</a> --}}
            </div>
            <!-- /.card-footer -->
        </div>
    </div>


@endsection

@section('script')

@endsection
