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
            <h6 class="m-0 font-weight-bold text-primary float-left">Category Lists</h6>
            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Category</a>
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
                            <div class="col-md-3">
                                <label for="parentCategoryId">Parent category</label>
                                <select name="parentCategoryId" class="form-control" id="parentCategoryId"
                                    data-toggle="search-box" data-column="parentCategoryId" data-operator="equal"
                                    data-fieldtype="string">
                                    <option value="">all</option>
                                    @if (!empty($parentCategories))
                                        @foreach ($parentCategories as $parentCategory)
                                            <option value="{{ $parentCategory['categoryId'] }}">
                                                {{ $parentCategory['title'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="category-dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Is Parent</th>
                            <th>Parent Category</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
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
            const dataTable = document.getElementById("category-dataTable");
            if (!!dataTable) {
                let table = DATATABLE.init("#category-dataTable", '/admin/categories/ajax-get-categories', {
                    columnDefs: [{
                        targets: '_all',
                        orderable: false,
                        searchable: false
                    }],
                    columns: [{
                            name: 'categoryId',
                            target: 0,
                            data: 'categoryId',
                            orderable: true,
                        },
                        {
                            name: 'title',
                            target: 1,
                            data: 'title',
                            orderable: true,
                        },
                        {
                            name: 'slug',
                            target: 2,
                            data: 'slug',
                            orderable: true,
                        },
                        {
                            name: 'isParent',
                            target: 3,
                            data: 'isParent',
                        },
                        {
                            name: 'parentCategory',
                            target: 4,
                            data: 'parentCategory.title',
                            defaultContent: '',
                            orderable: true,
                        },
                        {
                            name: 'photo',
                            target: 5,
                            data: 'photo',
                        },
                        {
                            name: 'status',
                            target: 6,
                            data: 'status',
                        },
                        {
                            name: 'action',
                            target: 7,
                            data: 'action',
                        }
                    ]
                });
            }
        });
    </script>
@endpush
