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
            <h6 class="m-0 font-weight-bold text-primary float-left">Review Lists</h6>
        </div>
        <div class="card-body">
            <div class="search">
                <form action="#" id="search-form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="reviewId">ID</label>
                                <input type="text" class="form-control" name="reviewId" id="reviewId" value=""
                                    placeholder="Enter ID" data-toggle="search-box" data-column="reviewId"
                                    data-operator="equal" data-fieldtype="integer">
                            </div>
                            <div class="col-md-3">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value=""
                                    placeholder="Enter title" data-toggle="search-box" data-column="title"
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
                            <th>Review By</th>
                            <th>Product</th>
                            <th>Review</th>
                            <th>Rate</th>
                            <th>Date</th>
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
                let table = DATATABLE.init("#dataTable", '/admin/reviews/ajax-get-reviews', {
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
                            name: 'reviewId',
                            target: 0,
                            data: 'reviewId',
                            orderable: true,
                            searchable: true
                        },
                        {
                            name: 'user',
                            target: 1,
                            data: 'user.name',
                            defaultContent: '',
                            orderable: true,
                            searchable: true
                        },
                        {
                            name: 'product',
                            target: 2,
                            data: 'product.title',
                            defaultContent: '',
                            orderable: true,
                            searchable: true
                        },
                        {
                            name: 'review',
                            target: 3,
                            data: 'review',
                            orderable: false,
                            searchable: false
                        },
                        {
                            name: 'rate',
                            target: 4,
                            data: 'rate',
                            orderable: false,
                            searchable: false
                        },
                        {
                            name: 'createdAt',
                            target: 5,
                            data: 'createdAt',
                            orderable: false,
                            searchable: false
                        },
                        {
                            name: 'status',
                            target: 6,
                            data: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            name: 'action',
                            target: 7,
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
