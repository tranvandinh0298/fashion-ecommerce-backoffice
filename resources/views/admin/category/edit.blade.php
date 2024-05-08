@extends('admin.layouts.app')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Edit Category</h5>
        <div class="card-body">
            <form method="post" action="{{ route('categories.update', $category['categoryId']) }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title"
                        value="{{ $category['title'] }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary" class="col-form-label">Summary</label>
                    <textarea class="form-control" id="summary" name="summary">{{ $category['summary'] }}</textarea>
                    @error('summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="isParent">Is Parent</label><br>
                    <input type="checkbox" name='isParent' id='isParent' value='{{ $category['isParent'] }}'
                        {{ $category['isParent'] == 1 ? 'checked' : '' }}> Yes
                </div>

                <div class="form-group {{ $category['isParent'] == 1 ? 'd-none' : '' }}" id='parent_cat_div'>
                    <label for="parentCategoryId">Parent Category</label>
                    <select name="parentCategoryId" class="form-control">
                        <option value="">--Select any category--</option>
                        @foreach ($parentCategories as $parentCategory)
                            <option value='{{ $parentCategory['categoryId'] }}'
                                {{ !empty($category['parentCategory']) && $parentCategory['categoryId'] == $category['parentCategory']['categoryId'] ? 'selected' : '' }}>
                                {{ $parentCategory['title'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Photo</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo"
                            value="{{ $category['photo'] }}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;">
                        @if (!empty($category['photo']))
                            <img src="{{ $category['photo'] }}" style="height: 5rem;">
                        @endif
                    </div>
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $category['status'] == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $category['status'] == 'inactive' ? 'selected' : '' }}>Inactive
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
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('assets/admin/summernote/summernote.min.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
    <script>
        $('#isParent').change(function() {
            var is_checked = $('#isParent').prop('checked');
            if (is_checked) {
                $('#parent_cat_div').addClass('d-none');
                $('#parent_cat_div').val('');
            } else {
                $('#parent_cat_div').removeClass('d-none');
            }
        })
    </script>
@endpush
