<input type="hidden" value="{{ $serviceObj->id }}" name="id">
<div class="card card-primary card-tabs mb-3" style="width: 100%;">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="service-tabs" role="tablist">
            <li class="nav-item"> <a class="nav-link active" id="general-tab" data-toggle="pill" href="#general"
                    role="tab" aria-controls="general" aria-selected="true">General</a> </li>
            <li class="nav-item"> <a class="nav-link" id="featured-image-tab" data-toggle="pill" href="#featured-image"
                    role="tab" aria-controls="featured-image" aria-selected="true">Featured
                    Image</a> </li>
            <li class="nav-item"> <a class="nav-link" id="seo-tab" data-toggle="pill" href="#seo" role="tab"
                    aria-controls="seo" aria-selected="true">SEO</a> </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="service-tabsContent">
            <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">                
                <div class="form-group">
                    <label>Parent Category</label>
                    <select class="form-control {{ hasError($errors, 'parent_id') }}" name="parent_id">
                    {!! generateParentServicesDropDown($serviceObj->parent_id, true) !!}
                    </select>
                    {!! showErrors($errors, 'parent_id') !!}
                </div>                
                <div class="form-group"> 
                    <label for="title">Title</label> 
                    <input type="text" class="form-control"
                        id="title" name="title" value="{{ $serviceObj->title }}"> @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group"> <label for="slug">Slug </label> <input type="text" class="form-control"
                        id="slug" name="slug" value="{{ $serviceObj->slug }}"> @error('slug')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group"> <label for="description">Description</label>
                    <textarea style="height: 100px !important;" class="form-control" id="description" name="description">{{ $serviceObj->description }}</textarea> @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group"> 
                    <label for="status">Status</label> 
                    <select class="form-control"
                        name="status" value="{{ $serviceObj->status }}" id="status"> {!! generateServiceStatusDropDown($serviceObj->status, false) !!}
                    </select> @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="tab-pane fade" id="featured-image" role="tabpanel" aria-labelledby="featured-image-tab">
                <div class="form-group">
                    @if (!empty($serviceObj->featured_image))
                        <div>
                            <img src="{{ getImage('services', $serviceObj->featured_image, 'thumb') }}"
                                height="150">
                        </div>
                    @endif
                    <label for="featured_image">Featured Image</label> <input type="file" class="form-control"
                        id="featured_image" name="featured_image"> @error('featured_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group"> <label for="featured_image_alt">Featured Image Alt</label> <input
                        type="text" class="form-control" id="featured_image_alt" name="featured_image_alt"
                        value="{{ $serviceObj->featured_image_alt }}"> @error('featured_image_alt')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group"> <label for="featured_image_title">Featured Image Title</label> <input
                        type="text" class="form-control" id="featured_image_title" name="featured_image_title"
                        value="{{ $serviceObj->featured_image_title }}"> @error('featured_image_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                <div class="form-group mb-3">
                    <label class="form-label">Make Follow</label>
                    <input id="show_follow_rel_1" value="1" type="radio" name="show_follow"
                        value="{{ $serviceObj->show_follow }}"
                        {{ $serviceObj->show_follow == 1 ? 'checked' : '' }} />
                    @php echo helptooltip('follow') @endphp <br />
                    <label class="form-label">Make No Follow</label>
                    <input id="show_follow_rel_0" value="0" type="radio" name="show_follow"
                        value="{{ $serviceObj->show_follow }}"
                        {{ $serviceObj->show_follow == 0 ? 'checked' : '' }} />
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Indexing</label>
                    <input id="show_index_rel_1" value="1" type="radio" name="show_index"
                        value="{{ $serviceObj->show_index }}"
                        {{ $serviceObj->show_index == 1 ? 'checked' : '' }} />
                    @php echo helptooltip('indexing') @endphp <br />
                    <label class="form-label">No Indexing</label>
                    <input id="show_index_rel_0" value="0" type="radio" name="show_index"
                        value="{{ $serviceObj->show_index }}"
                        {{ $serviceObj->show_index == 0 ? 'checked' : '' }} />
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Meta Title(<i>Max:</i> <span>70
                            characters</span>) @php echo helptooltip('seo_title')@endphp </label>
                    <input type="text" name="meta_title" value="{{ $serviceObj->meta_title }}"
                        class="form-control" placeholder="Meta Titl">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Meta Keywords @php echo helptooltip('seo_keywords')@endphp</label>
                    <textarea style="height: 100px !important;" class="form-control" rows="3" cols="70"
                        name="meta_keywords">{{ $serviceObj->meta_keywords }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Meta Description @php echo helptooltip('seo_descp')@endphp</label>
                    <textarea style="height: 100px !important;" class="form-control" rows="3" cols="70"
                        name="meta_description">{{ $serviceObj->meta_description }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Canonical URL @php echo helptooltip('canonical_url')@endphp</label>
                    <textarea style="height: 100px !important;" class="form-control" rows="3" cols="70"
                        name="canonical_url">{{ $serviceObj->canonical_url }}</textarea> <code>If Canonical URL is same as Page URL then Leave this field empty,
                        in this case Canonical URL will be handled programmatically</code>
                </div>
            </div>
        </div>
    </div>
</div>
@section('beforeBodyClose')
    <script type="text/javascript">
        $(document).ready(function(e) {
            $("#title").change(function() {
                string_to_slug('title', 'slug');
            });
        });
    </script>
@endsection
