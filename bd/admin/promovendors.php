<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Atom-Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include('inc/js.php') ;?>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

<script>
$( document ).ready(function() {
  getAllVendors();
<?php
  if(isset($_GET['vendor_id']))
  {
    ?>
    $('#addpromo').modal('show'); 
    $('#promohtml').val(<?php echo $_GET['vendor_id']; ?>);
    <?php
  }

?>  
getPromoVendors();
    var checkout = $('#start_date').datepicker({
            format: 'yyyy-mm-dd'
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');;

    var checkout2 = $('#end_date').datepicker({
            format: 'yyyy-mm-dd'
        }).on('changeDate', function(ev) {
          checkout2.hide();
        }).data('datepicker');;

    $("#promo_vendors_images").fileinput({
        uploadUrl: 'index.php', // you must set a valid URL here else you will get an error
        allowedFileExtensions : ['jpg', 'png','gif'],
        overwriteInitial: false,
        maxFileSize: 1000,
        maxFilesNum: 10,
        //allowedFileTypes: ['image', 'video', 'flash'],
        slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
  });
});
</script>
</head>
<body>
<!--layout-container start-->
<div id="layout-container"> 
  <!--Left navbar start-->
  
<?php
  include('inc/left.php');
?>
  <!--main start-->
<!-- Modal -->
<div class="modal fade" id="addpromo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<input type="hidden" id="promo_vendor_id" value="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <div class="notification-bar" id="msg" style="display: none;"></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="mode">Add </span>Promo Vendor</h4>
      </div>
      <div class="modal-body">


<div class="container">
  <div class="row clearfix">
    <div class="col-md-10 column">
      <form class="form-horizontal" role="form" onsubmit="return false;">
        <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label"></label>
          <div class="col-sm-4">
          <input type="text" id="search" name="search" value="" placeholder="Search Vendor" onkeyup="searchVendor(this.value);">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>



<div class="container">
  <div class="row clearfix">
    <div class="col-md-10 column">
      <form class="form-horizontal" role="form" onsubmit="return false;">
        <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label">Vendor</label>
          <div class="col-sm-4">
            <select id = 'promohtml'>
            </select>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row clearfix">
    <div class="col-md-10 column">
      <form class="form-horizontal" role="form" onsubmit="return false;">
        <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label">Start Date</label>
          <div class="col-sm-4">
            <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="start_date" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row clearfix">
    <div class="col-md-10 column">
      <form class="form-horizontal" role="form" onsubmit="return false;">
        <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label">End Date</label>
          <div class="col-sm-4">
            <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="end_date" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

  <div class="row clearfix">
  <div id="existing_images"></div>
  </div>
  <div class="row clearfix">
    <div class="col-md-10 column">
      <form enctype="multipart/form-data">
           <div class="form-group">
                  <input id="promo_vendors_images" class="file" type="file" multiple="true" data-upload-url="../slim.php/api/upload_images?path=promo_images">
          </div>

      </form>
    </div>
  </div>




      </div>
      <div class="modal-footer">
        <img src="images/spinner.gif" id="spinner" style="position:absolute; right:150px; display:none;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="addEditPromoVendors();" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

  <div id="main">





  <?php
    include('inc/nav.php');
  ?>
    <!--margin-container start-->
    <div class="margin-container">
    <!--scrollable wrapper start-->
      <div class="scrollable wrapper">
      <!--row start-->
        <div class="row">
         <!--col-md-12 start-->
          <div class="col-md-12">
            <div class="page-heading">
              <h1>Promo Vendors  <button type="button" data-toggle="modal" data-target="#addpromo" onclick="showPromoAddPopup();" class="btn btn-primary">Add Promo Vendors</button>  </h1>
            </div>
          </div><!--col-md-12 end-->
          <div class="col-sm-6 col-md-12">
            <div class="box-info">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Vendor Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="dealbody">

                </tbody>
              </table>
            </div>
          </div>

        </div><!--row end-->
      </div><!--scrollable wrapper end--> 
    </div><!--margin-container end--> 
  </div><!--main end--> 
</div><!--layout-container end--> 
<script>
</script>

</body>
</html>