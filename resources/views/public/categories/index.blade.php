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
                                            <table id="example1" class="table table-bordered table-striped">
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
                                                                        <img style="max-width: 300px; height: auto; object-fit:contain"
                                                                            src="{{ $category['imageDTO']['address'] }}"
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
                                        {{ $categories->links() }}
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
    <script></script>
@endPush
