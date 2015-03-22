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
  getAllVendors('activated');
  getAllVendors('pending');
  getAllVendors('deactivated');
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
          <div class="notification-bar" id="msg" style="display: none;"></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="mode">Add </span> Category</h4>
      </div>
      <div class="modal-body">
<int>

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
              <h1>Vendors  <!-- <button type="button" data-toggle="modal" data-target="#addcat" onclick="showAddPopup();" class="btn btn-primary">Add Category</button>  --> </h1>
                 <img src="images/spinner.gif" style="position:absolute; left:81%; display:none;" id="search_spinner">       
                 <input type="text" id="search" name="search" value="" placeholder="Search Vendor" onkeyup="searchVendor(this.value);" style="float:right;">
            </div>
          </div><!--col-md-12 end-->
<div class="tab-container">
       
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#active">Active <span id="activated_count">(0)</span></a></li>
                <li><a data-toggle="tab" href="#pending">Pending <span id="pending_count">(0)</span></a></li>
                <li><a data-toggle="tab" href="#deactive">Deactive <span id="deactivated_count">(0)</span></a></li>
              </ul>
              <div class="tab-content">
          <div class="notification-bar" id="statusmsg" style="display: none;"></div>
                <div id="active" class="tab-pane active cont"  style="height:100%;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Name   </th>
                        <th>Business Name <i class="fa fa-sort business_nameall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'business_name', 'vendors', 'activated');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'business_name', 'vendors', 'activated');" class="fa fa-sort-asc business_nameasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'business_name', 'vendors', 'activated');" class="fa fa-sort-desc business_namedesc"></i></th>
                        <th>Created on <i class="fa fa-sort date_createdall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'date_created', 'vendors', 'activated');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'date_created', 'vendors', 'activated');" class="fa fa-sort-asc date_createdasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'date_created', 'vendors', 'activated');" class="fa fa-sort-desc date_createddesc"></i></th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="activatedbody">

                    </tbody>
                  </table>
                <div id="activatedpagination" style="text-align:center;"></div>

                </div>
                <div id="pending" class="tab-pane cont"  style="height:100%;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Id</th>                      
                        <th>Name</th>
                        <th>Business Name <i class="fa fa-sort business_nameall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'business_name', 'vendors', 'pending');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'business_name', 'vendors', 'pending');" class="fa fa-sort-asc business_nameasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'business_name', 'vendors', 'pending');" class="fa fa-sort-desc business_namedesc"></i></th>
                        <th>Created on <i class="fa fa-sort date_createdall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'date_created', 'vendors', 'pending');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'date_created', 'vendors', 'pending');" class="fa fa-sort-asc date_createdasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'date_created', 'vendors', 'pending');" class="fa fa-sort-desc date_createddesc"></i></th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="pendingbody">

                    </tbody>
                  </table>
                                  <div id="pendingpagination" style="text-align:center;"></div>

                </div>
                <div id="deactive" class="tab-pane" style="height:100%;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Id</th>                                            
                        <th>Name</th>
                        <th>Business Name <i class="fa fa-sort business_nameall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'business_name', 'vendors', 'deactivated');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'business_name', 'vendors', 'deactivated');" class="fa fa-sort-asc business_nameasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'business_name', 'vendors', 'deactivated');" class="fa fa-sort-desc business_namedesc"></i></th>
                        <th>Created on <i class="fa fa-sort date_createdall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'date_created', 'vendors', 'deactivated');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'date_created', 'vendors', 'deactivated');" class="fa fa-sort-asc date_createdasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'date_created', 'vendors', 'deactivated');" class="fa fa-sort-desc date_createddesc"></i></th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="deactivatedbody">

                    </tbody>
                  </table>
                <div id="deactivatedpagination" style="text-align:center;"></div>

                </div>
              </div>
            </div>

        </div><!--row end-->
      </div><!--scrollable wrapper end--> 
    </div><!--margin-container end--> 
  </div><!--main end--> 
</div><!--layout-container end--> 
</body>
</html>