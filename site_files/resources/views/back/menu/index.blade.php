@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    @php $module = 'menu' @endphp
    <link rel="stylesheet" href="{{ asset_storage('') . 'module/menu/admin/drag/stylesheet.css' }}" type="text/css">
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Positioning Navigations</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ admin_url() }}">
                        <i class="fas fa-gauge"></i> Home
                    </a>
                </li>
                <!--<li><a href="#">Examples</a></li>-->
                <li class="active">Positioning Navigations</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            @php echo myform_getmsg('Drag and drop to set menu order.', 'w') @endphp
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="card p-2">
                        <div class="box-header">
                            <h3 class=" card-title">
                                @if ($menu_types)
                                    @foreach ($menu_types as $types)
                                        <a href="{{ admin_url() . 'menus?position=' . $types->menu_type }}"
                                            class="btn btn-{{ $position == $types->menu_type ? 'success' : 'default' }} btn-md">{{ ucfirst($types->menu_type) }}</a>
                                    @endforeach
                                @endif
                            </h3>
                            <div class="text-end" style="padding-bottom:2px;">
                                <input type="button" class="btn btn-primary btn-sm" value="Add Menu"
                                    onclick="add_menu()" />
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class=" card-body table-responsive">
                            <div class="text-end" style="padding-bottom:2px;">
                            </div>
                            <div class="menu-menagement">
                                <ul id="sTree2" class="sTree2 listsClass">
                                    @if ($parent_pages)
                                        @foreach ($parent_pages as $key => $row)
                                            @php
                                                display_with_children($row, 0, $type->id);
                                            @endphp
                                        @endforeach
                                    @endif
                                </ul>
                                <input type="button" class="btn btn-primary btn-sm" onclick="saveMyTree()" value="Save">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('back.menu.add_edit_view')
@endsection
@section('beforeBodyClose')
    <script type="text/javascript" src="{{ asset_storage('') . 'module/menu/admin/drag/jquery-sortable-lists.js' }}"></script>
    {{-- <script type="text/javascript" --}}
    {{-- src="{{asset_storage('') . 'module/menu/admin/js/menu.js'}}"></script> --}}
    
    @include('back.menu.menu_js')
    <!-- End Bootstrap modal -->
    <script type="text/javascript">
        $(function() {
            var options = {
                ignoreClass: 'clickable',
                placeholderCss: {
                    'background-color': '#ff8'
                },
                hintCss: {
                    'background-color': '#bbf'
                },
                onChange: function(cEl) {
                    console.log('onChange');
                },
                complete: function(cEl) {
                    console.log('complete');
                },
                isAllowed: function(cEl, hint, target) {
                    // Be carefull if you test some ul/ol elements here.
                    // Sometimes ul/ols are dynamically generated and so they have not some attributes as natural ul/ols.
                    // Be careful also if the hint is not visible. It has only display none so it is at the previouse place where it was before(excluding first moves before showing).
                    if (target.data('module') === 'c' && cEl.data('module') !== 'c') {
                        hint.css('background-color', '#ff9999');
                        return false;
                    } else {
                        hint.css('background-color', '#99ff99');
                        return true;
                    }
                },
                opener: {
                    active: true,
                    as: 'html', // if as is not set plugin uses background image
                    close: '<i class="fas fa-minus c3"></i>', // or 'fa-minus c3',  // or './imgs/Remove2.png',
                    open: '<i class="fas fa-plus"></i>', // or 'fa-plus',  // or'./imgs/Add2.png',
                    openerCss: {
                        'display': 'inline-block',
                        //'width': '18px', 'height': '18px',
                        'float': 'left',
                        'margin-left': '-35px',
                        'margin-right': '5px',
                        //'background-position': 'center center', 'background-repeat': 'no-repeat',
                        'font-size': '1.1em'
                    }
                },
                ignoreClass: 'clickable'
            };
            $('.listsClass').sortableLists(options);
        });

        function saveMyTree() {
            var saveString = $('#sTree2').sortableListsToString();
            var url = '{{ admin_url() }}menus/0?' + saveString;
            console.log(url);
            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    if (data == 'done') {
                        $('#sorting_updated').show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data ' + ' ' + textStatus + ' ' + errorThrown);
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }
    </script>
@endsection
