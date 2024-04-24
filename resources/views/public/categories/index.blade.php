@extends('public._layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('public/_components/breadcrumb')

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">DataTable with default features</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div id="example1_filter" class="dataTables_filter"><label>Search:<input
                                                        type="search" class="form-control form-control-sm" placeholder=""
                                                        aria-controls="example1"></label></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="example1"
                                                class="table table-bordered table-striped dataTable dtr-inline"
                                                aria-describedby="example1_info">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Image</th>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Created at</th>
                                                        <th>Updated at</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (!empty($categories))
                                                        @foreach ($categories as $category)
                                                            <tr>
                                                                <td>
                                                                    {{ $category['categoryId'] }}
                                                                </td>
                                                                <td>
                                                                    @if ($category['imageDTO'])
                                                                        <img src="{{ $category['imageDTO']['address'] }}"
                                                                            alt="">
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    {{ $category['name'] }}
                                                                </td>
                                                                <td>
                                                                    <textarea name="" id="" cols="30" rows="10">
                                                                    {{ $category['description'] }}
                                                                </textarea>
                                                                </td>
                                                                <td>
                                                                    {{ RECORD_STATUS[$category['status']] }}
                                                                </td>
                                                                <td>
                                                                    {{ $category['createdAt'] }}
                                                                </td>
                                                                <td>
                                                                    {{ $category['updatedAt'] }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <div class="dataTables_info" id="example1_info" role="status"
                                                aria-live="polite">Showing 1 to 10 of 57 entries</div>
                                        </div>
                                        <div class="col-sm-12 col-md-7">
                                            <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                                <ul class="pagination">
                                                    <li class="paginate_button page-item previous disabled"
                                                        id="example1_previous"><a href="#" aria-controls="example1"
                                                            data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                                                    </li>
                                                    <li class="paginate_button page-item active"><a href="#"
                                                            aria-controls="example1" data-dt-idx="1" tabindex="0"
                                                            class="page-link">1</a></li>
                                                    <li class="paginate_button page-item "><a href="#"
                                                            aria-controls="example1" data-dt-idx="2" tabindex="0"
                                                            class="page-link">2</a></li>
                                                    <li class="paginate_button page-item "><a href="#"
                                                            aria-controls="example1" data-dt-idx="3" tabindex="0"
                                                            class="page-link">3</a></li>
                                                    <li class="paginate_button page-item "><a href="#"
                                                            aria-controls="example1" data-dt-idx="4" tabindex="0"
                                                            class="page-link">4</a></li>
                                                    <li class="paginate_button page-item "><a href="#"
                                                            aria-controls="example1" data-dt-idx="5" tabindex="0"
                                                            class="page-link">5</a></li>
                                                    <li class="paginate_button page-item "><a href="#"
                                                            aria-controls="example1" data-dt-idx="6" tabindex="0"
                                                            class="page-link">6</a></li>
                                                    <li class="paginate_button page-item next" id="example1_next"><a
                                                            href="#" aria-controls="example1" data-dt-idx="7"
                                                            tabindex="0" class="page-link">Next</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

<!-- Main JS file -->
@push('scripts')
    <script>

    </script>
@endPush
