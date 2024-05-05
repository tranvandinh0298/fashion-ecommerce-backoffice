@extends('admin.layouts.app')
@section('title', 'Ecommerce Laravel || Banner Page')
@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('admin.components.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">Banners List</h6>
            <a href="{{ route('banners.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Banner</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="banner-dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        /* div.dataTables_wrapper div.dataTables_paginate {
                                                                                                                                    display: none;
                                                                                                                                } */

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
            const dataTable = document.getElementById("banner-dataTable");
            if (!!dataTable) {
                DATATABLE.init("#banner-dataTable", '/admin/banners/ajax-get-banners', {
                    processing: true,
                    serverSide: true,
                    paginate: true,
                    pageLength: 10,
                    bInfo: true,
                    searching: true,
                    bSort: true,
                    bLengthChange: true,
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
                            name: 'bannerId',
                            target: 0,
                            data: 'bannerId',
                            orderable: true,
                            searchable: true
                        },
                        {
                            name: 'title',
                            target: 1,
                            data: 'title',
                            orderable: true,
                            searchable: true
                        },
                        {
                            name: 'slug',
                            target: 2,
                            data: 'slug',
                            orderable: true,
                            searchable: true
                        },
                        {
                            name: 'photo',
                            target: 3,
                            data: 'photo',
                            orderable: false,
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
                    ],
                    initComplete: function() {
                        // var table = this;
                    //     $(this.api().table().container()).on('click', 'input[type="search"]',
                    // function() {
                    //         table.order(
                    //     []); // Disable sorting when clicking into the search box
                    //     });

                        // // Add individual column search fields
                        // $('#banner-dataTable thead th').each(function(index) {
                        //     if ($.inArray(index, [0, 1, 2, 3]) !== -1) {
                        //         var title = $(this).text();
                        //         if (title !== '') {
                        //             $(this).html(
                        //                 '<input type="text" class="form-control" placeholder="' +
                        //                 title +
                        //                 '" />');
                        //         }
                        //     }
                        // });

                        // // Apply individual column searching
                        // $('#banner-dataTable thead input').on('keyup change', function(index) {
                        //     if ($.inArray(index, [0, 1, 2, 3]) !== -1) {
                        //         var index = $(this).parent().index();
                        //         $('#banner-dataTable').DataTable().column(index).search(this
                        //                 .value)
                        //             .draw();
                        //     }
                        // });
                    },
                });
            }
        })
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            });
        });
    </script>
@endpush
