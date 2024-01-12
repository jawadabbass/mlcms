<script src="{{ asset_storage('back/js/jquery.min.js') }}"></script>
<script src="{{ asset_storage('back/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset_storage('back/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset_storage('back/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js') }}"></script>
<script src="{{ asset_storage('back/js/plugins/timepicker/bootstrap-timepicker.min.js') }}" type="text/javascript">
</script>
<script type="text/javascript" src="{{ asset_storage('back/js/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset_storage('module/module/admin/filer/js/jquery.filer.min.js') }}"></script>
<script src="{{ asset_storage('back/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset_storage('back/js/tinymce_embed.js') }}"></script>
<script src="{{ asset_storage('back/js/admin_functions.js?v=22') }}" type="text/javascript"></script>
<script src="{{ asset_storage('select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset_storage('back/datetimepicker/build/jquery.datetimepicker.full.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset_storage('lib/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset_storage('lib/jquery-validation/dist/additional-methods.min.js') }}"></script>
<script src="{{ asset_storage('lib/inputmask/dist/jquery.inputmask.js') }}"></script>
<script src="{{ asset_storage('lib/sweetalert/sweetalert2.all.min.js') }}"></script>
<script defer src="https://cdn.jsdelivr.net/npm/img-comparison-slider@8/dist/index.js"></script>
<script src="{{ asset_storage('lib/chartjs/dist/chart.umd.js') }}"></script>
<script src="{{ asset_storage('back/js/AdminLTE/dist/js/adminlte.min.js') }}"></script>

@include('back.common_views.common_state_county_city_functions')
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    @php
        $message = session('message', '');
        $type = session('type', 'success');
        session(['message' => '', 'type' => '']);
    @endphp
    @if (!empty($message))
        Toast.fire({
            icon: "{{ $type }}",
            title: "{{ $message }}"
        });
    @endif
</script>
