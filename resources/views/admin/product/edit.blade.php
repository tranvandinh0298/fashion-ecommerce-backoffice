@extends('admin.layouts.app')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Edit Product</h5>
        <div class="card-body">
            <form method="post" action="{{ route('products.update', $product['productId']) }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title"
                        value="{{ $product['title'] }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary" class="col-form-label">Summary <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="summary" name="summary">{{ $product['summary'] }}</textarea>
                    @error('summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="col-form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ $product['description'] }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="isFeatured">Is Featured</label><br>
                    <input type="checkbox" name='isFeatured' id='isFeatured' value='{{ $product['isFeatured'] }}'
                        {{ $product['isFeatured'] ? 'checked' : '' }}> Yes
                </div>

                <div class="form-group">
                    <label for="categoryId">Category <span class="text-danger">*</span></label>
                    <select name="categoryId" id="categoryId" class="form-control">
                        <option value="">--Select any category--</option>
                        @if (!empty($categories))
                            @foreach ($categories as $category)
                                <option value='{{ $category['categoryId'] }}'
                                    {{ $product['category']['categoryId'] == $category['categoryId'] ? 'selected' : '' }}>
                                    {{ $category['title'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group {{ $product['childCategory'] ? '' : 'd-none' }}" id="child-category-div">
                    <label for="childCategoryId">Sub Category</label>
                    <select name="childCategoryId" id="childCategoryId" class="form-control">
                        <option value="">--Select any sub category--</option>
                        @if (!empty($childCategories))
                            @foreach ($childCategories as $category)
                                <option value='{{ $category['categoryId'] }}'
                                    {{ $product['childCategory']['categoryId'] == $category['categoryId'] ? 'selected' : '' }}>
                                    {{ $category['title'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Price(NRS) <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Enter price"
                        value="{{ $product['price'] }}" class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="discount" class="col-form-label">Discount(%)</label>
                    <input id="discount" type="number" name="discount" min="0" max="100"
                        placeholder="Enter discount" value="{{ $product['discount'] }}" class="form-control">
                    @error('discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="size">Size</label>
                    <select name="size[]" class="form-control selectpicker" multiple data-live-search="true">
                        @php
                            $data = explode(',', $product['size']);
                        @endphp
                        @endphp
                        <option value="">--Select any size--</option>
                        <option value="S" @if (in_array('S', $data)) selected @endif>Small (S)</option>
                        <option value="M" @if (in_array('M', $data)) selected @endif>Medium (M)</option>
                        <option value="L" @if (in_array('L', $data)) selected @endif>Large (L)</option>
                        <option value="XL" @if (in_array('XL', $data)) selected @endif>Extra Large (XL)</option>
                        <option value="2XL" @if (in_array('2XL', $data)) selected @endif>Double Extra Large (2XL)
                        </option>
                        <option value="7US" @if (in_array('7US', $data)) selected @endif>7 US</option>
                        <option value="8US" @if (in_array('8US', $data)) selected @endif>8 US</option>
                        <option value="9US" @if (in_array('9US', $data)) selected @endif>9 US</option>
                        <option value="10US" @if (in_array('10US', $data)) selected @endif>10 US</option>
                        <option value="11US" @if (in_array('11US', $data)) selected @endif>11 US</option>
                        <option value="12US" @if (in_array('12US', $data)) selected @endif>12 US</option>
                        <option value="13US" @if (in_array('13US', $data)) selected @endif>13 US</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="brandId">Brand</label>
                    <select name="brandId" class="form-control">
                        <option value="">--Select Brand--</option>
                        @if (!empty($brands))
                            @foreach ($brands as $brand)
                                <option value="{{ $brand['brandId'] }}"
                                    {{ $product['brand']['brandId'] == $brand['brandId'] ? 'selected' : '' }}>
                                    {{ $brand['title'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="condition">Condition</label>
                    <select name="condition" class="form-control">
                        <option value="">--Select Condition--</option>
                        <option value="default" {{ $product['condition'] == 'default' ? 'selected' : '' }}>Default
                        </option>
                        <option value="new" {{ $product['condition'] == 'new' ? 'selected' : '' }}>New</option>
                        <option value="hot" {{ $product['condition'] == 'hot' ? 'selected' : '' }}>Hot</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="stock">Quantity <span class="text-danger">*</span></label>
                    <input id="quantity" type="number" name="stock" min="0" placeholder="Enter quantity"
                        value="{{ $product['stock'] }}" class="form-control">
                    @error('stock')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder"
                                class="btn btn-primary text-white">
                                <i class="fas fa-image"></i> Choose
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo"
                            value="{{ $product['photo'] }}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;">
                        @if (!empty($product['photo']))
                            <img src="{{ $product['photo'] }}" style="height: 5rem;">
                        @endif
                    </div>
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $product['status'] == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $product['status'] == 'inactive' ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/summernote/summernote.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('assets/admin/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write detail Description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>

    <script>
        $('#categoryId').change(function() {
            var categoryId = $(this).val();
            if (categoryId != null) {
                $.ajax({
                    url: "/admin/categories/" + categoryId + "/child-categories",
                    data: {},
                    success: function(response) {
                        console.log(response)
                        if (typeof(response) != 'object') {
                            response = $.parseJSON(response)
                        }
                        var html_option = "<option value=''>----Select sub category----</option>"
                        if (response.status) {
                            var data = response.data;
                            if (response.data) {
                                $('#child-category-div').removeClass('d-none');
                                data.forEach(item => {
                                    html_option += "<option value='" + item.categoryId + "'>" +
                                        item.title +
                                        "</option>"
                                });
                            }
                        } else {
                            $('#child-category-div').addClass('d-none');
                        }
                        $('#childCategoryId').html(html_option);
                    }
                });
            } else {}
        })
    </script>
@endpush
