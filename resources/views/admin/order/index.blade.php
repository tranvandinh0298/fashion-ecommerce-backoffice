@extends('admin.layouts.app')

@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('admin.components.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">Order Lists</h6>
        </div>
        <div class="card-body">
            <div class="search">
                <form action="#" id="search-form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="categoryId">ID</label>
                                <input type="text" class="form-control" name="categoryId" id="categoryId" value=""
                                    placeholder="Enter ID" data-toggle="search-box" data-column="categoryId"
                                    data-operator="equal" data-fieldtype="integer">
                            </div>
                            <div class="col-md-3">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value=""
                                    placeholder="Enter title" data-toggle="search-box" data-column="title"
                                    data-operator="like" data-fieldtype="integer">
                            </div>
                            <div class="col-md-3">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" name="slug" id="slug" value=""
                                    placeholder="Enter slug" data-toggle="search-box" data-column="slug"
                                    data-operator="like" data-fieldtype="integer">
                            </div>
                            <div class="col-md-3">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" id="status" data-toggle="search-box"
                                    data-column="status" data-operator="equal" data-fieldtype="string">
                                    <option value="">all</option>
                                    <option value="active">active</option>
                                    <option value="inactive">inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Qty.</th>
                            <th>Charge</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($orders as $order)
                            @php
                                $shipping_charge = DB::table('shippings')
                                    ->where('id', $order->shipping_id)
                                    ->pluck('price');
                            @endphp
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>
                                    @foreach ($shipping_charge as $data)
                                        $ {{ number_format($data, 2) }}
                                    @endforeach
                                </td>
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    @if ($order->status == 'new')
                                        <span class="badge badge-primary">NEW</span>
                                    @elseif($order->status == 'process')
                                        <span class="badge badge-warning">Processing</span>
                                    @elseif($order->status == 'delivered')
                                        <span class="badge badge-success">Delivered</span>
                                    @else
                                        <span class="badge badge-danger">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('order.show', $order->id) }}"
                                        class="btn btn-warning btn-sm float-left mr-1"
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                        title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('order.edit', $order->id) }}"
                                        class="btn btn-primary btn-sm float-left mr-1"
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                        title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{ route('order.destroy', [$order->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm dltBtn" data-id={{ $order->id }}
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        .dataTables_filter {
            display: none;
        }

        .zoom {
            transition: transform .2s;
            /* Animation */
        }

        .zoom:hover {
            transform: scale(3.2);
        }
    </style>
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('assets/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/admin/js/demo/datatables-demo.js') }}"></script>
    <script>
        $(document).ready(function() {
            const dataTable = document.getElementById("dataTable");
            if (!!dataTable) {
                let table = DATATABLE.init("#dataTable", '/admin/orders/ajax-get-orders', {
                    columnDefs: [{
                        targets: '_all',
                        orderable: false,
                        searchable: false
                    }],
                    columns: [{
                            name: 'orderId',
                            target: 0,
                            data: 'orderId',
                            orderable: true,
                        },
                        {
                            name: 'orderNo',
                            target: 1,
                            data: 'orderNo',
                            orderable: true,
                        },
                        {
                            name: 'name',
                            target: 2,
                            data: 'name',
                            orderable: true,
                        },
                        {
                            name: 'email',
                            target: 3,
                            data: 'email',
                        },
                        {
                            name: 'quantity',
                            target: 4,
                            data: 'quantity',
                        },
                        {
                            name: 'charge',
                            target: 5,
                            data: 'shipping.price',
                        },
                        {
                            name: 'total',
                            target: 6,
                            data: 'total',
                        },
                        {
                            name: 'status',
                            target: 7,
                            data: 'status',
                        },
                        {
                            name: 'action',
                            target: 8,
                            data: 'action',
                        }
                    ]
                });
            }
        });
    </script>
@endpush
