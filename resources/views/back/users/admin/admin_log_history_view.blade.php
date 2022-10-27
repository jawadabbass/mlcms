<!DOCTYPE html>fa-solid 
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title;?></title>
<?php $this->load->view(base_url_admin.'/common/meta_tags'); ?>
<?php $this->load->view(base_url_admin.'/common/before_head_close'); ?>
</head>
<body class="<?php echo skin_class();?>">
<?php $this->load->view(base_url_admin.'/common/after_body_open'); ?>
<?php $this->load->view(base_url_admin.'/common/header'); ?>
<div class="wrapper row-offcanvas row-offcanvas-left">
<?php $this->load->view(base_url_admin.'/common/left_side'); ?>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side {{(session('leftSideBar') == 1)?'strech':''}}">

  <!-- Content Header (Page header) -->

  <section class="content-header">
  	<div class="row">
                        <div class="col-md-3">
                        	 <h1> View Log </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(base_url_admin.'/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">User Log History</li>
    </ol>
                        </div>
                        <div class="col-md-9">
                        <?php $this->load->view('../../common_views/quicklinks'); ?>
                        </div>
                    </div>


  </section>

  <!-- Main content -->

  <section class="content">
    <div class="row">
      <div class="col-xs-12 col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">All Users Log History</h3>
          </div>

          <!-- /.box-header -->

          <div class="box-body table-responsive">
            <div class="text-end" style="padding-bottom:2px;"> <a type="button" class="btn btn-danger btn-sm" href="<?php echo base_url(base_url_admin.'/admin_log_history/truncate');?>">Empty Log</a> </div>
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Admin Name</th>
                  <th>Session Start Date/Time</th>
                  <th>Session End Date/Time</th>
                  <th>Duration </th>
                  <th>IP Address</th>
                </tr>
              </thead>
              <tbody>
                <?php
				if($result){
                	foreach($result as $row) {
                 ?>
                <tr id="row_<?php echo $row->ID;?>">
                  <td><?php echo $row->admin_name;?></td>
                  <td><?php echo date_formats($row->session_start, 'M d, Y').' <small>at</small> '.date_formats($row->session_start, 'h:i A');?></td>
                  <td><?php if($row->session_end == '0000-00-00 00:00:00'){echo "Did not logout";} else { echo date_formats($row->session_end, 'M d, Y').' <small>at</small> '.date_formats($row->session_end, 'h:i A'); }?></td>
                  <td><?php echo ($row->session_end == '0000-00-00 00:00:00')?'Did not logout':dateDiff($row->session_start, $row->session_end);?></td>
                  <td><?php echo $row->ip_address;?></td>
                </tr>
                <?php
                }
				} else {?>
                <tr>
                  <td colspan="7">No record found!</td>
                </tr>
                <?php }
                ?>
              </tbody>
              <tfoot>
              </tfoot>
            </table>
          </div>

          <!-- /.box-body -->

        </div>

        <!-- /.box -->

        <!-- /.box -->

      </div>
    </div>
  </section>

  <!-- /.content -->

</aside>
<!-- /.right-side -->
<!-- ./wrapper -->
<?php $this->load->view(base_url_admin.'/common/footer'); ?>
