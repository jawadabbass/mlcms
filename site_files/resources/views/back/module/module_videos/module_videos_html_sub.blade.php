<div class="col-md-4" id="module_video_{{ $moduleVideoObj->id }}">
    <div class="card">
        <div class="card-body">
            <img
                src="{{ asset_uploads('module/' . $moduleObj->type . '/videos/thumb') . '/' . $moduleVideoObj->video_thumb_img }}">
        </div>
        <div class="text-center card-footer">
            <a title="Delete Video" onclick="remove_module_video({{ $moduleVideoObj->id }});"
                class="mb-1 btn btn-sm btn-danger" data-bs-toggle="tooltip" data-placement="left"
                title="Delete this video" href="javascript:;"> <i class="fas fa-trash"></i></a>
        </div>
    </div>
</div>
