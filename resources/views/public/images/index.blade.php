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
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Tổng hợp tất cả hình ảnh
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-2 d-flex justify-content-end">
                                    <div class="float-right">
                                        <select class="custom-select" style="width: auto" data-sortOrder>
                                            <option value="index">Sort by Position</option>
                                            <option value="sortData">
                                                Sort by Custom Data
                                            </option>
                                        </select>
                                        <div class="btn-group">
                                            <a class="btn btn-default" href="javascript:void(0)" data-sortAsc>
                                                Ascending
                                            </a>
                                            <a class="btn btn-default" href="javascript:void(0)" data-sortDesc>
                                                Descending
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success btn-block"><i
                                                    class="fa fa-plus"></i> Thêm mới</button>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="filter-container p-0 row">
                                        @if (!empty($images))
                                            @foreach ($images as $image)
                                                <div class="filtr-item col-sm-2" data-category="1" data-sort="white sample">
                                                    <a href="images/delete/{{ $image['imageId'] }}"
                                                        onclick="return confirm('Bạn có chắc là muốn xóa ảnh này không?');"
                                                        class="btn btn-outline-danger btn-delete-image">
                                                        <i class="fa fa-times-circle"></i>
                                                    </a>
                                                    <a href="{{ $image['address'] }}" data-toggle="lightbox"
                                                        data-title="{{ $image['caption'] }}">
                                                        <img src="{{ url($image['address'])}}" class="img-fluid mb-2"
                                                            alt="{{ $image['caption'] }}" />
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-info">
                                                <strong>Trống!</strong> Hiện chưa có ảnh nào.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

<!-- Main JS file -->
@push('scripts')
    <script src="{{ asset('assets/js/upload_file.js') }}"></script>
@endPush
