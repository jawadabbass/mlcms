@extends('back.layouts.app', ['title' => $title])

@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ admin_url() }}">
                                <i class="fas fa-gauge"></i> Home
                            </a>
                        </li>
                        <li><a href="{{ admin_url() }}module/{{ $module->type }}">{{ $module->title }}</a></li>
                        <li class="active">Ordering</li>
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
                    <div class="card p-2">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="box-header">
                                    <h3 class=" card-title"> {{ ucwords($module->title) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            You can drag and drop to set order.
                        </div>
                        <!-- /.box-header -->
                        <div class=" card-body table-responsive">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>

                                        <th>Image</th>
                                        <th>{{ ucwords($module->term) }} Heading</th>
                                        <th> Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @forelse($moduleMembers as $moduleMember)
                                        <tr id="{{ $moduleMember->id }}">

                                            <td>
                                                @if ($moduleMember->featured_img != '')
                                                    <img width="100"
                                                        src="{{ asset_uploads('') }}module/{{ $module->type }}/{{ $moduleMember->featured_img }}"
                                                        alt="">
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $moduleMember->heading }}</td>
                                            <td> @php echo format_date($moduleMember->dated,'date_time'); @endphp</td>
                                            <td>
                                                <span></span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" align="center" class="text-red">No Record found!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    
    <script>
        var module = '{{ $module->type }}';
        $(function() {
            $('#sortable').sortable({
                axis: 'y',
                opacity: 0.7,
                handle: 'span',
                update: function(event, ui) {
                    var list_sortable = $(this).sortable('toArray').toString();
                    // change order in the database using Ajax
                    console.log(list_sortable);
                    $.ajax({
                        url: base_url + 'adminmedia/module/ordering-set/' + module,
                        type: 'GET',
                        data: {
                            list_order: list_sortable
                        },
                        success: function(data) {
                            console.log(data);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error adding / update data ' + ' ' + textStatus + ' ' + errorThrown);
                            console.log(jqXHR);
                            console.log(textStatus);
                            console.log(errorThrown);
                        }
                    });
                }
            }); // fin sortable
        });
    </script>
@endsection
