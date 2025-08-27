<div class="row" id="page_video_option" style="display: {{ $module->show_videos_option == 1 ? 'block' : 'none' }}">
    <div class="col-md-12">
        <div class="m-3 spinner-border text-primary" role="status" id="upload_video_loader_div" style="display:none;">
            <span class="visually-hidden">Uploading...</span>
        </div>
    </div>
    <div class="col-md-12">
        <hr />
        <label class="text-sm text text-info upload_video_label"><i class="fas fa-film" aria-hidden="true"></i> Manage
            Videos</label>
        <div id="upload_video_div" style="display:none;">
            <div class="mb-2">
                <label>Video Type:</label>
                <select class="form-control" name="video_type" id="video_type">
                    <option value="">Select Video Type</option>
                    <option value="Youtube">YouTube Video</option>
                    <option value="Vimeo">Vimeo Video</option>
                    <option value="Upload">Video Upload</option>
                </select>
            </div>
            <div class="mb-2">
                <label><span id="s_title">Youtube Video:</span> </label>
                <div id="field_type_div">
                    <input type="text" name="video_link_embed_code" id="video_link_embed_code" class="form-control"
                        value="" placeholder="https://www.youtube.com/watch?v=C0DPdy98e4c">
                </div>
            </div>
            <div class="mb-2" id="video_thumbnail_div" style="display: none;">
                <label>Thumbnail Image:</label>
                <input type="file" name="video_thumb_img" id="video_thumb_img" class="form-control" value=""
                    placeholder="">
            </div>
            <div class="mb-2">
                <button type="button" name="upload_video_btn" id="upload_video_btn" class="btn btn-sm btn-success"
                    onclick="uploadModuleVideo();">Upload</button>
            </div>

            <div class="m-3">
                <hr />
            </div>
            <div class="m-2 row" id="module_videos_div" style="">
                @foreach ($moduleVideos as $moduleVideoObj)
                    @include('back.module.module_videos.module_videos_html_sub', [
                        'moduleObj' => $module,
                        'moduleVideoObj' => $moduleVideoObj,
                    ])
                @endforeach
            </div>
        </div>
        <hr />
    </div>
</div>
