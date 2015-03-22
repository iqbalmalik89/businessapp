  <div id="nav"> 
    <!--logo start-->
    <div class="profile">
      <div class="logo"><a href=""><img src="images/logo.png" alt=""></a></div>
    </div><!--logo end--> 
    
    <!--navigation start-->
    <ul class="navigation">
<!--       <li><a class="active" href="index.html"><i class="fa fa-home"></i><span>Vendors</span></a></li>
      <li class="sub"> <a href="#"><i class="fa fa-smile-o"></i><span>UI Elements</span></a>
 -->
<?php
  $currFile = basename($_SERVER['PHP_SELF']); 
 ?>

 <li class="sub"> <a <?php if($currFile == 'categories.php' || $currFile == 'subcategory.php' ) echo 'class="active"'; ?> href="categories.php"><i class="fa fa-sitemap"></i><span>Categories</span></a>
<li class="sub"> <a <?php if($currFile == 'vendors.php' ||  $currFile == 'vendordeals.php' ||  $currFile == 'editvendor.php') echo 'class="active"'; ?> href="vendors.php"><i class="fa fa-briefcase"></i><span>Vendors</span></a>
<li class="sub"> <a <?php if($currFile == 'events.php' || $currFile == 'editevent.php') echo 'class="active"'; ?> href="events.php"><i class="fa fa-calendar-o"></i><span>Events</span></a>
<li class="sub"> <a <?php if($currFile == 'deals.php') echo 'class="active"'; ?> href="deals.php"><i class="fa fa-trophy"></i><span>Deals</span></a>
<li class="sub"> <a <?php if($currFile == 'promovendors.php') echo 'class="active"'; ?> href="promovendors.php"><i class="fa fa-bullhorn"></i><span>Promo Vendors</span></a>
<li class="sub"> <a <?php if($currFile == 'subscribers.php') echo 'class="active"'; ?> href="subscribers.php"><i class="fa fa-bullhorn"></i><span>Subscribers</span></a>
<li class="sub"> <a <?php if($currFile == 'queries.php') echo 'class="active"'; ?> href="queries.php"><i class="fa fa-bullhorn"></i><span>Queries</span></a>
<!--         <ul class="navigation-sub">
          <li><a href="buttons.html"><i class="fa fa-power-off"></i><span>Button</span></a></li>
          <li><a href="grids.html"><i class="fa fa-columns"></i><span>Grid</span></a></li>
          <li><a href="icons.html"><i class="fa fa-flag"></i><span>Icon</span></a></li>
          <li><a href="tab-accordions.html"><i class="fa fa-plus-square-o"></i><span>Tab / Accordion</span></a></li>
          <li><a href="nestable.html"><i class="fa  fa-arrow-circle-o-down"></i><span>Nestable</span></a></li>
          <li><a href="slider.html"><i class="fa fa-font"></i><span>Slider</span></a></li>
          <li><a href="timeline.html"><i class="fa fa-filter"></i><span>Timeline</span></a></li>
          <li><a href="gallery.html"><i class="fa fa-picture-o"></i><span>Gallery</span></a></li>
        </ul>
 -->      </li>
<!--       <li class="sub"><a href="#"><i class="fa fa-list-alt"></i><span>Forms</span></a>
        <ul class="navigation-sub">
          <li><a href="form-components.html"><i class="fa fa-table"></i><span>Components</span></a></li>
          <li><a href="form-validation.html"><i class="fa fa-leaf"></i><span>Validation</span></a></li>
          <li><a href="form-wizard.html"><i class="fa fa-th"></i><span>Wizard</span></a></li>
          <li><a href="input-mask.html"><i class="fa fa-laptop"></i><span>Input Mask</span></a></li>
          <li><a href="muliti-upload.html"><i class="fa fa-files-o"></i><span>Multi Upload</span></a></li>
        </ul>
      </li> -->
<!--       <li class="sub"><a href="#"><i class="fa fa-table"></i><span>Table</span></a>
        <ul class="navigation-sub">
          <li><a href="basic-tables.html"><i class="fa fa-table"></i><span>Basic Table</span></a></li>
          <li><a href="data-tables.html"><i class="fa fa-columns"></i><span>Data Table</span></a></li>
        </ul>
      </li>
      <li><a href="fullcalendar.html"><i class="fa fa-calendar nav-icon"></i><span>Calendar</span></a></li>
      <li><a href="charts.html"><i class="fa fa-bar-chart-o"></i><span>Charts</span></a></li>
      <li class="sub"><a href="#"><i class="fa fa-folder-open-o"></i><span>Pages</span></a>
        <ul class="navigation-sub">
          <li><a href="404-error.html"><i class="fa fa-warning"></i><span>404 Error</span></a></li>
          <li><a href="500-error.html"><i class="fa fa-warning"></i><span>500 Error</span></a></li>
          <li><a href="balnk-page.html"><i class="fa fa-copy"></i><span>Blank Page</span></a></li>
          <li><a href="profile.html"><i class="fa fa-user"></i><span>Profile</span></a></li>
          <li><a href="login.html"><i class="fa fa-sign-out"></i><span>Login</span></a></li>
          <li><a href="map.html"><i class="fa fa-map-marker"></i><span>Map</span></a></li>
        </ul>
      </li> -->
    </ul><!--navigation end--> 
  </div><!--Left navbar end--> 
