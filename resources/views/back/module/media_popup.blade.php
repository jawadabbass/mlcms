<div class="modal fade" id="media_image">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                
                <h4 class="modal-title">Media Library</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="folderselect">
                    <h3>Select Folder</h3>
                    <div class="btn-group">
                        @foreach ($albumsObj as $ak => $av)
                            <button type="button" class="fldbtns btn btn-default <?php if ($av['album_title'] == 'root') {
                                echo 'active';
                            } ?>"
                                onClick="show_section('{{ $ak }}',this)" aria-haspopup="true"
                                aria-expanded="false">
                                {{ $av['album_title'] }}
                            </button>
                        @endforeach
                    </div>
                </div>
                @foreach ($albumsObj as $kk => $val)
                    <div class="myasection mediaup mediagalley2">
                        <div class="row mystr section_{{ $val['album_id'] }}" <?php 
if($val['album_title']!='root'){
      ?><?php } ?>>

                            <div class="col-md-8">
                                <h1>
                                    <i class="fa-solid fa-folder-open-o" aria-hidden="true"></i> {{ $val['album_title'] }}
                                </h1>
                            </div>
                            <div class="col-md-4 text-end">
                                <h3>

                                    {{-- <a href="javascript:;" class="btn btn-warning" onClick="edit_album({{$val['album_id']}},'{{$val['album_title']}}');" data-bs-toggle="tooltip" title="Edit Folder"><i class="fa-solid fa-edit" aria-hidden="true"></i></a> --}}
                                    @if ($val['album_title'] != 'root')
                                    @endif
                                </h3>
                            </div>
                        </div>
                        <div class="row section_{{ $val['album_id'] }}" <?php 
if($val['album_title']!='root'){
      ?><?php } ?>>
                            @foreach ($val['all'] as $k => $v)
                                @php
                                    $imgID = $val['album_id'] . '_' . $k;
                                @endphp
                                <div class="col-md-3 mb30" id="id_{{ $imgID }}">

                                    <div class="thumbnail">
                                        <img alt="Lights" src="{{ base_url() . $v['url'] }}" style="width:100%">
                                        <div class="myadelbtn">
                                            <a class="btn btn-success" data-bs-toggle="tooltip" data-placement="left"
                                                title="Insert Image" href="javascript:;"
                                                onclick="media_insert_img('{{ $v['url'] }}');"><i
                                                    class="fa-solid fa-cloud-download" aria-hidden="true"></i></a>

                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@if ($module->id == 36)
    <div class="modal fade" id="media_image_addition">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h4 class="modal-title">Media Library</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="folderselect">
                        <h3>Select Folder</h3>
                        <div class="btn-group">
                            @foreach ($albumsObj as $ak => $av)
                                <button type="button" class="fldbtns btn btn-default <?php if ($av['album_title'] == 'root') {
                                    echo 'active';
                                } ?>"
                                    onClick="show_section('{{ $ak }}',this)" aria-haspopup="true"
                                    aria-expanded="false">
                                    {{ $av['album_title'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @foreach ($albumsObj as $kk => $val)
                        <div class="myasection mediaup mediagalley2">
                            <div class="row mystr section_{{ $val['album_id'] }}"
                                <?php 
if($val['album_title']!='root'){
      ?><?php } ?>>

                                <div class="col-md-8">
                                    <h1>
                                        <i class="fa-solid fa-folder-open-o" aria-hidden="true"></i>
                                        {{ $val['album_title'] }}
                                    </h1>
                                </div>
                                <div class="col-md-4 text-end">
                                    <h3>

                                        {{-- <a href="javascript:;" class="btn btn-warning" onClick="edit_album({{$val['album_id']}},'{{$val['album_title']}}');" data-bs-toggle="tooltip" title="Edit Folder"><i class="fa-solid fa-edit" aria-hidden="true"></i></a> --}}
                                        @if ($val['album_title'] != 'root')
                                        @endif
                                    </h3>
                                </div>
                            </div>
                            <div class="row section_{{ $val['album_id'] }}" <?php 
if($val['album_title']!='root'){
      ?><?php } ?>>
                                @foreach ($val['all'] as $k => $v)
                                    @php
                                        $imgID = $val['album_id'] . '_' . $k;
                                    @endphp
                                    <div class="col-md-3 mb30" id="id_{{ $imgID }}">

                                        <div class="thumbnail">
                                            <img alt="Lights" src="{{ base_url() . $v['url'] }}" style="width:100%">
                                            <div class="myadelbtn">
                                                <a class="btn btn-success" data-bs-toggle="tooltip" data-placement="left"
                                                    title="Insert Image" href="javascript:;"
                                                    onclick="media_insert_portfolio('{{ $v['url'] }}');"><i
                                                        class="fa-solid fa-cloud-download" aria-hidden="true"></i></a>

                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endif
