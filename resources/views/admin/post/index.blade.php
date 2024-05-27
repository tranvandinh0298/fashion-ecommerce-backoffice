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
            <h6 class="m-0 font-weight-bold text-primary float-left">Post Lists</h6>
            <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Post</a>
        </div>
        <div class="card-body">
            <div class="search">
                <form action="#" id="search-form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="postId">ID</label>
                                <input type="text" class="form-control" name="postId" id="postId" value=""
                                    placeholder="Enter ID" data-toggle="search-box" data-column="postId"
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
                            <th>Title</th>
                            <th>Category</th>
                            <th>Tag</th>
                            <th>Author</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Visit 'codeastro' for more projects -->
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
                let table = DATATABLE.init("#dataTable", '/admin/posts/ajax-get-posts', {
                    columnDefs: [{
                        targets: '_all',
                        orderable: false,
                        searchable: false
                    }, {
                        targets: [0, 1, 2],
                        orderable: true,
                        searchable: true,
                    }],
                    columns: [{
                            name: 'postId',
                            target: 0,
                            data: 'postId',
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
                            name: 'postCategory',
                            target: 2,
                            data: 'postCategory.title',
                            defautContent: "",
                            orderable: true,
                            searchable: true
                        },
                        {
                            name: 'tags',
                            target: 3,
                            data: 'tags',
                            orderable: true,
                            searchable: true
                        },
                        {
                            name: 'user',
                            target: 4,
                            data: 'user.name',
                            defautContent: "",
                            orderable: true,
                            searchable: true
                        },
                        {
                            name: 'photo',
                            target: 5,
                            data: 'photo',
                            orderable: true,
                            searchable: true
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