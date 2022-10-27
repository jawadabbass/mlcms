<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <form action="#" id="form" class="form-horizontal">
            @csrf
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">Menu Form</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body form">
                    <div class="box-body">
                        <input type="hidden" value="" name="id" />
                        <input type="hidden" value="" name="menu_actual_id" />
                        <div class="form-body">
                            <div>
                                <label class="form-label">Menu Label</label>
                                <input name="menu_label" placeholder="Menu Label" class="form-control" type="text">
                                <span id="menu_label" style="padding-left:2px;" class="err"></span>
                            </div>
                            <div id="hide_fileds">
                                <div>
                                    <label class="form-label">Menu URL @php echo helptooltip('proper_url')@endphp </label>
                                    <div class="mb-2">
                                        <span class="mb-2-addon" id="base_url_id">{{ env('APP_URL') }}</span>
                                        <input name="menu_url" placeholder="Menu URL" class="form-control"
                                            type="text">
                                    </div>
                                    <span id="menu_url" style="padding-left:2px;" class="err"></span>
                                </div>
                            </div>
                            <div id="hide_types">
                                <div>
                                    <label class="form-label">Show this page in</label><br>
                                    @if ($menu_types)
                                        @foreach ($menu_types as $meny_type)
                                            <label class="form-label"><input name="menu_type[]" value="{{ $meny_type->id }}"
                                                    type="checkbox" /> {{ ucfirst($meny_type->menu_type) }}
                                                Menu</label>
                                        @endforeach
                                    @endif
                                    <br />
                                    <span id="menu_type" style="padding-left:2px;" class="err"></span>
                                </div>
                            </div>
                            <div>
                                <label class="form-label">
                                    <input name="open_in_new_window" id="open_in_new_window" value="yes"
                                        type="checkbox" /> Open In New Window</label>
                                <br>
                            </div>
                            <div>
                                <label class="form-label">
                                    <input name="show_no_follow" id="show_no_follow" value="1" type="checkbox" />
                                    No
                                    follow
                                </label><br>
                            </div>
                            <div>
                                <label class="form-label">
                                    <input name="is_external_link" id="is_external_link" value="Y"
                                        type="checkbox" /> External Link</label><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
