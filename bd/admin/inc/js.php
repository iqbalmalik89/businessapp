<?php
	if(!isset($_SESSION['user']))
	{
		echo "<script>window.location = 'login.php'</script>";
		die();		
	}
?>
<!-- Bootstrap -->
<link href="bs3/css/bootstrap.min.css" rel="stylesheet">
<link href="css/style-responsive.css" rel="stylesheet">
<link href="css/atom-style.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="plugins/PCharts/style.css" type="text/css">
<link href="plugins/kalendar/kalendar.css" rel="stylesheet">
<!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'> -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.10.2.js"></script> 
<script src="js/jquery-ui-1.9.1.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="bs3/js/bootstrap.min.js"></script> 
<script src="js/smooth-sliding-menu.js"></script> 
<script src="js/console-numbering.js"></script> 
<script src="js/to-do-admin.js"></script> 
<!-- <script src="plugins/PCharts/PCharts.js" type="text/javascript"></script> 
<script src="plugins/PCharts/serial.js" type="text/javascript"></script> 
<script src="plugins/PCharts/amstock.js" type="text/javascript"></script> 
<script src="plugins/PCharts/edit-chart.js" type="text/javascript"></script> 
<script src="plugins/PCharts/gauge.js" type="text/javascript"></script> 
<script src="plugins/PCharts/radar.js" type="text/javascript"></script> 
<script src="plugins/PCharts/pie.js" type="text/javascript"></script> 
<script src="plugins/kalendar/kalendar.js" type="text/javascript"></script> 
<script src="plugins/kalendar/edit-kalendar.js" type="text/javascript"></script> -->
<script src="js/script.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="plugins/bootstrap-datepicker/css/datepicker.css" />
<script type="text/javascript" src="plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
<link href="css/jquery.datetimepicker.css" media="all" rel="stylesheet" type="text/css" />

<script src="js/jquery.datetimepicker.js"></script>  

<link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="../js/fileinput.js" type="text/javascript" /></script>
<script src="js/jquery.bootpag.js" type="text/javascript" /></script>



