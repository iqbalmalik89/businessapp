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
  getAllEvents('onging');
  getAllEvents('pending');
  getAllEvents('expired');  
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
<div class="modal fade" id="addevent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<input type="hidden" id="event_id" value="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <div class="notification-bar" id="msg" style="display: none;"></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="mode">Add </span> Event </h4>
      </div>
      <div class="modal-body">


<div class="container">
  <div class="row clearfix">
    <div class="col-md-10 column">
      <form class="form-horizontal" role="form" onsubmit="return false;">
        <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label">First Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="first_name" />
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
           <label for="inputEmail3" class="col-sm-2 control-label">Last Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="last_name" />
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
           <label for="inputEmail3" class="col-sm-2 control-label">Event Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="event_name" />
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
           <label for="inputEmail3" class="col-sm-2 control-label">Venue</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="venue" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>



  <!-- <div class="row clearfix">
    <div class="col-md-10 column">
      <form enctype="multipart/form-data">
           <div class="form-group">
                  <input id="deals_images" class="file" type="file" multiple="true" data-upload-url="../slim.php/api/upload_images?path=deals_images">
          </div>

      </form>
    </div>
  </div> -->




      </div>
      <div class="modal-footer">
        <img src="images/spinner.gif" id="spinner" style="position:absolute; right:150px; display:none;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="addUpdateEvent();" class="btn btn-primary">Save</button>
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
              <h1>Events  <!-- <button type="button" data-toggle="modal" data-target="#addevent" onclick="showEventAddPopup();" class="btn btn-primary">Add Event</button> -->  </h1>
                 <img src="images/spinner.gif" style="position:absolute; left:81%; display:none;" id="search_spinner">       
                 <input type="text" id="search" name="search" value="" placeholder="Search Event" onkeyup="searchEvent(this.value);" style="float:right;">

            </div>
          </div><!--col-md-12 end-->
          <div class="tab-container">
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#active"> Ongoing<span id="ongoing_count">(0)</span></a></li>
                <li><a data-toggle="tab" href="#pending">Pending <span id="pending_count">(0)</span></a></li>
                <li><a data-toggle="tab" href="#deactive">Expired <span id="expired_count">(0)</span></a></li>
              </ul>
              <div class="tab-content">
          <div class="notification-bar" id="statusmsg" style="display: none;"></div>
                <div id="active" class="tab-pane active cont" style="height:100%;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Event Name <i class="fa fa-sort event_nameall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'event_name', 'events', 'ongoing');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'event_name', 'events', 'ongoing');" class="fa fa-sort-asc event_nameasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'event_name', 'events', 'ongoing');" class="fa fa-sort-desc event_namedesc"></i></th>
                        <th>Start Date <i class="fa fa-sort start_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'start_date', 'events', 'ongoing');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'start_date', 'events', 'ongoing');" class="fa fa-sort-asc start_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'start_date', 'events', 'ongoing');" class="fa fa-sort-desc start_datedesc"></i></th>
                        <th>End Date <i class="fa fa-sort end_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'end_date', 'events', 'ongoing');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'end_date', 'events', 'ongoing');" class="fa fa-sort-asc end_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'end_date', 'events', 'ongoing');" class="fa fa-sort-desc end_datedesc"></i></th>
                        <th>Venue</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="ongoingbody">

                    </tbody>
                  </table>
                  <div id="ongoingpagination" style="text-align:center;"></div>                  
                </div>
                <div id="pending" class="tab-pane cont"  style="height:100%;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Event Name <i class="fa fa-sort event_nameall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'event_name', 'events', 'pending');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'event_name', 'events', 'pending');" class="fa fa-sort-asc event_nameasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'event_name', 'events', 'pending');" class="fa fa-sort-desc event_namedesc"></i></th>
                        <th>Start Date <i class="fa fa-sort start_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'start_date', 'events', 'pending');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'start_date', 'events', 'pending');" class="fa fa-sort-asc start_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'start_date', 'events', 'pending');" class="fa fa-sort-desc start_datedesc"></i></th>
                        <th>End Date <i class="fa fa-sort end_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'end_date', 'events', 'pending');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'end_date', 'events', 'pending');" class="fa fa-sort-asc end_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'end_date', 'events', 'pending');" class="fa fa-sort-desc end_datedesc"></i></th>
                        <th>Venue</th>
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
                        <th>Name</th>
                        <th>Event Name <i class="fa fa-sort event_nameall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'event_name', 'events', 'expired');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'event_name', 'events', 'expired');" class="fa fa-sort-asc event_nameasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'event_name', 'events', 'expired');" class="fa fa-sort-desc event_namedesc"></i></th>
                        <th>Start Date <i class="fa fa-sort start_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'start_date', 'events', 'expired');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'start_date', 'events', 'expired');" class="fa fa-sort-asc start_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'start_date', 'events', 'expired');" class="fa fa-sort-desc start_datedesc"></i></th>
                        <th>End Date <i class="fa fa-sort end_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'end_date', 'events', 'expired');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'end_date', 'events', 'expired');" class="fa fa-sort-asc end_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'end_date', 'events', 'expired');" class="fa fa-sort-desc end_datedesc"></i></th>
                        <th>Venue</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="expiredbody">

                </tbody>
              </table>
                  <div id="expiredpagination" style="text-align:center;"></div>
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