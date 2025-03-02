@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ admin_url() }}"> <i class="fas fa-gauge"></i> Home</a>
                        </li>
                        <li class="active">Categories</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="card p-2">
                        <div class="box-header text-end" style="margin:2px 2px 0px 0px;">
                            <select name="cat" id="cat" onchange="ChangeCat(this.value)" class="form-control">
                                <option {!! selectVal(0, $catId) !!}> Main Categories</option>
                                @foreach ($allParentCategory as $catGroup)
                                    @if ($catGroup['cat'] == 0)
                                        <option {!! selectVal($catGroup['id'], $catId) !!}>-{{ $catGroup['title'] }} </option>
                                        <?php ?>
                                    @endif
                                @endforeach
                            </select>
                            <div class="myfldrow">
                                <button type="button" class="sitebtn" onClick="load_category_add_form()"> <i
                                        class="fas fa-plus-circle" aria-hidden="true"></i>
                                    Add New
                                </button>
                            </div>
                        </div>
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            {{ 'You can drag and drop to set listing order' }}
                        </div>
                        <div class="">
                            <div class="text-end" style="margin-bottom:5px; text-align:left;"></div>
                            <ul class="sorta ui-sortable">
                                @if ($result)
                                    @php
                                        $Bstatus = '';
                                        $BGcolor = '';
                                    @endphp
                                    @foreach ($result as $row)
                                        @php
                                            $bgColor = isset($bgColor) && $bgColor == '#f9f9f9' ? '#FFFFFF' : '#f9f9f9';
                                            $idDBF = $settingArr['dbId'];
                                        @endphp
                                        <li id="recordsArray_{{ $row->$idDBF }}"><i class="fas fa-arrows"
                                                aria-hidden="true"></i>
                                            @if ($row->img != '')
                                                <img style="background-color: white;"
                                                    src="{{ asset_uploads('categories/' . $row->img) }}" alt="">
                                            @endif
                                            <span id="edit_{{ $row->$idDBF }}">{{ $row->title }}</span>
                                            <a class="btn btn-sm btn-danger" href="javascript:;"
                                                onclick="delete_category_ajax('{{ $row->$idDBF }}');" title="Delete"><i
                                                    class="fas fa-trash"></i> Delete</a>

                                            <a class="btn btn-sm btn-info" title="Edit" href="javascript:;"
                                                onClick="load_category_edit_form({{ $row->$idDBF }})">
                                                {{-- onClick="getEditDiv('Edit', '{{ $settingArr['contr_name']}}', '{{ $row->$idDBF}}');"> --}}
                                                <i class="fas fa-pen-to-square" aria-hidden="true"></i> Edit</a>
                                        </li>
                                    @endforeach
                                @else
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="add_page_form" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form id="validatethis" name="myForm" method="post" action="{{ route('categories.store') }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="catId" value="{{ $catId }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Add New Category</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <div class=" card-body">
                            <div class="row">
                                <div class="col-sm-4 text-end">Title:</div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control mainInputStringForUrl" name="title"
                                        id="title" value="" />
                                </div>
                                <input type="hidden" name='slug' class='outputSlugString'>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">&nbsp;</div>
                                <div class="col-sm-6"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4 text-end">
                                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">Cancel</button>
                                </div>
                                <div class="col-sm-4 text-end">
                                    <button type="button" onclick="return submitForm_cat(myForm,'<?php echo $settingArr['contr_name']; ?>');"
                                        class="btn btn-success">Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="edit_page_form" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form id="validatethisedit" name="myForm" method="post" action="{{ route('categories.update', 0) }}"
                onSubmit="return formSubmit();" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="edit_id" id="edit_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Category</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <div class=" card-body">
                            <div class="row">
                                <div class="col-sm-4 text-end">Title:</div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="edit_title" id="edit_title"
                                        value="" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 text-end">Image:</div>
                                <div class="col-sm-8">
                                    <input type="file" class="form-control" name="cimg" id="cimg"
                                        value="" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">&nbsp;</div>
                                <div class="col-sm-6"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4 text-end">
                                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">Cancel</button>
                                </div>
                                <div class="col-sm-4 text-end">
                                    <button type="button" onclick="return editForm_cat();" class="btn btn-success">Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript">
        $(document).ready(function() {
            $(function() {
                $(".sorta").sortable({
                    opacity: 0.6,
                    cursor: 'move',
                    update: function() {
                        var order = $(this).sortable("serialize") +
                            '&action=updateRecordsListings';
                        $.get("{{ admin_url() }}categories/create",
                            order,
                            function(data) {
                                console.log(data);
                            });
                    }
                });
            });
        });

        function ChangeCat(cat) {
            window.location.href = 'categories?cat=' + cat;
        }
    </script>
    <script>
        function load_category_add_form() {
            $("#validatethis").trigger('reset');
            $('#add_page_form').modal('show');
        }

        function load_category_edit_form(id) {
            $("#validatethis").trigger('reset');
            $.ajax({
                url: " {{ admin_url() }}categories/" + id + "/edit/",
                type: "GET",
                success: function(data) {
                    console.log(data);
                    data = JSON.parse(data);
                    $('[name="edit_id"]').val(data.id);
                    $('[name="edit_title"]').val(data.title);
                    $('#edit_page_form').modal('show');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }

        function submitForm_cat(frm, contr) {
            var pageName = base_url + "adminmedia/categories";
            var parameters = $('#validatethis').serialize();
            $.ajax({
                type: "POST",
                url: pageName,
                data: parameters,
                beforeSend: function() {},
                success: function(msg) {
                    console.log(msg);
                    // $('#add_page_form').modal('close');
                    location.reload();
                }
            });
        }


        function editForm_cat() {
            var pageName = base_url + "adminmedia/categories/0";
            var parameters = $('#validatethisedit').serialize();
            $.ajax({
                type: "POST",
                url: pageName,
                data: parameters,
                beforeSend: function() {},
                success: function(msg) {
                    console.log(msg);
                    // $('#add_page_form').modal('close');
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }

        function delete_category_ajax(id) {
            if (confirm('Are you sure delete this data?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: base_url + 'adminmedia/categories/' + id,
                    type: "DELETE",
                    success: function(data) {
                        //if success reload ajax table
                        $("#recordsArray_" + id).fadeOut(1000);
                        var tolrec = $("#total_rec").html();
                        var tolrec = $("#total_rec").html(parseInt(tolrec) - 1);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error Deleting data');
                    }
                });

            }
        }
    </script>
@endsection
