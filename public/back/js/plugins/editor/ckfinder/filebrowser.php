<?php 
if(isset($_SERVER['HTTP_REFERER'])){
    $baseUrl = $_SERVER['HTTP_REFERER'];
    if(strpos($baseUrl,'public/') !== false){
        $baseUrl = explode('public/', $baseUrl);
        $baseUrl = $baseUrl[0];
        $baseUrl = $baseUrl . 'adminmedia/';
    }else if(strpos($baseUrl,'adminmedia/') !== false){
        $baseUrl = explode('adminmedia/', $baseUrl);
        $baseUrl = $baseUrl[0];
        $baseUrl = $baseUrl . 'adminmedia/';
    }
}else{
    $baseUrl =  $_SERVER['PHP_SELF'];
    if(strpos($baseUrl,'public/') !== false){
        $baseUrl = explode('public/', $baseUrl);
        $baseUrl = $baseUrl[0];
        $baseUrl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME']. $baseUrl . 'adminmedia/';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
	<title>File Manager</title>
        <style type="text/css">
            .ui-title{ display:none !important; }
            .ui-icon-ckf-file-delete{ display:none !important; }
        </style>
</head>
<body>
<div id="file_manager"></div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            url: "<?php echo $baseUrl ?>home/ajax_validate_admin",
            type: "POST",
            success: function (data)
            {
                $('#file_manager').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                //alert('Error get data from ajax');
            }
        });
    });
       
</script>
</body>
</html>

