<div class="modal fade" id="module_data_image_cropper_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <form action="#" id="module_data_image_crop_form" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="cropper_form_title" class="modal-title">Image Cropper Form</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body form">
                    <div class=" card-body">
                        <div class="row">
                            <div class="col-md-12" id="large_image"><img id="image" src=""
                                    alt="Crop Picture"></div>
                            {{-- <div class="col-md-4">
                                <div class="preview"></div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="source_image" id="source_image" value="" />
                    <input type="hidden" name="crop_x" id="crop_x" value="" />
                    <input type="hidden" name="crop_y" id="crop_y" value="" />
                    <input type="hidden" name="crop_height" id="crop_height" value="" />
                    <input type="hidden" name="crop_width" id="crop_width" value="" />
                    <input type="hidden" name="crop_rotate" id="crop_rotate" value="" />
                    <input type="hidden" name="image_id" id="image_id" value="">
                    <button type="button" id="btnCrop" onclick="save_module_data_cropped_img();"
                        class="btn btn-primary">Crop
                        Image
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
</div>
<div class="modal fade" id="moduleDataImageAltTitleModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <form action="#" id="moduleDataImageAltTitleForm" class="form-horizontal">
            @csrf
            <input type="hidden" name="image_id" id="image_id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Image Alt-Title Form</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body form">
                    <div class=" card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="image_alt" class="form-label">Image Alt</label>
                                    <input type="text" name="image_alt" id="image_alt" class="form-control"
                                        placeholder="Image Alt">
                                </div>
                                <div class="mb-3">
                                    <label for="image_title" class="form-label">Image Title</label>
                                    <input type="text" name="image_title" id="image_title"
                                        class="form-control" placeholder="Image Title">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnCrop" onclick="saveModuleDataImageAltTitle();"
                        class="btn btn-primary">Save
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
</div>
<div class="modal fade" id="moduleDataImageZoomModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src="" id="moduleDataImageZoomImage" />
        </div>
    </div>
</div>