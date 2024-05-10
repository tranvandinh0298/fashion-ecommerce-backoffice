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
            <h6 class="m-0 font-weight-bold text-primary float-left">Product Lists</h6>
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Product</a>
        </div>
        <div class="card-body">
            <div class="search">
                <form action="#" id="search-form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="productId">ID</label>
                                <input type="text" class="form-control" name="productId" id="productId" value=""
                                    placeholder="Enter ID" data-toggle="search-box" data-column="productId"
                                    data-operator="equal" data-fieldtype="integer">
                            </div>
                            <div class="col-md-3">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value=""
                                    placeholder="Enter title" data-toggle="search-box" data-column="title"
                                    data-operator="like" data-fieldtype="integer">
                            </div>
                            <div class="col-md-3">
                                <label for="categoryId">Category</label>
                                <select name="categoryId" class="form-control" id="categoryId" data-toggle="search-box"
                                    data-column="categoryId" data-operator="equal" data-fieldtype="string">
                                    <option value="">all</option>
                                    @if (!empty($categories))
                                        @foreach ($categories as $category)
                                            <option value="{{ $category['categoryId'] }}">{{ $category['title'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="childCategoryId">Child category</label>
                                <select name="childCategoryId" class="form-control" id="childCategoryId"
                                    data-toggle="search-box" data-column="childCategoryId" data-operator="equal"
                                    data-fieldtype="string">
                                    <option value="">all</option>
                                    @if (!empty($childCategories))
                                        @foreach ($childCategories as $category)
                                            <option value="{{ $category['categoryId'] }}">{{ $category['title'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="brandId">Brand</label>
                                <select name="brandId" class="form-control" id="brandId" data-toggle="search-box"
                                    data-column="brandId" data-operator="equal" data-fieldtype="string">
                                    <option value="">all</option>
                                    @if (!empty($brands))
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand['brandId'] }}">{{ $brand['title'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="isFeatured">isFeatured</label>
                                <select name="isFeatured" class="form-control" id="isFeatured" data-toggle="search-box"
                                    data-column="isFeatured" data-operator="equal" data-fieldtype="integer">
                                    <option value="">all</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="condition">Condition</label>
                                <select name="condition" class="form-control" id="condition" data-toggle="search-box"
                                    data-column="condition" data-operator="equal" data-fieldtype="string">
                                    <option value="">all</option>
                                    <option value="default">Default</option>
                                    <option value="new">New</option>
                                    <option value="hot">Hot</option>
                                </select>
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
                            <th>Featured</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Size</th>
                            <th>Condition</th>
                            <th>Brand</th>
                            <th>Stock</th>
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
    </div><!-- Visit 'codeastro' for more projects -->
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
                let table = DATATABLE.init("#dataTable", '/admin/products/ajax-get-products', {
                    columnDefs: [{
                        targets: '_all',
                        orderable: false,
                        searchable: false
                    }],
                    columns: [{
                            name: 'productId',
                            target: 0,
                            data: 'productId',
                            orderable: true,
                        },
                        {
                            name: 'title',
                            target: 1,
                            data: 'title',
                            orderable: true,
                        },
                        {
                            name: 'category',
                            target: 2,
                            data: 'category.title',
                            orderable: true,
                            defaultContent: '',
                        },
                        {
                            name: 'isFeatured',
                            target: 3,
                            data: 'isFeatured',
                        },
                        {
                            name: 'price',
                            target: 4,
                            data: 'price',
                            orderable: true,
                        },
                        {
                            name: 'discount',
                            target: 5,
                            data: 'discount',
                            orderable: true,
                        },
                        {
                            name: 'size',
                            target: 6,
                            data: 'size',
                            orderable: true,
                        },
                        {
                            name: 'condition',
                            target: 7,
                            data: 'condition',
                            orderable: true,
                        },
                        {
                            name: 'brand',
                            target: 8,
                            data: 'brand.title',
                            orderable: true,
                            defaultContent: '',
                        },
                        {
                            name: 'stock',
                            target: 9,
                            data: 'stock',
                            orderable: true,
                        },
                        {
                            name: 'photo',
                            target: 10,
                            data: 'photo',
                        },
                        {
                            name: 'status',
                            target: 11,
                            data: 'status',
                        },
                        {
                            name: 'action',
                            target: 12,
                            data: 'action',
                        }
                    ]
                });
            }
        });
    </script>
@endpush
