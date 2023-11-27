@if (!is_null($frontPageBannerPopup))
    @if ($frontPageBannerPopup->status == 'active')
        <!-- Modal -->
        <div class="modal fade" id="front_banner_popup_modal" tabindex="-1" role="dialog"
            aria-labelledby="front_banner_popup_modalTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        {!! $frontPageBannerPopup->content !!}
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div> --}}
                </div>
            </div>
        </div>
        @section('beforeBodyClose')
            <script>
                $(document).ready(function() {
                    $("#front_banner_popup_modal").modal('show');
                });
            </script>
        @endsection
    @endif
@endif
