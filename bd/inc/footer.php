 <div class="modal fade in" id="coscentpopup" aria-hidden="false" style="z-index:99999999;">
    <div class="modal-backdrop fade in"></div>

  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <!-- dialog body -->
      <div class="modal-header">
        <button type="button" onclick="$('#coscentpopup, .modal-backdrop').fadeOut();" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="popupLabel">User's Consent</h4>
      </div>

      <div class="modal-body">

<p>
We thank you for your interest & subscribing your email address at <a href="http://www.tamildirectoryapp.com" target="_blank">http://www.tamildirectoryapp.com</a>  and we would like to
 keep the lines of communication open between you and <a href="http://www.tamildirectoryapp.com" target="_blank">http://www.tamildirectoryapp.com</a>.
</p>
<p>

Canada's new anti-spam legislation (CASL) takes effect July 1st, 2014. (for more information, 
please visit <a href="http://fightspam.gc.ca/eic/site/030.nsf/eng/home" target="_blank">http://fightspam.gc.ca/eic/site/030.nsf/eng/home</a>)  We need your consent to continue to send you
 e-communications in compliance with CASL.
</p>

<p>
Please click below to indicate your preference.
</p>


      </div>
      
      <!-- dialog buttons -->
      <div class="modal-footer" style="text-align:center">

         <input class="btn btn-success" type="button" value='“YES” I DO CONSENT' onclick="addSubscriber('active');">
         <input class="btn btn-danger" type="button" value='“NO” I DO NOT CONSENT' onclick="addSubscriber('deactive');">


      </div>
    </div>
  </div>
</div>
         <section class="support-section">
            <div class="container">
               <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 motion text-center">
                     <h2 class="page-header text-center"><strong>Subscribe Your Email</strong></h2>
                     <p class="lead">Enter Your Email For Updates Regarding Our Upcoming App.</p>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offest-3 motion-left">

                     <div class="alert alert-success" id="subscribermsg" role="alert" style="width: 67%;padding: 6px;display:none;"></div>
                     <div class="alert alert-danger" id="subscribeerrorrmsg" role="alert" style="width: 67%;padding: 6px;display:none;"></div>
                     <div class="input-group">
                        <input type="email" id="subscriber_email" onfocus="$('#subscriber_email').parent().removeClass('has-error')" placeholder="SUBSCRIBE FOR UPDATES" class="form-control input-lg"> <span class="input-group-btn"><button data-toggle="modal" onclick="showSubscribeModal();" class="btn btn-danger btn-lg" type="button">SUBSCRIBE!</button> 

                              <img id="subscriberspinner" src="images/spinner.gif" style="display:none;  position: absolute; left:170px; bottom:10px;">

                        </span>
                     </div>
                  </div>

               </div>
               <!-- /.row-->
            </div>
         </section>
         <footer class="">
            <div class="container">
          
               <div class="row text-center">
                  <ul class="list-inline">
                     <li><a href="#" title=""><i class="fa fa-twitter fa-2x"></i></a></li>
                     <li><a href="#" title=""><i class="fa fa-facebook fa-2x"></i></a></li>
                     <li><a href="#" title=""><i class="fa fa-google-plus fa-2x"></i></a></li>
                     <li><a href="#" title=""><i class="fa fa-youtube fa-2x"></i></a></li>
                     <li><a href="#" title=""><i class="fa fa-dribbble fa-2x"></i></a></li>
                  </ul>
               </div>
            </div>
            <!-- CONTAINER -->
         </footer>
         <!-- /FOOTER-->