<div class="modal fade" id="media_files">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Documents/Files</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="folderselect">
                    <h3>Select Folder</h3>
                    <div class="btn-group">
                        @foreach ($filesObj as $ak => $av)
                            <button type="button" class="fldbtns btn btn-sm btn-default <?php if ($av['album_title'] == 'root') {
                                echo 'active';
                            } ?>"
                                onClick="show_section('{{ $ak }}',this)" aria-haspopup="true"
                                aria-expanded="false">
                                {{ $av['album_title'] }}
                            </button>
                        @endforeach
                    </div>
                </div>
                @foreach ($filesObj as $kk => $val)
                    <div class="myasection mediaup">
                        <div class="row mystr section_{{ $val['album_id'] }}">
                            <div class="col-md-8">
                                <h1>
                                    <i class="fas fa-folder-open-o" aria-hidden="true"></i> {{ $val['album_title'] }}
                                </h1>
                            </div>
                            <div class="col-md-4 text-end">
                                <h3>
                                    @if ($val['album_title'] != 'root')
                                    @endif
                                </h3>
                            </div>
                        </div>
                        <ul class="row fileslist  section_{{ $val['album_id'] }}">
                            @foreach ($val['all'] as $k => $v)
                                @php
                                    $imgID = $val['album_id'] . '_' . $k;
                                @endphp
                                <li class="col-md-6" id="id_{{ $imgID }}">
                                    <div class="filedata">
                                        <span class="fileico">
                                            @php
                                                $path_info = pathinfo(storage_uploads($v['url']));
                                                if (isset($path_info['extension']) && isset($filesExts[$path_info['extension']])) {
                                                    echo $filesExts[$path_info['extension']];
                                                } else {
                                                    echo '<i class="fas fa-file-o" aria-hidden="true"></i>';
                                                }
                                            @endphp
                                        </span>
                                        <a target="_blank" class="filepath"
                                            href="{{ storage_uploads($v['url']) }}">{{ $v['name'] }}</a>
                                        <span class="badge badge-secondary"><?php echo human_filesize(filesize(storage_uploads($v['url']))); ?></span>
                                        <a class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-placement="left"
                                            title="Insert Document" href="javascript:;"
                                            onclick="media_insert_file('{{ asset_uploads($v['url']) }}');"><i
                                                class="fas fa-cloud-download" aria-hidden="true"></i></a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal_file_link_text">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-2 mb-3">
                    <div class="mb-2-prepend">
                        <span class="mb-2-text">Link On Text</span>
                    </div>
                    <input type="text" id="link_on_text" name="link_on_text" class="form-control" aria-label=""
                        value="Download File">
                    <input type="hidden" id="file_c_url" name="file_c_url" value="" />
                    <div class="mb-2-append">
                        <span class="mb-2-text">
                            <a href="javascript:;" onClick="insert_media_file_html();" class="btn btn-sm btn-info">Insert</a>
                        </span>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
