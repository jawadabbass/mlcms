<style type="text/css">
    .bullet_remove {
        list-style-type: none;
    }
</style>
@extends('back.layouts.app', ['title' => $title ?? ''])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Block Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() . '' }}"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                        <li class="active">Manage Assessment Questions</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">

            @if (\Session::has('added_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>New Widgets has been created successfully.</h4>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-sm-8">
                    <h3 class="box-title">Add New Assesment Question</h3>
                </div>
                <div class="col-sm-4">
                    <div class="text-end" style="padding-bottom:2px;">

                        <a href="{{ route('assesment_question.index') }}" class="sitebtn">Go Back</a>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <ul class="bullet_remove">
                    @foreach ($errors->all() as $error)
                        <li>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                {{ $error }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="false">&times;</span>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
            @elseif(Session::has('error'))
                <div class="alert alert-warning alert-dismissible" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
            @endif
            <form enctype="multipart/form-data" role="form" method="post"
                action="{{ route('assesment_question.store') }}">
                @csrf
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" class="form-control" id="question" name="question" value="{{ old('question') }}"
                        placeholder="Question" required="">
                </div>
                <div class="form-group">
                    <label>Select Design To Ask Answer Of (Question)</label>
                    <select class="form-control" id="additional_fields" name="additional_fields"
                        onchange="additional_fields_show_hide();">
                        <option value="0">Select Pattern</option>
                        <option value="1">Radio Pattern</option>
                        <option value="2">Checkbox Pattern</option>
                        <option value="3">Input Pattern</option>
                    </select>
                </div>
                <div class="form-group" id="edit_field1" style="display: none;">
                    <h3>Radio Pattern Such As</h3>


                    <div class="col-sm-6">
                        <input type="radio" name="test_radio_box" value="Yes">&nbsp;&nbsp;Yes

                        <input type="radio" name="test_radio_box" value="No">&nbsp;&nbsp;No


                    </div>
                    <br>
                    <div class="col-sm-12">
                        <div class="row clone_equipment_target1" id="clone_equipment_target1">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row clone_equipment_target_edit1" id="clone_equipment_target_edit1">
                        </div>
                    </div>
                </div>
                <div class="form-group" id="edit_field2" style="display: none;">
                    <label>CheckBox Pattern Such As
                        <br>
                        <div class="col-sm-6">
                            <input type="Checkbox" name="test_check_box" class="form-control">
                        </div>
                    </label>

                    <div class="col-sm-12">
                        <div class="row clone_equipment_target" id="clone_equipment_target">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row clone_equipment_target_edit" id="clone_equipment_target_edit">
                        </div>
                    </div>
                </div>
                <div class="form-group" id="edit_field3" style="display: none;">
                    <label>Input Pattern</label>
                    <input type="text" class="form-control" id="edit_additional_field_title_3" name="input_field"
                        placeholder="" readonly="">
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button> --}}
                    <button type="submit" name="submitter" class="btn btn-primary">Submit Question</button>
                </div>
            </form>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script>
    <!--Widget JS functions available in back/js/admin_functions.js file-->
    <script type="text/javascript">
        $(document).ready(function() {
            for (var count = 1; count <= 8; count++) {
                $("#edit_field" + count).hide();
            }
            $("#additional_fields").on('change', function() {
                var field_value = $("#additional_fields").val();
                for (var count = 1; count <= field_value; count++) {
                    $("#edit_field" + count).show();
                }
            });
        });
    </script>
    <script type="text/javascript">
        a = 0;
        $(document).ready(function() {
            $('#first_editor').hide();



            $('#clone_equipment_target').html('');
            var new_div = '<div id="clone-equipment-div" class="clone-equipment-div">\
                                                                 <div class="row">\
                                                                <div class="col-md-8">\
                                                                <label>Enter value To Ask</label>\
                                                                <input  name="check_field[]"  class="form-control"/>\
                                                                    </div>\
                                                                <div class="col-md-1" style="margin-top:30px;">\
                                                                <div class="iconcontent">\
                                                                <a href="javascript:void(0)" id="adbtn"  onclick="clone_equipment_div()" class="btn btn-xs btn-success"><i class="fas fa-plus"></i></a></div>\
                                                             </div>\
                                                             </div>\
                                                            </div>';
            $('#clone_equipment_target').append(new_div);
            $('#clone_equipment_target_edit').html('');
            a = a + 1;
            // Set Title to Bootstrap modal title
        });
    </script>

    <script type="text/javascript">
        function clone_equipment_div() {
            var new_div = '<div id="clone-equipment-div" class="clone-equipment-div">\
                                                                <div class="row">\
                                                                <div class="col-md-8">\
                                                                <label>Enter value To Ask</label>\
                                                                <input id="conten" name="check_field[]"  class="form-control"/>\
                                                                </div>\
                                                                <div class="col-md-1" style="margin-top: 30px;">\
                                                                <div class="iconcontent">\
                                                                <a href="javascript:void(0)"  onclick="remove_equipment_div(this)" id="rmovebtn" class="btn btn-xs btn-danger"><i class="fas fa-minus"></i></a>\
                                                               </div>\
                                                                </div>\
                                                                  <div class="col-md-1" style="margin-top: 30px; margin-left:5px;">\
                                                                <div class="iconcontent">\
                                                                <a href="javascript:void(0)" id="adbtn"  onclick="clone_equipment_div()" class="btn btn-xs btn-success"><i class="fas fa-plus"></i></a></div>\
                                                                </div>\
                                                                </div>\
                                                            </div>';
            $('#clone_equipment_target').append(new_div);
            var main_equipment = $('#clone_equipment_target').closest('.clone_equipment_target');
            var counts = main_equipment.children('.clone-equipment-div').length;
            var prev = $('.clone-equipment-div').prev().find("#adbtn").hide();
            if (counts > 0) {
                $("#fstaddbtn").hide();
            }
            counts++;
            a++;
        }
        var b = 1;

        function clone_equipment_div_edit() {
            edit_index++;
            var new_div = '<div id="clone-equipment-div" class="clone-equipment-div">\
                                                                <div class="row">\
                                                                <div class="col-md-8">\
                                                                <label>Enter value To Ask</label>\
                                                                <input id="conten" name="check_field[]"  class="form-control"/>\
                                                                </div>\
                                                                <div class="col-md-1" style="margin-top: 30px;">\
                                                                <div class="iconcontent">\
                                                                <a href="javascript:void(0)" onclick="remove_equipment_div_edit(this)" id="rmovebtn" class="btn btn-xs btn-danger"><i class="fas fa-minus"></i></a>\
                                                                   </div> \
                                                                 </div>\
                                                                   <div class="col-md-1" style="margin-top: 30px; margin-left:5px;">\
                                                                <div class="iconcontent">\
                                                                <a href="javascript:void(0)" id="adbtn" onclick="clone_equipment_div_edit()" class="btn btn-xs btn-success"><i class="fas fa-plus"></i></a></div> \
                                                                 </div>\
                                                                  </div>\
                                                            </div>';
            $('#clone_equipment_target_edit').append(new_div);
            var main_equipment = $('#clone_equipment_target_edit').closest('.clone_equipment_target_edit');
            var counts = main_equipment.children('.clone-equipment-div').length;
            var prev = $('.clone-equipment-div').prev().find("#adbtn").hide();
            if (counts > 0) {
                $("#fstaddbtn").hide();
            }
            counts++;

        }

        function remove_equipment_div_edit(obj) {
            $(obj).closest('#clone-equipment-div').prev().find("#adbtn").show();
            $(obj).closest('#clone-equipment-div').remove();
            var counts = $('#clone_equipment_target_edit').children('.clone-equipment-div').length;
            if (counts == 1) {
                $("#fstaddbtn").show();
            }
        }

        function remove_equipment_div(obj) {
            $(obj).closest('#clone-equipment-div').prev().find("#adbtn").show();
            $(obj).closest('#clone-equipment-div').remove();
            var counts = $('#clone_equipment_target').children('.clone-equipment-div').length;
            if (counts == 1) {
                $("#fstaddbtn").show();
            }
        }

        function uniqId() {
            return Math.round(new Date().getTime() + (Math.random() * 100));
        }
    </script>
    <script type="text/javascript">
        d = 0;
        $(document).ready(function() {



            $('#clone_equipment_target1').html('');
            var new_div = '<div id="clone-equipment-div1" class="clone-equipment-div1">\
                                                                 <div class="row">\
                                                                <div class="col-md-8">\
                                                                <label>Enter value To Ask</label>\
                                                                <input  name="radio_field[]"  class="form-control"/>\
                                                                    </div>\
                                                                <div class="col-md-1" style="margin-top:30px;">\
                                                                <div class="iconcontent">\
                                                                <a href="javascript:void(0)" id="adbtn"  onclick="clone_equipment_div1()" class="btn btn-xs btn-success"><i class="fas fa-plus"></i></a></div>\
                                                             </div>\
                                                             </div>\
                                                            </div>';
            $('#clone_equipment_target1').append(new_div);
            $('#clone_equipment_target_edit1').html('');
            d = d + 1;
            // Set Title to Bootstrap modal title
        });
    </script>
    <script type="text/javascript">
        function clone_equipment_div1() {
            var new_div = '<div id="clone-equipment-div1" class="clone-equipment-div1">\
                                                                <div class="row">\
                                                                <div class="col-md-8">\
                                                                <label>Enter value To Ask</label>\
                                                                <input id="conten" name="radio_field[]"  class="form-control"/>\
                                                                </div>\
                                                                <div class="col-md-1" style="margin-top: 30px;">\
                                                                <div class="iconcontent">\
                                                                <a href="javascript:void(0)"  onclick="remove_equipment_div1(this)" id="rmovebtn" class="btn btn-xs btn-danger"><i class="fas fa-minus"></i></a>\
                                                               </div>\
                                                                </div>\
                                                                  <div class="col-md-1" style="margin-top: 30px; margin-left:5px;">\
                                                                <div class="iconcontent">\
                                                                <a href="javascript:void(0)" id="adbtn"  onclick="clone_equipment_div1()" class="btn btn-xs btn-success"><i class="fas fa-plus"></i></a></div>\
                                                                </div>\
                                                                </div>\
                                                            </div>';
            $('#clone_equipment_target1').append(new_div);
            var main_equipment = $('#clone_equipment_target1').closest('.clone_equipment_target1');
            var counts = main_equipment.children('.clone-equipment-div1').length;
            var prev = $('.clone-equipment-div1').prev().find("#adbtn").hide();
            if (counts > 0) {
                $("#fstaddbtn").hide();
            }
            counts++;
            d++;
        }
        var e = 1;

        function clone_equipment_div_edit1() {
            edit_index++;
            var new_div = '<div id="clone-equipment-div1" class="clone-equipment-div1">\
                                                                <div class="row">\
                                                                <div class="col-md-8">\
                                                                <label>Enter value To Ask</label>\
                                                                <input id="conten" name="radio_field[]"  class="form-control"/>\
                                                                </div>\
                                                                <div class="col-md-1" style="margin-top: 30px;">\
                                                                <div class="iconcontent">\
                                                                <a href="javascript:void(0)" onclick="remove_equipment_div_edit1(this)" id="rmovebtn" class="btn btn-xs btn-danger"><i class="fas fa-minus"></i></a>\
                                                                   </div> \
                                                                 </div>\
                                                                   <div class="col-md-1" style="margin-top: 30px; margin-left:5px;">\
                                                                <div class="iconcontent">\
                                                                <a href="javascript:void(0)" id="adbtn" onclick="clone_equipment_div_edit1()" class="btn btn-xs btn-success"><i class="fas fa-plus"></i></a></div> \
                                                                 </div>\
                                                                  </div>\
                                                            </div>';
            $('#clone_equipment_target_edit1').append(new_div);
            var main_equipment = $('#clone_equipment_target_edit1').closest('.clone_equipment_target_edit1');
            var counts = main_equipment.children('.clone-equipment-div1').length;
            var prev = $('.clone-equipment-div1').prev().find("#adbtn").hide();
            if (counts > 0) {
                $("#fstaddbtn").hide();
            }
            counts++;

        }

        function remove_equipment_div_edit1(obj) {
            $(obj).closest('#clone-equipment-div1').prev().find("#adbtn").show();
            $(obj).closest('#clone-equipment-div1').remove();
            var counts = $('#clone_equipment_target_edit1').children('.clone-equipment-div1').length;
            if (counts == 1) {
                $("#fstaddbtn").show();
            }
        }

        function remove_equipment_div1(obj) {
            $(obj).closest('#clone-equipment-div1').prev().find("#adbtn").show();
            $(obj).closest('#clone-equipment-div1').remove();
            var counts = $('#clone_equipment_target1').children('.clone-equipment-div1').length;
            if (counts == 1) {
                $("#fstaddbtn").show();
            }
        }

        function uniqId() {
            return Math.round(new Date().getTime() + (Math.random() * 100));
        }
    </script>
    <!-- Filer -->
    
    
    <script type="text/javascript" src="{{ asset('back/js/fileUploader2.js') }}"></script>
@endsection
