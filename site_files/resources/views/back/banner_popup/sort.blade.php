<div class="content-wrapper pl-3 pr-2">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-md-5 col-sm-12">
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ base_url() . 'adminmedia' }}">
                            <i class="fas fa-tachometer-alt"></i> Home
                        </a>
                    </li>
                    <li class="active">Banner Popups</li>
                </ol>
            </div>
            <div class="col-md-7 col-sm-12">
                @include('back.common_views.quicklinks')
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="box-header">
                                <h3 class="box-title">Sort Banner Popups</h3>
                            </div>
                        </div>
                        <div class="col-sm-4 text-right">
                            <a wire:navigate href="{{ route('banner-popups-list') }}" class="sitebtn">Banner Popups</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <h3>Drag and Drop to Sort</h3>
                        @if (!empty($message))
                            <div class="alert alert-success">{{ $message }}</div>
                        @endif
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <ul id="sortable" class="bannerPopUpsSortable">
                                    @foreach ($bannerPopUpsCollection as $bannerPopUpsObj)
                                        <li class="ui-state-default" id="{{ $bannerPopUpsObj->id }}"><i
                                                class="fas fa-sort"></i> {{ $bannerPopUpsObj->banner_title }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@script
    <script>
        $('.bannerPopUpsSortable').sortable({
            placeholder: "ui-state-highlight",
            update: function(event, ui) {
                var bannerPopupsOrder = $(this).sortable('toArray').toString();
                @this.dispatch('banner-popups-sort-update', {
                    bannerPopupsOrder: bannerPopupsOrder
                });
            }
        });
    </script>
@endscript
