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
                                            <button type="button" class="btn btn-success btn-block"><i class="fa fa-plus"></i> Thêm mới</button>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="filter-container p-0 row">
                                        @if (!empty($images))
                                            @foreach ($images as $image)
                                                <div class="filtr-item col-sm-2" data-category="1" data-sort="white sample">
                                                    <a href="{{$image['address']}}"
                                                        data-toggle="lightbox" data-title="{{$image['caption']}}">
                                                        <img src="{{$image['address']}}"
                                                            class="img-fluid mb-2" alt="{{$image['caption']}}" />
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-info">
                                                <strong>Trống!</strong> Hiện chưa có ảnh nào.
                                            </div>
                                        @endif
                                        {{-- <div class="filtr-item col-sm-2" data-category="1" data-sort="white sample">
                                            <a href="https://via.placeholder.com/1200/FFFFFF.png?text=1"
                                                data-toggle="lightbox" data-title="sample 1 - white">
                                                <img src="https://via.placeholder.com/300/FFFFFF?text=1"
                                                    class="img-fluid mb-2" alt="white sample" />
                                            </a>
                                        </div>
                                        <div class="filtr-item col-sm-2" data-category="2, 4" data-sort="black sample">
                                            <a href="https://via.placeholder.com/1200/000000.png?text=2"
                                                data-toggle="lightbox" data-title="sample 2 - black">
                                                <img src="https://via.placeholder.com/300/000000?text=2"
                                                    class="img-fluid mb-2" alt="black sample" />
                                            </a>
                                        </div>
                                        <div class="filtr-item col-sm-2" data-category="3, 4" data-sort="red sample">
                                            <a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=3"
                                                data-toggle="lightbox" data-title="sample 3 - red">
                                                <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=3"
                                                    class="img-fluid mb-2" alt="red sample" />
                                            </a>
                                        </div>
                                        <div class="filtr-item col-sm-2" data-category="3, 4" data-sort="red sample">
                                            <a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=4"
                                                data-toggle="lightbox" data-title="sample 4 - red">
                                                <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=4"
                                                    class="img-fluid mb-2" alt="red sample" />
                                            </a>
                                        </div>
                                        <div class="filtr-item col-sm-2" data-category="2, 4" data-sort="black sample">
                                            <a href="https://via.placeholder.com/1200/000000.png?text=5"
                                                data-toggle="lightbox" data-title="sample 5 - black">
                                                <img src="https://via.placeholder.com/300/000000?text=5"
                                                    class="img-fluid mb-2" alt="black sample" />
                                            </a>
                                        </div>
                                        <div class="filtr-item col-sm-2" data-category="1" data-sort="white sample">
                                            <a href="https://via.placeholder.com/1200/FFFFFF.png?text=6"
                                                data-toggle="lightbox" data-title="sample 6 - white">
                                                <img src="https://via.placeholder.com/300/FFFFFF?text=6"
                                                    class="img-fluid mb-2" alt="white sample" />
                                            </a>
                                        </div>
                                        <div class="filtr-item col-sm-2" data-category="1" data-sort="white sample">
                                            <a href="https://via.placeholder.com/1200/FFFFFF.png?text=7"
                                                data-toggle="lightbox" data-title="sample 7 - white">
                                                <img src="https://via.placeholder.com/300/FFFFFF?text=7"
                                                    class="img-fluid mb-2" alt="white sample" />
                                            </a>
                                        </div>
                                        <div class="filtr-item col-sm-2" data-category="2, 4" data-sort="black sample">
                                            <a href="https://via.placeholder.com/1200/000000.png?text=8"
                                                data-toggle="lightbox" data-title="sample 8 - black">
                                                <img src="https://via.placeholder.com/300/000000?text=8"
                                                    class="img-fluid mb-2" alt="black sample" />
                                            </a>
                                        </div>
                                        <div class="filtr-item col-sm-2" data-category="3, 4" data-sort="red sample">
                                            <a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=9"
                                                data-toggle="lightbox" data-title="sample 9 - red">
                                                <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=9"
                                                    class="img-fluid mb-2" alt="red sample" />
                                            </a>
                                        </div>
                                        <div class="filtr-item col-sm-2" data-category="1" data-sort="white sample">
                                            <a href="https://via.placeholder.com/1200/FFFFFF.png?text=10"
                                                data-toggle="lightbox" data-title="sample 10 - white">
                                                <img src="https://via.placeholder.com/300/FFFFFF?text=10"
                                                    class="img-fluid mb-2" alt="white sample" />
                                            </a>
                                        </div>
                                        <div class="filtr-item col-sm-2" data-category="1" data-sort="white sample">
                                            <a href="https://via.placeholder.com/1200/FFFFFF.png?text=11"
                                                data-toggle="lightbox" data-title="sample 11 - white">
                                                <img src="https://via.placeholder.com/300/FFFFFF?text=11"
                                                    class="img-fluid mb-2" alt="white sample" />
                                            </a>
                                        </div>
                                        <div class="filtr-item col-sm-2" data-category="2, 4" data-sort="black sample">
                                            <a href="https://via.placeholder.com/1200/000000.png?text=12"
                                                data-toggle="lightbox" data-title="sample 12 - black">
                                                <img src="https://via.placeholder.com/300/000000?text=12"
                                                    class="img-fluid mb-2" alt="black sample" />
                                            </a>
                                        </div> --}}
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
@endPush
