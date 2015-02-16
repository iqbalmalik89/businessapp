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
</head>
<body>
<!--layout-container start-->
<div id="layout-container"> 
  <!--Left navbar start-->
  
<?php
  include('inc/left.php');
?>  
  <!--main start-->
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
              <h1>Dashboard <small>your first page</small></h1>
            </div>
          </div><!--col-md-12 end-->
          <div class="col-sm-6 col-md-3">
            <div class="box-info">
              <div id="chartdiv4" style="width:100%; height:250px;"></div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="box-info">
              <div id="chartdiv1" style="width:100%; height:250px;"></div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="box-info">
              <div id="chartdiv5" style="width:100%; height:250px;"></div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="box-info">
              <div id="chartdiv6" style="width:100%; height:250px;"></div>
            </div>
          </div>
        </div><!--row end-->
        <div class="row">
          <div class="col-md-12">
            <div class="box-info">
              <div id="chartdiv" style="width:100%; height:400px;"></div>
            </div>
          </div><!--col-md-12 end--> 
        </div><!--row end-->
        
        <!--row start-->
        <div class="row">
       	 <!--col-md-6 start-->
          <div class="col-md-6">
          <!--box-info start-->
            <div class="box-info no-bg">
              <h4>To Do List </h4>
              <!--sortable-todo start-->
              <ul id="sortable-todo" class="to-do-list">
                <li class="clearfix"> <span class="drag-marker"> <i></i> </span>
                  <div class="todo-check pull-left">
                    <input type="checkbox" id="todo-check" value="None">
                    <label for="todo-check"></label>
                  </div>
                  <p class="todo-title"> Lorem ipsum dolor sit amet, consectetuer adipiscing </p>
                  <div class="todo-actionlist pull-right clearfix"> <a class="todo-done" href="#"><i class="fa fa-check"></i></a> <a class="todo-edit" href="#"><i class="fa fa-pencil"></i></a> <a class="todo-remove"><i class="fa fa-times icon-muted"></i></a> </div>
                </li>
                <li class="clearfix todo-list-active"> <span class="drag-marker"> <i></i> </span>
                  <div class="todo-check pull-left">
                    <input type="checkbox" id="todo-check1" value="None">
                    <label for="todo-check1"></label>
                  </div>
                  <p class="todo-title"> Lorem ipsum dolor sit amet, consectetuer adipiscing </p>
                  <div class="todo-actionlist pull-right clearfix"> <a class="todo-done" href="#"><i class="fa fa-check"></i></a> <a class="todo-edit" href="#"><i class="fa fa-pencil"></i></a> <a class="todo-remove"><i class="fa fa-times icon-muted"></i></a> </div>
                </li>
                <li class="clearfix"> <span class="drag-marker"> <i></i> </span>
                  <div class="todo-check pull-left">
                    <input type="checkbox" id="todo-check2" value="None">
                    <label for="todo-check2"></label>
                  </div>
                  <p class="todo-title"> Lorem ipsum dolor sit amet, consectetuer adipiscing </p>
                  <div class="todo-actionlist pull-right clearfix"> <a class="todo-done" href="#"><i class="fa fa-check"></i></a> <a class="todo-edit" href="#"><i class="fa fa-pencil"></i></a> <a class="todo-remove"><i class="fa fa-times icon-muted"></i></a> </div>
                </li>
                <li class="clearfix"> <span class="drag-marker"> <i></i> </span>
                  <div class="todo-check pull-left">
                    <input type="checkbox" id="todo-check3" value="None">
                    <label for="todo-check3"></label>
                  </div>
                  <p class="todo-title"> Lorem ipsum dolor sit amet, consectetuer adipiscing </p>
                  <div class="todo-actionlist pull-right clearfix"> <a class="todo-done" href="#"><i class="fa fa-check"></i></a> <a class="todo-edit" href="#"><i class="fa fa-pencil"></i></a> <a class="todo-remove"><i class="fa fa-times icon-muted"></i></a> </div>
                </li>
                <li class="clearfix"> <span class="drag-marker"> <i></i> </span>
                  <div class="todo-check pull-left">
                    <input type="checkbox" id="todo-check4" value="None">
                    <label for="todo-check4"></label>
                  </div>
                  <p class="todo-title"> Lorem ipsum dolor sit amet, consectetuer adipiscing </p>
                  <div class="todo-actionlist pull-right clearfix"> <a class="todo-done" href="#"><i class="fa fa-check"></i></a> <a class="todo-edit" href="#"><i class="fa fa-pencil"></i></a> <a class="todo-remove"><i class="fa fa-times icon-muted"></i></a> </div>
                </li>
                <li class="clearfix"> <span class="drag-marker"> <i></i> </span>
                  <div class="todo-check pull-left">
                    <input type="checkbox" id="todo-check5" value="None">
                    <label for="todo-check5"></label>
                  </div>
                  <p class="todo-title"> Lorem ipsum dolor sit amet, consectetuer adipiscing </p>
                  <div class="todo-actionlist pull-right clearfix"> <a class="todo-done" href="#"><i class="fa fa-check"></i></a> <a class="todo-edit" href="#"><i class="fa fa-pencil"></i></a> <a class="todo-remove"><i class="fa fa-times icon-muted"></i></a> </div>
                </li>
              </ul><!--sortable-todo end-->
              <!--todo-action-bar start-->
              <div class="todo-action-bar">
              <!--row start-->
                <div class="row">
                  <div class="col-xs-3 btn-todo-select">
                    <button class="btn btn-default" type="submit"><i class="fa fa-check"></i> Select All</button>
                  </div>
                  <div class="col-xs-6 todo-search-wrap">
                    <input type="text" placeholder=" Search" class="form-control search todo-search pull-right">
                  </div>
                  <div class="col-xs-3 btn-add-task">
                    <button class="btn btn-default btn-danger" type="submit"><i class="fa fa-plus"></i> Add Task</button>
                  </div>
                </div><!--row end-->
              </div><!--todo-action-bar end-->
            </div><!--box-info end-->
          </div><!--col-md-6 end-->
          
          <!--col-md-6 start-->
          <div class="col-md-6">
            <div class="kalendar"></div>
            <div class="list-group"> <a class="list-group-item text-ellipsis" href="#"> <span class="badge bg-danger">6:40</span> Consectetuer </a> <a class="list-group-item text-ellipsis" href="#"> <span class="badge bg-success">12:50</span> Lorem ipsum dolor sit amet </a> <a class="list-group-item text-ellipsis" href="#"> <span class="badge bg-light">17:30</span> Consectetuer adipiscing </a> </div>
          </div><!--col-md-6 end--> 
        </div><!--row end-->
        
        <!--row start-->
        <div class="row">
        <!--col-md-8 start-->
          <div class="col-md-8">
            <div class="box-info">
              <div id="chartdiv3" style="width:100%; height:300px;"></div>
            </div>
          </div><!--col-md-8 end-->
          
          <!--col-md-4 start-->
          <div class="col-md-4">
            <div class="box-info">
              <div class="block widget-notes">
                <div class="header dark">
                  <h4>Notes</h4>
                </div>
                <div contenteditable="true" class="paper"> Send e-mail to supplier<br>
                  <s>Conference at 4 pm.</s><br>
                  <s>Order a pizza</s><br>
                  <s>Buy flowers</s><br>
                  Buy some coffee.<br>
                  Dinner at Plaza.<br>
                  Take Alex for walk.<br>
                </div>
              </div>
            </div>
          </div><!--col-md-4 end--> 
        </div><!--row end-->
        
        <!--row start-->
        <div class="row">
        <!--col-md-8 start-->
          <div class="col-md-8">
            <div class="box-info">
              <div id="chartdiv2" style="width:100%; height:300px;"></div>
            </div>
          </div><!--col-md-8 end-->
          <!--col-md-4 start-->
          <div class="col-md-4">
          <!--block widget-notes start-->
            <div class="block widget-notes">
              <div class="console console-note">
                <h4>Console</h4>
              </div>
              <!--content start-->
              <div class="content">
              <!--console start-->
                <div id="console">
                  <div class="console-pad-scroll" tabindex="-1" draggable="true">
                    <div class="console-pad-sizer" style="padding:5px 0px 0px 24px">
                      <textarea id="console-pad" class="console-pad console-bg"></textarea>
                    </div>
                    <div class="console-pad-gutters">
                      <div class="console-pad-gutter console-pad-linenumbers" style="width: 23px;padding:18px 0px 0px 5px;">
                        <ul class="console-numbers">
                          <li>1</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div><!--console end-->
              </div><!--content end-->
            </div><!--block widget-notes start-->
          </div><!--col-md-4 end--> 
        </div><!--row end--> 
      </div><!--scrollable wrapper end--> 
    </div><!--margin-container end--> 
  </div><!--main end--> 
</div><!--layout-container end--> 


</body>
</html>