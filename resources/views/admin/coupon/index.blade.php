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
            <h6 class="m-0 font-weight-bold text-primary float-left">Coupon List</h6>
            <a href="{{ route('coupons.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Coupon</a>
        </div>
        <div class="card-body">
            <div class="search">
                <form action="#" id="search-form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="couponId">ID</label>
                                <input type="text" class="form-control" name="couponId" id="couponId" value=""
                                    placeholder="Enter ID" data-toggle="search-box" data-column="couponId"
                                    data-operator="equal" data-fieldtype="integer">
                            </div>
                            <div class="col-md-3">
                                <label for="code">Coupon Code</label>
                                <input type="text" class="form-control" name="code" id="code" value=""
                                    placeholder="Enter code" data-toggle="search-box" data-column="code"
                                    data-operator="like" data-fieldtype="integer">
                            </div>
                            <div class="col-md-3">
                                <label for="type">Type</label>
                                <select name="type" class="form-control" id="type" data-toggle="search-box"
                                    data-column="type" data-operator="equal" data-fieldtype="string">
                                    <option value="">all</option>
                                    <option value="fixed">fixed</option>
                                    <option value="percent">percent</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="value">Value</label>
                                <input type="text" class="form-control" name="value" id="value" value=""
                                    placeholder="Enter value" data-toggle="search-box" data-column="value"
                                    data-operator="equal" data-fieldtype="integer">
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
                            <th>Coupon Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

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
                let table = DATATABLE.init("#dataTable", '/admin/coupons/ajax-get-coupons', {
                    columnDefs: [{
                        targets: '_all',
                        orderable: false,
                        searchable: false
                    }, {
                        targets: [0, 1, 2, 3],
                        orderable: true,
                        searchable: true,
                    }],
                    columns: [{
                            name: 'couponId',
                            target: 0,
                            data: 'couponId',
                            orderable: true,
                            searchable: true
                        },
                        {
                            name: 'code',
                            target: 1,
                            data: 'code',
                            orderable: true,
                            searchable: true
                        },
                        {
                            name: 'type',
                            target: 2,
                            data: 'type',
                            orderable: true,
                            searchable: true
                        },
                        {
                            name: 'value',
                            target: 3,
                            data: 'value',
                            orderable: true,
                            searchable: false
                        },
                        {
                            name: 'status',
                            target: 4,
                            data: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            name: 'action',
                            target: 5,
                            data: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            }
        })
    </script>
@endpush
