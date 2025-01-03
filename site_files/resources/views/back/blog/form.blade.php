@php
    $cate_ids = explode(',', old('cate_ids', $blogPostObj->cate_ids));
    $strlen_meta_title = strlen($blogPostObj->meta_title);
    $strlen_meta_keywords = strlen($blogPostObj->meta_keywords);
    $strlen_meta_description = strlen($blogPostObj->meta_description);
    $strlen_canonical_url = strlen($blogPostObj->canonical_url);
@endphp
<div class="mb-3 card card-primary card-tabs" style="width: 100%;">
    <div class="p-0 pt-1 card-header">
        <ul class="nav nav-tabs" id="general-tabs" role="tablist">
            <li class="nav-item"> <a class="nav-link active" id="general-tab" data-bs-toggle="pill" href="#general"
                    role="tab" aria-controls="general" aria-selected="true">General</a> </li>
            <li class="nav-item"> <a class="nav-link" id="featured-image-tab" data-bs-toggle="pill"
                    href="#featured-image" role="tab" aria-controls="featured-image" aria-selected="true">Featured
                    Image</a> </li>
            <li class="nav-item"> <a class="nav-link" id="seo-tab" data-bs-toggle="pill" href="#seo" role="tab"
                    aria-controls="seo" aria-selected="true">SEO</a> </li>
            <li class="nav-item"> <a class="nav-link" id="tags-tab" data-bs-toggle="pill" href="#tags" role="tab"
                    aria-controls="tags" aria-selected="true">Tags</a> </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="general-tabsContent">
            <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                <input type="hidden" name="moduleType" id="moduleType" value="blog">
                <input type="hidden" value="{{ $blogPostObj->id }}" name="id" id="id">
                <input type="hidden" value="{{ $blogPostObj->author_id }}" name="author_id" id="author_id">
                <input type="hidden" value="{{ old('featured_img', $blogPostObj->featured_img) }}" name="featured_img"
                    id="featured_img">
                <div class="clearfix form-group">
                    <label>Categories</label>
                    <div class="row">
                        @foreach ($blogCategories as $blogCategory)
                            <div class="p-1 col-md-4">
                                <div class="icheck-success d-inline">
                                    <input type="checkbox" id="cate_ids_{{ $blogCategory->id }}" name="cate_ids[]"
                                        value="{{ $blogCategory->id }}" id="cate_ids_{{ $blogCategory->id }}"
                                        {{ in_array($blogCategory->id, $cate_ids) ? 'checked' : '' }}>
                                    <label
                                        for="cate_ids_{{ $blogCategory->id }}">&nbsp;&nbsp;{{ $blogCategory->cate_title }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Title:*</label>
                    <input id="title" name="title" value="{{ old('title', $blogPostObj->title) }}" type="text"
                        class="form-control {{ hasError($errors, 'title') }}" placeholder="Title">
                    {!! showErrors($errors, 'title') !!}
                </div>
                <div class="form-group">
                    <label class="form-label">Post Slug:*</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                {{ url('blog') . '/' }}
                            </span>
                        </div>
                        <input id="post_slug" name="post_slug" value="{{ old('post_slug', $blogPostObj->post_slug) }}"
                            type="text" class="form-control {{ hasError($errors, 'post_slug') }}"
                            placeholder="Post Slug">
                    </div>
                    {!! showErrors($errors, 'post_slug') !!}
                </div>
                <div class="form-group">
                    <label class="form-label">Description:*</label>
                    <textarea name="description" id="description" class="form-control {{ hasError($errors, 'description') }}"
                        placeholder="Description">{{ old('description', $blogPostObj->description) }}</textarea>
                    {!! showErrors($errors, 'description') !!}
                </div>
                <div class="form-group">
                    <label class="form-label">Date:*</label>
                    <input id="dated" name="dated" value="{{ old('dated', $blogPostObj->dated) }}"
                        type="date" class="form-control {{ hasError($errors, 'dated') }}" placeholder="Date"
                        autocomplete="off">
                    {!! showErrors($errors, 'dated') !!}
                </div>
                <div class="form-group">
                    <label class="form-label">Author Name:*</label>
                    <input id="author_name" name="author_name"
                        value="{{ old('author_name', $blogPostObj->author_name) }}" type="text"
                        class="form-control {{ hasError($errors, 'author_name') }}" placeholder="Author Name">
                    {!! showErrors($errors, 'author_name') !!}
                </div>
                <div class="form-group">
                    <label for="is_featured">Is Featured?</label>
                    <select class="form-control" name="is_featured" id="is_featured">
                        {!! generateBlogPostIsFeaturedDropDown(old('is_featured', $blogPostObj->is_featured), false) !!}
                    </select> @error('is_featured')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Status:*</label>
                    <select class="form-control" name="sts" id="sts">
                        {!! generateBlogPostStatusDropDown(old('sts', $blogPostObj->sts), false) !!}
                    </select>
                </div>
            </div>
            <div class="tab-pane fade" id="featured-image" role="tabpanel" aria-labelledby="featured-image-tab">
                <div class="form-group">
                    <div id="blog_post_featured_image_div">
                        @if (!empty(old('featured_img', $blogPostObj->featured_img)))
                            <img src="{{ getImage('blog', old('featured_img', $blogPostObj->featured_img), 'thumb') }}?t={{ time() }}"
                                height="150">
                        @endif
                    </div>
                    <label for="featured_img">Featured Image</label><br />
                    <button id="upload_blog_post_featured_image_btn" type="button" class="btn btn-warning">Upload
                        Featured
                        Image</button>
                    <input type="file" id="blog_post_featured_img_file" style="visibility: hidden;"
                        onchange="uploadBlogFeaturedImage();" accept="image/*">
                    @error('featured_img')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group"> <label for="featured_img_alt">Featured Image Alt</label> <input
                        type="text" class="form-control" id="featured_img_alt" name="featured_img_alt"
                        value="{{ old('featured_img_alt', $blogPostObj->featured_img_alt) }}">
                    @error('featured_img_alt')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group"> <label for="featured_img_title">Featured Image Title</label> <input
                        type="text" class="form-control" id="featured_img_title" name="featured_img_title"
                        value="{{ old('featured_img_title', $blogPostObj->featured_img_title) }}">
                    @error('featured_img_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                <div class="mb-3 form-group">
                    <label class="form-label">Make Follow</label>
                    <input id="show_follow_rel_1" value="1" type="radio" name="show_follow"
                        {{ old('show_follow', $blogPostObj->show_follow) == 1 ? 'checked' : '' }} />
                    @php echo helptooltip('follow') @endphp <br />
                    <label class="form-label">Make No Follow</label>
                    <input id="show_follow_rel_0" value="0" type="radio" name="show_follow"
                        {{ old('show_follow', $blogPostObj->show_follow) == 0 ? 'checked' : '' }} />
                </div>
                <div class="mb-3 form-group">
                    <label class="form-label">Indexing</label>
                    <input id="show_index_rel_1" value="1" type="radio" name="show_index"
                        {{ old('show_index', $blogPostObj->show_index) == 1 ? 'checked' : '' }} />
                    @php echo helptooltip('indexing') @endphp <br />
                    <label class="form-label">No Indexing</label>
                    <input id="show_index_rel_0" value="0" type="radio" name="show_index"
                        {{ old('show_index', $blogPostObj->show_index) == 0 ? 'checked' : '' }} />
                </div>
                <div class="mb-3 form-group">
                    <label class="form-label">Meta Title (<i class="text-primary">Recommended: 60 characters</i>)
                        @php echo helptooltip('seo_title')@endphp </label>
                    <input type="text" name="meta_title" id="meta_title"
                        value="{{ old('meta_title', $blogPostObj->meta_title) }}" class="form-control"
                        placeholder="Meta Title"
                        onKeyUp="seo_limit_suggestion('meta_title', 60, 'meta_title_char_countdown');">
                    <span id="meta_title_char_countdown"
                        class="{{ $strlen_meta_title > 60 ? 'text-danger' : 'text-success' }}">{{ $strlen_meta_title }}
                        characters</span>
                </div>
                <div class="mb-3 form-group">
                    <label class="form-label">Meta Keywords (<i class="text-primary">Recommended: 160 characters</i>)
                        @php echo helptooltip('seo_keywords')@endphp</label>
                    <textarea style="height: 100px !important;" class="form-control" rows="3" cols="70" name="meta_keywords"
                        id="meta_keywords" onKeyUp="seo_limit_suggestion('meta_keywords', 160, 'meta_keywords_char_countdown');">{{ old('meta_keywords', $blogPostObj->meta_keywords) }}</textarea>
                    <span id="meta_keywords_char_countdown"
                        class="{{ $strlen_meta_keywords > 160 ? 'text-danger' : 'text-success' }}">{{ $strlen_meta_keywords }}
                        characters</span>
                </div>
                <div class="mb-3 form-group">
                    <label class="form-label">Meta Description(<i class="text-primary">Recommended: 160
                            characters</i>) @php echo helptooltip('seo_descp')@endphp</label>
                    <textarea style="height: 100px !important;" class="form-control" rows="3" cols="70"
                        name="meta_description" id="meta_description"
                        onKeyUp="seo_limit_suggestion('meta_description', 160, 'meta_description_char_countdown');">{{ old('meta_description', $blogPostObj->meta_description) }}</textarea>
                    <span id="meta_description_char_countdown"
                        class="{{ $strlen_meta_description > 160 ? 'text-danger' : 'text-success' }}">{{ $strlen_meta_description }}
                        characters</span>
                </div>
                <div class="mb-3 form-group">
                    <label class="form-label">Canonical URL @php echo helptooltip('canonical_url')@endphp</label>
                    <textarea style="height: 100px !important;" class="form-control" rows="3" cols="70" name="canonical_url"
                        id="canonical_url">{{ old('canonical_url', $blogPostObj->canonical_url) }}</textarea> <code>If Canonical URL is same as Page URL then Leave this field empty,
                        in this case Canonical URL will be handled programmatically</code>
                </div>
            </div>
            <div class="tab-pane fade" id="tags" role="tabpanel" aria-labelledby="tags-tab">
                <div class="mb-3 form-group">
                    <label class="form-label">Tags</label>
                    <input type="text" id="post_tags" name="tags[]" class="form-control"
                        placeholder="Type to add tags" />
                </div>
            </div>
        </div>
    </div>
</div>
@section('beforeBodyClose')
    <script>
        /* $(document).ready(function() {
                $("#dated").datepicker({
                    format: 'Y-m-d'
                });
            }); */
        $(document).ready(function(e) {
            $("#title").change(function() {
                string_to_slug('title', 'post_slug');
            });
            $("#post_slug").change(function() {
                check_slug('post_slug');
            });
        });
    </script>
    <script type="text/javascript">
        @php
            $tags = old('tags', explode(',', $blogPostObj->tags));
        @endphp
        var tags = new Array();
        @foreach ($tags as $tag)
            tags.push('{{ $tag }}');
        @endforeach

        $(document).ready(function(e) {
            var tagsMS = $('#post_tags').magicSuggest({
                @if(isset($tags[0]) && !empty($tags[0]))
                    data: tags,
                    value: tags,
                @endif
                selectionPosition: 'bottom',
                maxSelection: 5000,
                valueField: 'tags[]'
            });
            /* 
            $(tagsMS).on(
                'selectionchange',
                function(e, cb, s) {
                    $("#ipAddressFormSubmit").attr("disabled", false);
                }
            );
             */
        });
        $('#upload_blog_post_featured_image_btn').click(function() {
            $('#blog_post_featured_img_file').click();
        });

        function uploadBlogFeaturedImage() {
            var blog_post_featured_img_file = $('#blog_post_featured_img_file').prop('files')[0];
            if (fileValidation('blog_post_featured_img_file')) {
                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("oldName", $('#featured_img').val());
                formData.append("newName", $('#title').val());
                formData.append("blog_post_featured_img_file", blog_post_featured_img_file);
                $('#blog_post_featured_image_div').html('Uploading image...');
                $('#upload_blog_post_featured_image_btn').hide();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('blog.post.upload.featured.image') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(data) {
                        $('#featured_img').val(data.fileName);
                        $('#blog_post_featured_image_div').html(data.image);
                        $('#upload_blog_post_featured_image_btn').show();
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
