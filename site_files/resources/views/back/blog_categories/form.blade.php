<div class="mb-3 card card-primary card-tabs" style="width: 100%;">
    <div class="p-0 pt-1 card-header">
        <ul class="nav nav-tabs" id="general-tabs" role="tablist">
            <li class="nav-item"> <a class="nav-link active" id="general-tab" data-bs-toggle="pill" href="#general"
                    role="tab" aria-controls="general" aria-selected="true">General</a> </li>
            <li class="nav-item"> <a class="nav-link" id="featured-image-tab" data-bs-toggle="pill"
                    href="#featured-image" role="tab" aria-controls="featured-image" aria-selected="true">Featured
                    Image</a> </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="general-tabsContent">
            <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                <input type="hidden" name="moduleType" id="moduleType" value="blog/category">
                <input type="hidden" value="{{ $blogCategoryObj->id }}" name="id" id="id">
                <input type="hidden" value="{{ old('featured_img', $blogCategoryObj->featured_img) }}" name="featured_img" id="featured_img">
                <div class="form-group">
                    <label class="form-label">Title:*</label>
                    <input id="cate_title" name="cate_title" value="{{ old('cate_title', $blogCategoryObj->cate_title) }}" type="text"
                        class="form-control {{ hasError($errors, 'cate_title') }}" placeholder="Title">
                    {!! showErrors($errors, 'cate_title') !!}
                </div>
                <div class="form-group">
                    <label class="form-label">Category Slug:*</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                {{ url('blog/category/') . '/' }}
                            </span>
                        </div>
                        <input id="cate_slug" name="cate_slug" value="{{ old('cate_slug', $blogCategoryObj->cate_slug) }}"
                            type="text" class="form-control {{ hasError($errors, 'cate_slug') }}"
                            placeholder="Category Slug">
                    </div>
                    {!! showErrors($errors, 'cate_slug') !!}
                </div>
                <div class="form-group">
                    <label class="form-label">Description:*</label>
                    <textarea name="cate_description" id="cate_description" class="form-control {{ hasError($errors, 'cate_description') }}"
                        placeholder="Description">{{ old('cate_description', $blogCategoryObj->cate_description) }}</textarea>
                    {!! showErrors($errors, 'cate_description') !!}
                </div>
                <div class="form-group">
                    <label for="is_featured">Is Featured?</label>
                    <select class="form-control" name="is_featured" id="is_featured">
                        {!! generateBlogCategoryIsFeaturedDropDown(old('is_featured', $blogCategoryObj->is_featured), false) !!}
                    </select> @error('is_featured')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="show_in_header">Show in Header?</label>
                    <select class="form-control" name="show_in_header" id="show_in_header">
                        {!! generateBlogCategoryShowInHeaderDropDown(old('show_in_header', $blogCategoryObj->show_in_header), false) !!}
                    </select> @error('show_in_header')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Status:*</label>
                    <select class="form-control" name="sts" id="sts">
                        {!! generateBlogCategoryStatusDropDown(old('sts', $blogCategoryObj->sts), false) !!}
                    </select>
                </div>
            </div>
            <div class="tab-pane fade" id="featured-image" role="tabpanel" aria-labelledby="featured-image-tab">
                <div class="form-group">
                    <div id="blog_category_featured_image_div">
                        @if (!empty(old('featured_img', $blogCategoryObj->featured_img)))
                            <img src="{{ getImage('blog_categories', old('featured_img', $blogCategoryObj->featured_img), 'thumb') }}?t={{ time() }}" height="150">
                        @endif
                    </div>
                    <label for="featured_img">Featured Image</label><br/>
                    <button id="upload_blog_category_featured_image_btn" type="button" class="btn btn-warning">Upload
                        Featured
                        Image</button>
                    <input type="file" id="blog_category_featured_img_file" style="visibility: hidden;"
                        onchange="uploadBlogCategoryFeaturedImage();" accept="image/*">
                    @error('featured_img')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group"> <label for="featured_img_alt">Featured Image Alt</label> <input
                        type="text" class="form-control" id="featured_img_alt" name="featured_img_alt"
                        value="{{ old('featured_img_alt', $blogCategoryObj->featured_img_alt) }}"> @error('featured_img_alt')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group"> <label for="featured_img_title">Featured Image Title</label> <input
                        type="text" class="form-control" id="featured_img_title" name="featured_img_title"
                        value="{{ old('featured_img_title', $blogCategoryObj->featured_img_title) }}"> @error('featured_img_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
@section('beforeBodyClose')
    <script>
        $(document).ready(function(e) {
            $("#cate_title").change(function() {
                string_to_slug('cate_title', 'cate_slug');
            });
            $("#cate_slug").change(function() {
                check_slug('cate_slug');
            });
        });
    </script>
    <script type="text/javascript">
        $('#upload_blog_category_featured_image_btn').click(function() {
            $('#blog_category_featured_img_file').click();
        });

        function uploadBlogCategoryFeaturedImage() {
            var blog_category_featured_img_file = $('#blog_category_featured_img_file').prop('files')[0];
            if (fileValidation('blog_category_featured_img_file')) {
                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("oldName", $('#featured_img').val());
                formData.append("newName", $('#cate_title').val());
                formData.append("blog_category_featured_img_file", blog_category_featured_img_file);
                $('#blog_category_featured_image_div').html('Uploading image...');
                $('#upload_blog_category_featured_image_btn').hide();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('blog.category.upload.featured.image') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(data) {
                        $('#featured_img').val(data.fileName);
                        $('#blog_category_featured_image_div').html(data.image);
                        $('#upload_blog_category_featured_image_btn').show();
                    },
                    error: function(data) {
                        console.log("error");
                        console.log(data);
                    }
                });
            }
        }
    </script>
@endsection
