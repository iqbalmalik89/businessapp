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



         // jQuery(function(){
         //  jQuery('#start_date').datetimepicker({
         //   //format:'Y/m/d',
         //   mask:'9999/19/39 29:59',  
         //   onShow:function( ct ){
         //    this.setOptions({
         //     minDate:jQuery('#end_date').val()?jQuery('#end_date').val():false
         //    })
         //   },
         //   timepicker:true
         //  });
         //  jQuery('#end_date').datetimepicker({
         // //  format:'Y/m/d',
         //   mask:'9999/19/39 29:59',    
         //   onShow:function( ct ){
         //    this.setOptions({
         //     minDate:jQuery('#start_date').val()?jQuery('#start_date').val():false
         //    })
         //   },
         //   timepicker:true
         //  });
         // });


$( document ).ready(function() {





      getCountries(true);
  getSingleEvent(<?php echo $_GET['id']; ?>)
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

<input type="hidden" id="vendor_id" value="<?php echo $_GET['id'];;?>">
  <!--main start-->
<!-- Modal -->
<div class="modal fade" id="addcat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

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
        <button type="button" onclick="addBusiness();" class="btn btn-primary">Save</button>
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

 <div class="row" style="padding:20px;">
                  <div class="well well-sm">

     <!-- Form Start Here-->        
                     <form>
                           <div class="alert alert-success" role="alert" style="display:none;"></div>
                           <div class="alert alert-danger" role="alert" style="display:none;"></div>
                           <input type="hidden" id="event_id" value="">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="name">Contact Name:</label>
                                 <div class="row">
                                    <div class="col-xs-6 col-md-6">
                                       <input type="text" onkeyup="$(this).parent().removeClass('has-error');" class="form-control" id="first_name" placeholder="First name" required="required" />
                                    </div>
                                    <div class="col-xs-6 col-md-6">
                                       <input type="text" class="form-control" id="last_name" placeholder="Lasts name" required="required" />
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label for="name">
                                 Event Name:</label>
                                 <input type="text" onblur="checkEventName(this.value);" onkeyup="$(this).parent().removeClass('has-error');" class="form-control" id="event_name" placeholder="Event Name" required="required" />

                              </div>
                              <div class="form-group">
                                 <label for="name">
                                 Venue:</label>
                                 <input type="text" class="form-control" onkeyup="$(this).parent().removeClass('has-error');" id="venue_name" placeholder="Venue Name" required="required" />
                              </div>
                              <!-- address-line1 input-->
                              <div class="form-group">
                                 <label for="address"> Address:</label>
                                 <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span>
                                    </span>
                                    <input type="text" class="form-control" onkeyup="$(this).parent().removeClass('has-error');" id="street_address" placeholder="Street Name " required="required" />
                                 </div>
                              </div>
                              <!-- address-line1 input-->
                              <div class="form-group">
                                 <label for="address"> Postcode:</label>
                                 <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span>
                                    </span>
                                    <input type="text" class="form-control" onkeyup="$(this).parent().removeClass('has-error');" id="post_code" placeholder="Post Code" required="required" />
                                 </div>
                              </div>
                              <div class="form-group">
                                 <div class="row">
                                    <div class="col-xs-6 col-md-6">
                                       <label for="name">Start Date & Time:</label>
                                       <div class="input-group date">
                                          <input  id="start_date" type="text" onkeyup="$(this).parent().removeClass('has-error');" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-xs-6 col-md-6">
                                       <label for="name">End Date & Time:</label>
                                       <div class="input-group date">
                                          <input  id="end_date" type="text" onkeyup="$(this).parent().removeClass('has-error');" class="form-control" required="required" ><span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                                 <div class="row">

                              <div id="existing_images"></div>

                              </div>


                              <div class="form-group">

                                          <label for="city"> Upload up to 3 Images</label>
                            
                            <form enctype="multipart/form-data">
                                <br>
                                <div class="form-group">
                                    <input id="file-4" class="file" type="file" multiple=true data-preview-file-type="any" data-upload-url="../slim.php/api/upload_images?path=event_images">
                                </div>
                            </form>
                      
                     </div>
                     <div class="form-group">
                     <div class="row">
                     <div class="col-xs-6 col-md-6">
                     <label for="name">Price:</label>
                     <div class="input-group">
                     <span class="input-group-addon">$</span>
                     <input type="text" id="price" class="form-control" aria-label="Amount (to the nearest dollar)">
                     </div>
                     </div>
                     <div class="col-xs-6 col-md-6">
                     </div>
                     </div>
                     </div>
                     </div>
                     <div class="col-md-6">
                     <div class="form-group">
                     <label for="phone">
                     Contact Phone 1 #:</label>
                     <div class="input-group">
                     <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span>
                     </span>
                     <input type="phone" class="form-control" onkeyup="$(this).parent().removeClass('has-error');" id="office_number" placeholder="Enter Main #" required="required" />
                     </div>
                     </div>
                     <div class="form-group">
                     <label for="phone">
                     Contact Phone 2 #:</label>
                     <div class="input-group">
                     <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span>
                     </span>
                     <input type="phone" class="form-control" id="cell_number" placeholder="Enter Your Cell #" required="required" />
                     </div>
                     </div>
                     <div class="form-group">
                     <label for="email">
                     Email Address:</label>
                     <div class="input-group">
                     <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                     </span>
                     <input type="text" class="form-control" id="email_address" placeholder="Enter email" required="required" />
                     </div>
                     </div>
                     <div class="form-group">
                     <label for="city"> Country: </label>
                     <select id="country" name="subject" class="form-control" required="required" onchange="getStates(this.value);$(this).parent().removeClass('has-error');">
                     <option value="" selected="">Choose One:</option>
                     </select>
                     </div>
                     <div class="form-group">
                     <label for="city"> Province/Sate:</label>
                     <select id="state" onchange="getCities(this.value);$(this).parent().removeClass('has-error');" name="subject" class="form-control" required="required">
                     <option value="" selected="">Choose One:</option>
                     </select>
                     </div>
                     <div class="form-group">
                     <label for="city"> City</label>
                     <select id="city" name="subject" class="form-control" onchange="$(this).parent().removeClass('has-error');" required="required">
                     <option value="" selected="">Choose One:</option>
                     </select>
                     </div>
               
                     <div class="form-group">
                     <div class="row">
                     <div class="col-xs-6 col-md-6">
                     <label for="name">FaceBook:</label>
                     <div class="input-group date">
                     <input   placeholder="Enter FaceBook Link" id="facebook"  type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-facebook-square fa-lg"></i></span>
                     </div>
                     </div>
                     <div class="col-xs-6 col-md-6">
                     <label for="name">Twitter</label>
                     <div class="input-group date">
                     <input  placeholder="Enter Twitter Link" id="twitter"  type="text" class="form-control"  ><span class="input-group-addon"><i class="fa fa-twitter fa-lg"></i></span>
                     </div> 
                     </div>
                     </div>
                     <div class="row">
                     <div class="col-xs-6 col-md-6">
                     <label for="name">YouTupe:</label>
                     <div class="input-group date">
                     <input   type="text"  placeholder="Enter YouTupe Link" id="youtube" class="form-control"><span class="input-group-addon"><i class="fa fa-youtube fa-lg"></i></span>
                     </div>
                     </div>
                     <div class="col-xs-6 col-md-6">
                     <label for="name">Instagram</label>
                     <div class="input-group date">
                     <input  placeholder="Enter Instagram Link" id="instagram" type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-instagram fa-lg"></i></span>
                     </div> 
                     </div>
                     </div>
                     </div>
                     </div>
                     <div class="col-md-12">
                     <div class="alert alert-warning" id="uploadmsg" role="alert" style="display:none;"></div>                     
                     
                     <button type="button" onclick="addEvent();" class="btn btn-primary pull-left" id="btnContactUs">
                     Update Event</button>
                     <button type="submit" class="btn btn-default">Cancel</button>
                                          <button class="btn btn-default" onclick="eventReset();" type="reset">Reset</button>

                     </div>
                     </div>
                     </form>
                     <!-- Form Start Here-->                     
                  </div>
               </div>




      </div><!--scrollable wrapper end--> 
    </div><!--margin-container end--> 
  </div><!--main end--> 
</div><!--layout-container end--> 
</body>
</html>