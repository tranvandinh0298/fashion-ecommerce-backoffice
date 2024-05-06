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
            <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Category</a>
        </div>
        <div class="card-body">
            <div class="search">
                <form action="#" id="search-form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="bannerId">ID</label>
                                <input type="text" class="form-control" name="bannerId" id="bannerId" value=""
                                    placeholder="Enter ID" data-toggle="search-box" data-column="bannerId"
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
                                    data-column="status" data-operator="equal" data-fieldtype="integer">
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
                            <th>Slug</th>
                            <th>Is Parent</th>
                            <th>Parent Category</th>
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
                            <th>Is Parent</th>
                            <th>Parent Category</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            {{-- <div class="table-responsive">
                @if (count($categories) > 0)
                    <table class="table table-bordered table-hover" id="banner-dataTable" width="100%" cellspacing="0">
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
                        <tbody>

                            @foreach ($categories as $category)
                                @php
                                @endphp
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->title }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->is_parent == 1 ? 'Yes' : 'No' }}</td>
                                    <td>
                                        {{ $category->parent_info->title ?? '' }}
                                    </td>
                                    <td>
                                        @if ($category->photo)
                                            <img src="{{ $category->photo }}" class="img-fluid" style="max-width:80px"
                                                alt="{{ $category->photo }}">
                                        @else
                                            <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid"
                                                style="max-width:80px" alt="avatar.png">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($category->status == 'active')
                                            <span class="badge badge-success">{{ $category->status }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ $category->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('category.edit', $category->id) }}"
                                            class="btn btn-primary btn-sm float-left mr-1"
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('category.destroy', [$category->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $category->id }}
                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h6 class="text-center">No Categories found!!! Please create Category</h6>
                @endif
            </div> --}}
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
            const dataTable = document.getElementById("banner-dataTable");
            if (!!dataTable) {
                let table = DATATABLE.init("#dataTable", '/admin/categories/ajax-get-categories', {
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
                    ]
                });
            }
        })
    </script>
@endpush
