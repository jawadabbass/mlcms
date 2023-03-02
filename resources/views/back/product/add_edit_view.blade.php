<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
            <div class="modal-content"> @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Person Form</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- <span id="product_name" style="padding-left:2px;" class="err"></span> -->
                <div class="modal-body form">
                    <div class="box-body">
                        <div class="alert alert-danger error-div" style="display:none"></div>
                        <input type="hidden" value="" name="id" />
                        <div class="form-body">
                            <div>
                                <label class="form-label">Product Name</label>
                                <input onchange="string_to_product_slug('product_name', 'product_slug');"
                                    name="product_name" placeholder="Product Name" class="form-control" type="text">
                                <span id="product_name" style="padding-left:2px;" class="err"></span>
                            </div>
                            <div>
                                <label for="basic-url">Page Link @php echo helptooltip('page_link'); @endphp</label>
                                <div class="mb-2"> <span class="mb-2-addon"
                                        id="basic-addon3">@php echo  base_url().'products' @endphp</span>
                                    <input type="text" class="form-control slug-field" name="product_slug"
                                        placeholder="Product Page Link">
                                </div>
                                <span id="product_slug" style="padding-left:2px;" class="err"></span>
                            </div>
                            <div>
                                <label class="form-label">Product Description</label>
                                <textarea name="product_description" placeholder="Product Description" class="form-control" type="text"></textarea>
                                <span id="product_description" style="padding-left:2px;" class="err"></span>
                            </div>
                            <div>
                                <label class="form-label">Product Price</label>
                                <input name="price" placeholder="Product Price" class="form-control" type="text">
                                <span id="price" style="padding-left:2px;" class="err"></span>
                            </div>
                            <div id="fea_img">
                                <label class="form-label"> Update Product Image <span style="font-size: 12px;color: red"> max size:
                                        {{ getMaxUploadSize() }}MB </span> @php echo helptooltip('max_image_size') @endphp </label>
                                <div id="file-field">
                                    <input type="file" name="product_img" id="module_img" class="form-control">
                                    <div id="attached_files_div"></div>
                                </div>
                                <span id="featured_img" style="padding-left:2px;" class="err"></span>
                                <div id="featured_img"></div>
                                <div class="clear"></div>
                                <div class="mt-3 mb-3">
                                    <label class="btn btn-primary img_alt_title_label">Image Title/Alt</label>
                                    <div class="mt-3 mb-3" style="display:none;">
                                        <label class="form-label">Image Title</label>
                                        <input type="text" name="product_img_title" id="product_img_title"
                                            class="form-control" placeholder="Product Image Title" value="">
                                        <label class="mt-3">Image Alt</label>
                                        <input type="text" name="product_img_alt" id="product_img_alt"
                                            class="form-control" placeholder="Product Image Alt" value="">
                                    </div>
                                </div>
                            </div>

                            <div id="product_img_div" style="display: none">
                            </div>
                            @include('back.product.seo_add_edit')
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Save Record</button>
                </div>
            </div>
        </form>
    </div>
</div>
