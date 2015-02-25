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
  getVendorDeals(<?php echo $_GET['vendor_id']; ?>)
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
<div class="modal fade" id="addcat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<input type="hidden" id="cat_id" value="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="mode">Add </span> Category</h4>
      </div>
      <div class="modal-body">


<div class="container">
  <div class="row clearfix">
    <div class="col-md-10 column">
      <form class="form-horizontal" role="form" onsubmit="return false;">
        <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label">Category Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="cat_name" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


      </div>
      <div class="modal-footer">
        <img src="images/spinner.gif" id="spinner" style="position:absolute; right:150px; display:none;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="addUpdateCategory();" class="btn btn-primary">Save</button>
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
              <h1>Vendor Deals  <!-- <button type="button" data-toggle="modal" data-target="#addcat" onclick="showAddPopup();" class="btn btn-primary">Add Category</button>  --> </h1>
            </div>
          </div><!--col-md-12 end-->

        </div><!--row end-->
          <div class="notification-bar" id="dealsmsg" style="display: none;"></div>


        <div class="row" id="vendor_deals">



        </div><!--row end-->

        <button type="button"  id="dealsave" onclick="saveVendorDeals(<?php echo $_GET['vendor_id']; ?>);" class="btn btn-primary">Save</button>


      </div><!--scrollable wrapper end--> 
    </div><!--margin-container end--> 
  </div><!--main end--> 
</div><!--layout-container end--> 
</body>
</html>