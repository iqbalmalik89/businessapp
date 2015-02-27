
var server = window.location.hostname;
if(server == 'localhost')
  var apiUrl = location.protocol + "//"+server+"/businessapp/bd/slim.php/api/";
else
  var apiUrl = location.protocol + "//"+server+"/bd/slim.php/api/";


function showMsg(id, msg, type)
{
    $(id).html(msg).addClass(type).slideDown('fast').delay(2500).slideUp(1000,function(){$(id).removeClass(type)}); 
}

function login()
{
    var email = $.trim($('#email').val());
    var password = $.trim($('#password').val());    
    var check = true;

    if(email == '')
    {
        $('#email').focus();
        $('#email').addClass('error-class');
        check = false;
    }

    if(password == '')
    {
        $('#password').focus();
        $('#password').addClass('error-class');
        check = false;
    }

    if(check)
    {
        $('#spinner').show();
        $.ajax({
          type: 'POST',
          url: apiUrl + 'login',
          dataType : "JSON",
          data: { username: email, password: password },
          beforeSend:function(){

          },
          success:function(data){
            $('#spinner').hide();
            if(data.status == 'success')
            {
                showMsg('#msg', 'Successfully Logged In. Redirecting ...', 'green')
                window.location = 'categories.php';
            }
          },
          error:function(jqxhr){
            $('#spinner').hide();            
            showMsg('#msg', 'Wrong credentials. Try Again', 'red')
          }
        });

    }
}

function logout()
{
    $.ajax({
      type: 'GET',
      url: apiUrl + 'logout',
      dataType : "JSON",
      data: {},
      beforeSend:function(){

      },
      success:function(data){
        window.location = 'login.php';
      },
      error:function(jqxhr){
      }
    });
}

function deleteSubCat(id)
{
    $.ajax({
      type: 'POST',
      url: apiUrl + 'deletesub_cat',
      dataType : "JSON",
      data: {sub_cat_id:id},
      beforeSend:function(){

      },
      success:function(data){
        getSubCategories();
      },
      error:function(jqxhr){
      }
    });
}

function deleteCat(id)
{
    $.ajax({
      type: 'POST',
      url: apiUrl + 'deletecategory',
      dataType : "JSON",
      data: {id:id},
      beforeSend:function(){

      },
      success:function(data){
        getCategories();
      },
      error:function(jqxhr){
      }
    });
}

function catReset()
{
    $('#cat_id').val('');
    $('#cat_name').val('');
}

function subCatReset()
{
    $('#sub_cat_id').val('');
    $('#cat_name').val('');
}

function getSingleCategory(cat_id, cat_name)
{
    $('#cat_id').val(cat_id);
    $('#cat_name').val(cat_name);

}

function getSingleSubCategory(cat_id, cat_name)
{
    $('#sub_cat_id').val(cat_id);
    $('#cat_name').val(cat_name);
}

function showAddPopup()
{
    catReset();
}

function showSubAddPopup()
{
  subCatReset();
}

function getSubCategories(edit)
{
  var cat_id = $('#cat_id').val();

  if(edit)
    sync = false;
  else
    sync = true; 

    $.ajax({
      type: 'GET',
      url: apiUrl + 'sub_cat',
      dataType : "JSON",
      data: {cat_id: cat_id},
      async: sync,
      beforeSend:function(){

      },
      success:function(data){
        var html = '';
        var options = '';
        if(data.data.length > 0)
        {
            $.each(data.data, function( index, value ) {
                options += '<option value="'+value.id+'">'+value.cat_name+' </option>';

                html += '<tr>\
                            <td>'+value.cat_name+'</td>\
                            <td><a href="javascript:void(0);" data-toggle="modal" onclick="getSingleSubCategory('+value.id+', \''+value.cat_name+'\');" data-target="#addcat">Edit</a> | <a href="javascript:void(0);" onclick="deleteSubCat('+value.id+');">Delete</a></td>\
                         </tr>';

            });            
        }
        else
        {
            html += '<tr>\
                        <td colspan="2" align="center">Subcategories not found</td>\
                     </tr>';            
        }

        $('#categorybody').html(html);
       $('#sub_cat_id').append(options);

      },
      error:function(jqxhr){
      }
    });
}
var allImages = [] ;
function getCategories(edit)
{
  if(edit)
    sync = false;
  else
    sync = true;

    $.ajax({
      type: 'GET',
      url: apiUrl + 'categories',
      dataType : "JSON",
      data: {},
      async:sync,
      beforeSend:function(){

      },
      success:function(data){
        var html = '';
        var options = '';
        if(data.data.length > 0)
        {
            $.each(data.data, function( index, value ) {

                options += '<option value="'+value.id+'">'+value.cat_name+' </option>';
                html += '<tr>\
                            <td>'+value.cat_name+'</td>\
                            <td><a href="subcategory.php?cat_id='+value.id+'">Manage Subcategories ('+value.sub_cat_count+')</a></td>\
                            <td><a href="javascript:void(0);" data-toggle="modal" data-catname="'+value.cat_name+'" onclick="getSingleCategory('+value.id+', \''+value.cat_name+'\');" data-target="#addcat">Edit</a> | <a href="javascript:void(0);" onclick="deleteCat('+value.id+');">Delete</a></td>\
                         </tr>';

            });            
        }
        else
        {
            html += '<tr>\
                        <td colspan="3" align="center">Categories not found</td>\
                     </tr>';            
        }


        $('#categorybody').html(html);
        $('#cat_id').append(options);

      },
      error:function(jqxhr){
      }
    });
}

function addUpdateSubCategory()
{
    var cat_id = $('#cat_id').val();
    var sub_cat_id = $('#sub_cat_id').val();
    var cat_name = $('#cat_name').val();
    var check  = true;

    if(cat_name == '')
    {
        $('#cat_name').focus();
        $('#cat_name').addClass('error-class');
        check = false;
    }

    if(sub_cat_id == '')
    {
        route = 'addsub_cat';
    }
    else
    {
        route = 'updatesub_cat';
    }

    if(check)
    {
        $('#spinner').show();
        $.ajax({
          type: "POST",
          url: apiUrl + route,
          dataType : "JSON",
          data: {id:sub_cat_id, cat_id:cat_id, sub_cat_name:cat_name},
          beforeSend:function(){

          },
          success:function(data){
          $('#spinner').hide();
            if(data.status == 'success')
            {
                getSubCategories();                
                $('#addcat').modal('hide');
            }
          },
          error:function(jqxhr){
            $('#spinner').hide();
            showMsg('#msg', 'Category already exists with this name.', 'red');
          }
        });
    }
}


function addUpdateCategory()
{
    var cat_id = $('#cat_id').val();
    var cat_name = $('#cat_name').val();
    var check  = true;

    if(cat_name == '')
    {
        $('#cat_name').focus();
        $('#cat_name').addClass('error-class');
        check = false;
    }

    if(cat_id == '')
    {
      route = 'addcategory';
    }
    else
    {
      route = 'updatecategory';
    }

    if(check)
    {
        $('#spinner').show();      
        $.ajax({
          type: 'POST',
          url: apiUrl + route,
          dataType : "JSON",
          data: {id:cat_id, cat_name:cat_name},
          beforeSend:function(){

          },
          success:function(data){
          $('#spinner').hide();      
            if(data.status == 'success')
            {
                getCategories();                
                $('#addcat').modal('hide');
            }
          },
          error:function(jqxhr){
            $('#spinner').hide();      
            showMsg('#msg', 'Category already exists with this name.', 'red');
          }
        });
    }
}



/*
* Front end functions
*
*/

function businessReset()
{
  allImages = [];
  $('#existing_images').html('');
  var id = $.trim($('#id').val());
  $('#first_name, #last_name, #business_name, #street_address, #post_code, #office_number, #cell_number, #city, #state, #email_address, #website, #facebook, #twitter, #youtube, #instagram').val('');

  $('select option:first-child').attr("selected", "selected");

  var daysArr = [1, 2, 3, 4, 5, 6, 7];
  $.each(daysArr, function( index, value ) {
     $('#start_time' + value).datetimepicker({
        datepicker:false,
        value : "09:00 AM",
        format:'g:i A',
        step:60
     });

     $('#end_time' + value).datetimepicker({
        datepicker:false,
        value : "09:00 PM",
        format:'g:i A',
        step:60
     });               

  });

  $( ".fileinput-remove" ).trigger( "click" );
}

function checkBusinessName(name)
{
  var vendor_id = $('#vendor_id').val();
  if(name!="")
  {
    $('#business_spinner').show();    
     $.ajax({
      type: "GET",
      url: apiUrl + 'vendor_name',
      dataType : "JSON",
      data: {name:name, vendor_id:vendor_id},
      beforeSend:function(){

      },
      success:function(data){
        $('#business_spinner').hide();    
        if(data.status == 'error')
        {
          $('.alert-danger').html('Business name already exists').slideDown('fast').delay(2500).slideUp(1000,function(){}); 
          $('#business_name').parent().addClass('has-error');
        }
        else
          $('#business_name').parent().removeClass('has-error');          

      },
      error:function(jqxhr){
        $('#business_spinner').hide();    
      }
    });    
  }
   

}


function checkEventName(name)
{
  if(name!="")
  {
    $('#business_spinner').show();    
     $.ajax({
      type: "GET",
      url: apiUrl + 'event_name',
      dataType : "JSON",
      data: {name:name},
      beforeSend:function(){

      },
      success:function(data){
        $('#business_spinner').hide();    
        if(data.status == 'error')
        {
          $('.alert-danger').html('Event name already exists').slideDown('fast').delay(2500).slideUp(1000,function(){}); 
          $('#event_name').parent().addClass('has-error');
        }
        else
          $('#event_name').parent().removeClass('has-error');          

      },
      error:function(jqxhr){
        $('#business_spinner').hide();    
          $('.alert-danger').html('Event name already exists').slideDown('fast').delay(2500).slideUp(1000,function(){}); 
          $('#event_name').parent().addClass('has-error');

      }
    });    
  }
   

}


function addBusiness()
{
  var id = $.trim($('#vendor_id').val());
  var first_name = $.trim($('#first_name').val());
  var last_name = $.trim($('#last_name').val());
  var business_name = $.trim($('#business_name').val());
  var street_address = $.trim($('#street_address').val());
  var post_code = $.trim($('#post_code').val());
  var cat_id = $.trim($('#cat_id').val());
  var sub_cat_id = $.trim($('#sub_cat_id').val());

  // Days
  var days = [];
  var daysArr = [1, 2, 3, 4, 5, 6, 7];
  $.each(daysArr, function( index, value ) {
    var start_time = $.trim($('#start_time' + value).val());
    var end_time = $.trim($('#end_time' + value).val());    
    var obj = {"start_time":start_time, "end_time":end_time, "day_code": value};
    days.push(obj);
  });

  var office_number = $.trim($('#office_number').val());
  var cell_number = $.trim($('#cell_number').val());
  var country = $.trim($('#country').val());
  var city = $.trim($('#city').val());
  var state = $.trim($('#state').val());
  var email_address = $.trim($('#email_address').val());
  var website = $.trim($('#website').val());
  var facebook = $.trim($('#facebook').val());
  var youtube = $.trim($('#youtube').val());
  var twitter = $.trim($('#twitter').val());
  var instagram = $.trim($('#instagram').val());
  var check = true;
  var errormsgs = '';
  if(first_name == "")
  {
    $('#first_name').parent().addClass('has-error');
    if(check)
      $('#first_name').focus();
    check = false;
    errormsgs += 'Please Enter First Name<br>';
  }

  if(business_name == "")
  {
    if(check)
      $('#business_name').focus();
      $('#business_name').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Enter Business Name<br>';
  }

  if(street_address == "")
  {
    if(check)
      $('#street_address').focus();
      $('#street_address').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Enter Street Address<br>';
  }


  if(post_code == "")
  {
    if(check)
      $('#post_code').focus();
      $('#post_code').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Enter Post Code<br>';    
  }

  if(cat_id == "")
  {
    if(check)
      $('#cat_id').focus();
      $('#cat_id').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Select Category<br>';
  }

  if(sub_cat_id == "")
  {
    if(check)
      $('#sub_cat_id').focus();
      $('#sub_cat_id').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Select Subcategory<br>';
  }

  if(office_number == "")
  {
    if(check)
      $('#office_number').focus();
      $('#office_number').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Enter Office Number<br>';
  }

  if(country == "")
  {
    if(check)
      $('#country').focus();
      $('#country').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Select Country<br>';
  }

  if(state == "")
  {
    if(check)
      $('#state').focus();
      $('#state').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Select State<br>';    
  }

  if(city == "")
  {
    if(check)
      $('#city').focus();
      $('#city').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Select City<br>';
  }

  if(check)
  {
    $('#submit_spinner').show();    
     $.ajax({
      type: "POST",
      url: apiUrl + 'business_add',
      dataType : "JSON",
      data: {vendor_id: id, first_name: first_name, last_name: last_name, business_name: business_name, address: street_address, postcode: post_code, cat_id: cat_id, sub_cat_id:sub_cat_id, office_number:office_number, cell_number: cell_number, country:country, city: city, state: state, country: country, email: email_address, website: website, facebook: facebook, youtube: youtube, twitter: twitter, instagram: instagram, images : allImages, days: days},
      beforeSend:function(){

      },
      success:function(data){
        $('#submit_spinner').hide();    

        if(data.status == 'success')
        {
          if(id !='' && id!= 0)
            window.location = 'vendors.php';
          businessReset();
          $('.alert-success').html('Business added successfully').slideDown('fast').delay(2500).slideUp(1000,function(){}); 
          var body = $("html, body");
          body.animate({scrollTop:700}, '500', 'swing', function() { 
          });

        }

      },
      error:function(jqxhr){
        $('#submit_spinner').hide();
        $('.alert-danger').html('Business name already exists').slideDown('fast').delay(2500).slideUp(1000,function(){}); 
        var body = $("html, body");
        body.animate({scrollTop:700}, '500', 'swing', function() { 
        });
      }
    });        
  }
  else
  {
        $('.alert-danger').html(errormsgs).slideDown('fast').delay(5000).slideUp(1000,function(){}); 
        var body = $("html, body");
        body.animate({scrollTop:700}, '500', 'swing', function() { 
        });
  }

}

function getCountries(edit)
{
  if(edit)
    sync = false;
  else
    sync = true;

    $.ajax({
      type: 'GET',
      url: apiUrl + 'countries',
      dataType : "JSON",
      data: {},
      async:sync,
      beforeSend:function(){

      },
      success:function(data){
        var options = '';
        if(data.data.length > 0)
        {
            $.each(data.data, function( index, value ) {
              options += '<option value="'+value.name+'"> '+value.name+' </option>';
            });

            $('#country').append(options);
        }
      },
      error:function(jqxhr){
      }
    });  
}

function getStates(country, edit)
{
  if(edit)
    sync = false;
  else
    sync = true;

    $.ajax({
      type: 'GET',
      url: apiUrl + 'states',
      dataType : "JSON",
      data: {country: country},
      async: sync,
      beforeSend:function(){

      },
      success:function(data){
        var options = '';
        if(data.data.length > 0)
        {
            $.each(data.data, function( index, value ) {
              options += '<option value="'+value.name+'"> '+value.name+' </option>';
            });

            $('#state').append(options);
        }
      },
      error:function(jqxhr){
      }
    });  
}

function getCities(state, edit)
{
  if(edit)
    sync = false;
  else
    sync = true;  
    $.ajax({
      type: 'GET',
      url: apiUrl + 'cities',
      dataType : "JSON",
      data: {state: state},
      async : sync,
      beforeSend:function(){

      },
      success:function(data){
        var options = '';
        if(data.data.length > 0)
        {
            $.each(data.data, function( index, value ) {
              options += '<option value="'+value.name+'"> '+value.name+' </option>';
            });

            $('#city').append(options);
        }
      },
      error:function(jqxhr){
      }
    });  
}

function eventReset()
{
  allImages = [];
  var id = $.trim($('#id').val());
  $('#first_name, #last_name, #event_name, #street_address, #post_code, #office_number, #cell_number, #city, #state, #email_address, #website, #facebook, #twitter, #youtube, #instagram, #price, #start_date, #end_date, venue_name').val('');

  $('select option:first-child').attr("selected", "selected");

  $( ".fileinput-remove" ).trigger( "click" );
}


function addEvent()
{
  var first_name = $.trim($('#first_name').val());
  var last_name = $.trim($('#last_name').val());
  var event_name = $.trim($('#event_name').val());
  var venue_name = $.trim($('#venue_name').val());
  var start_address = $.trim($('#start_address').val());
  var post_code = $.trim($('#post_code').val());
  var start_date = $.trim($('#start_date').val());
  var end_date = $.trim($('#end_date').val());
  var office_number = $.trim($('#office_number').val());
  var cell_number = $.trim($('#cell_number').val());
  var email_address = $.trim($('#email_address').val());
  var street_address = $.trim($('#street_address').val());
  var country = $.trim($('#country').val());
  var city = $.trim($('#city').val());
  var state = $.trim($('#state').val());
  var price = $.trim($('#price').val());
  var website = $.trim($('#website').val());
  var facebook = $.trim($('#facebook').val());
  var youtube = $.trim($('#youtube').val());
  var twitter = $.trim($('#twitter').val());
  var instagram = $.trim($('#instagram').val());
  var check = true;
  var errormsgs = '';
  if(first_name == "")
  {
    $('#first_name').parent().addClass('has-error');
    if(check)
      $('#first_name').focus();
    check = false;
    errormsgs += 'Please Enter First Name<br>';
  }

  if(event_name == "")
  {
    if(check)
      $('#event_name').focus();
      $('#event_name').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Enter Event Name<br>';
  }

  if(venue_name == "")
  {
    if(check)
      $('#venue_name').focus();
      $('#venue_name').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Enter Venue Name<br>';
  }

  if(street_address == "")
  {
    if(check)
      $('#street_address').focus();
      $('#street_address').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Enter Street Address<br>';
  }

  if(post_code == "")
  {
    if(check)
      $('#post_code').focus();
      $('#post_code').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Enter Post Code<br>';    
  }

  if(start_date == "____/__/__ __:__")
  {
    if(check)
      $('#start_date').focus();
      $('#start_date').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Select Event Start Date<br>';
  }

  if(end_date == "____/__/__ __:__")
  {
    if(check)
      $('#end_date').focus();
      $('#end_date').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Select Event End Date<br>';    
  }

  if(office_number == "")
  {
    if(check)
      $('#office_number').focus();
      $('#office_number').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Enter Office Number<br>';
  }

  if(country == "")
  {
    if(check)
      $('#country').focus();
      $('#country').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Select Country<br>';    
  }

  if(state == "")
  {
    if(check)
      $('#state').focus();
      $('#state').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Select State<br>';
  }

  if(city == "")
  {
    if(check)
      $('#city').focus();
      $('#city').parent().addClass('has-error');
    check = false;
    errormsgs += 'Please Select City<br>';
  }

 if(check)
  {
    $('#submit_spinner').show();    
     $.ajax({
      type: "POST",
      url: apiUrl + 'addevent',
      dataType : "JSON",
      data: {first_name: first_name, last_name: last_name, event_name: event_name, venue: venue_name, address: street_address, postcode: post_code, office_number:office_number, cell_number: cell_number, country:country, city: city, state: state, country: country, email: email_address, website: website, facebook: facebook, youtube: youtube, twitter: twitter, instagram: instagram, images : allImages, start_date: start_date, end_date: end_date, price: price},
      beforeSend:function(){

      },
      success:function(data){
        $('#submit_spinner').hide();    

        if(data.status == 'success')
        {
          businessReset();
          $('.alert-success').html('Event added successfully').slideDown('fast').delay(2500).slideUp(1000,function(){}); 
          var body = $("html, body");
          body.animate({scrollTop:700}, '500', 'swing', function() { 

          });
        }

      },
      error:function(jqxhr){
        $('#submit_spinner').hide();
        $('.alert-danger').html('Event name already exists').slideDown('fast').delay(2500).slideUp(1000,function(){}); 
        var body = $("html, body");
        body.animate({scrollTop:700}, '500', 'swing', function() { 
        });
      }
    });        
  }
  else
  {
        $('.alert-danger').html(errormsgs).slideDown('fast').delay(5000).slideUp(1000,function(){}); 
        var body = $("html, body");
          body.animate({scrollTop:700}, '500', 'swing', function() { 
        });
  }

}



function getAllVendors(type)
{
    $.ajax({
      type: 'GET',
      url: apiUrl + 'vendors',
      dataType : "JSON",
      data: {},
      beforeSend:function(){

      },
      success:function(data){
        var options = '';
        var pendinghtml = '';
        var activehtml = '';
        var deactivehtml = '';
        $.each(data.data, function( index, vendor ) {
          var link = '';
          
          options += '<option value="'+vendor.id+'" > '+vendor.business_name+' </option>';

          if(vendor.status == 'activated')
          {
            link = '<a href="javascript:void(0);" onclick="changeVendorStatus('+vendor.id+', \'deactivated\');">Deactive</a>';          
          }
          else if(vendor.status == 'deactivated')
          {
            link = '<a href="javascript:void(0);" onclick="changeVendorStatus('+vendor.id+', \'activated\');">Active</a>';          
          }
          else if(vendor.status == 'pending')
          {
            link = '<a href="javascript:void(0);" onclick="changeVendorStatus('+vendor.id+', \'activated\');">Approve</a>';
          }

          link += ' | <a href="editvendor.php?id='+vendor.id+'">Edit</a>';
          link += ' | <a href= "javascript:void(0);" onclick="deleteVendor('+vendor.id+')">Delete</a>';
          link += ' | <a href= "vendordeals.php?vendor_id='+vendor.id+'">Manage Deals</a>';

          var html = '<tr>\
                      <td>'+vendor.first_name +  ' ' + vendor.last_name+'</td>\
                      <td>'+vendor.business_name+'</td>\
                      <td>'+vendor.date_created+'</td>\
                      <td>' +link+ '</td>\
                   </tr>';

          if(vendor.status == 'activated')
          {
            activehtml += html;
          }
          else if(vendor.status == 'deactivated')
          {
            deactivehtml += html;
          }
          else if(vendor.status == 'pending')
          {
            pendinghtml += html;
          }

        });

        $('#pendingbody').html(pendinghtml);        
        $('#activebody').html(activehtml);        
        $('#deactivebody').html(deactivehtml);
        $('#promohtml').append(options);

        nohtml = '<tr>\
                        <td colspan="4" align="center">No vendors found.</td>\
                     </tr>';

      if(pendinghtml == '')
        $('#pendingbody').html(nohtml);        
      if(activehtml == '')
      {
        $('#activebody').html(nohtml);        
      }
      if(deactivehtml == '')
        $('#deactivebody').html(nohtml);        



      },
      error:function(jqxhr){
      }
    });

}

function deleteVendor(id)
{
  $.ajax({
      type: 'POST',
      url: apiUrl + 'deletevendor',
      dataType : "JSON",
      data: {id:id},
      beforeSend:function(){

      },
      success:function(data){
        getAllVendors();
      },
      error:function(jqxhr){
      }
    });
}

function showDealAddPopup()
{
    dealReset();
}

function dealReset()
{
    $('#deal_id').val('');
    $('#deal_name').val('');
    $('#start_date').val('');
    $('#end_date').val('');
    $('#desc').val('');
    $('#status').val('');
    $( ".fileinput-remove" ).trigger( "click" );
    allImages = [];
    $('#existing_images').html('');    
}

function getDeals()
{
  var id = $('#deal_id').val();

    $.ajax({
      type: 'GET',
      url: apiUrl + 'deals',
      dataType : "JSON",
      //data: {id: id},
      beforeSend:function(){

      },
      success:function(data){
        var html = '';
        var options = '';
        if(data.data.length > 0)
        {
            $.each(data.data, function( index, value ) {
                options += '<option value="'+value.id+'">'+value.deal_name+' </option>';
                var desc = value.desc;
                if(desc == null)
                {
                  desc = '';
                }
                else
                {
                  desc = value.desc;
                }
                html += '<tr>\
                            <td>'+value.deal_name+'</td>\
                            <td>'+value.start_date+'</td>\
                            <td>'+value.end_date+'</td>\
                            <td>'+value.desc+'</td>\
                            <td><a href="javascript:void(0);" data-toggle="modal" onclick="getSingleDeal('+value.id+');" data-target="#adddeal">Edit</a> | <a href="javascript:void(0);" onclick="deleteDeal('+value.id+');">Delete</a></td>\
                         </tr>';

            });            
        }
        else
        {
            html += '<tr>\
                        <td colspan="6" align="center">Deals not found</td>\
                     </tr>';            
        }

        $('#dealbody').html(html);
       //$('#sub_cat_id').append(options);

      },
      error:function(jqxhr){
      }
    });
}

function removeElm(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

function removeImage(obj, path)
{
  console.log(allImages);
  $(obj).parent().parent().parent().remove();
  removeElm(allImages, path);
}

function getSingleDeal(id)
{
    dealReset();  
    $.ajax({
      type: 'GET',
      url: apiUrl + 'deals',
      dataType : "JSON",
      data: {id:id},
      beforeSend:function(){

      },

      success:function(data){
        $('#deal_id').val(data.data.id);
        $('#deal_name').val(data.data.deal_name);
        $('#start_date').val(data.data.start_date);
        $('#end_date').val(data.data.end_date);
        $('#desc').val(data.data.desc);
        var images_html = '';
        $.each(data.data.images, function( index, imgs ) {
          allImages.push(imgs.path);
          images_html += '<div class="col-lg-2">\
              <div class="panel">\
                <div class="panel-body">\
                  <img src="'+imgs.url+'" width="50" height="50">\
                  <a href="javascript:void(0);" onclick="removeImage(this, \''+imgs.path+'\');">Remove</a>\
                </div>\
              </div>\
            </div>';
       });
        if(images_html != '')
        {
          $('#existing_images').html(images_html);
        }

      },
      error:function(jqxhr){
      }
    });
}

function deleteDeal(id)
{
    $.ajax({
      type: 'POST',
      url: apiUrl + 'deletedeal',
      dataType : "JSON",
      data: {id:id},
      beforeSend:function(){

      },
      success:function(data){
        getDeals();
      },
      error:function(jqxhr){
      }
    });
}

function getSingleVendor(id)
{
    $.ajax({
      type: 'get',
      url: apiUrl + 'vendors',
      dataType : "JSON",
      data: {vendor_id:id},
      beforeSend:function(){

      },
      success:function(data){
        $('#first_name').val(data.data.first_name);
        $('#last_name').val(data.data.last_name);
        $('#business_name').val(data.data.business_name);
        $('#street_address').val(data.data.address);
        $('#post_code').val(data.data.postcode);
        $('#cat_id').val(data.data.cat_id);

        getSubCategories(true);

        $('#sub_cat_id').val(data.data.sub_cat_id)
        $('#office_number').val(data.data.office_number);        
        $('#cell_number').val(data.data.cell_number);        
        $('#country').val(data.data.country);      
        
        getStates(data.data.country, true)
        getCities(data.data.state, true)

        $('#city').val(data.data.city);        
        $('#state').val(data.data.state);        
        $('#email_address').val(data.data.email);        
        $('#website').val(data.data.website);        
        $('#facebook').val(data.data.facebook);        
        $('#twitter').val(data.data.twitter);        
        $('#instagram').val(data.data.instagram);        
        $('#youtube').val(data.data.youtube);        

        $.each(data.data.days, function( index, day ) {
          console.log(day);
            $('#start_time'+day.day_code).val(day.start_time);
            $('#end_time'+day.day_code).val(day.end_time);
        });

        var images_html = '';
        $.each(data.data.images, function( index, imgs ) {
          allImages.push(imgs.path);
          images_html += '<div class="col-lg-2">\
              <div class="panel">\
                <div class="panel-body">\
                  <img src="'+imgs.url+'" width="50" height="50">\
                  <a href="javascript:void(0);" onclick="removeImage(this, \''+imgs.path+'\');">Remove</a>\
                </div>\
              </div>\
            </div>';
       });
        if(images_html != '')
        {
          $('#existing_images').html(images_html);
        }



       },
      error:function(jqxhr){
      }
    });
}

function addUpdateDeal()
{
    var id = $('#deal_id').val();
    var deal_name = $('#deal_name').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    var desc = $('#desc').val();

     var check  = true;

     if(deal_name == '')
     {
         $('#deal_name').focus();
         $('#deal_name').addClass('error-class');
         check = false;
     }
     else if(start_date == '')
     {
         $('#start_date').focus();
         $('#start_date').addClass('error-class');
         check = false;
     }
     else if(end_date == '')
     {
         $('#end_date').focus();
         $('#end_date').addClass('error-class');
         check = false;
     }
    
     if(id == '')
     {
       route = 'add_deal';
     }
     else
     {
       route = 'updatedeal';
     }

     if(check)
     {
         $('#spinner').show();      
         $.ajax({
           type: "POST",
           url: apiUrl + route,
           dataType : "JSON",
           data: {id:id, deal_name:deal_name, start_date : start_date,end_date:end_date,desc:desc, images:allImages},
           beforeSend:function(){

           },
           success:function(data){
           $('#spinner').hide();      
             if(data.status == 'success')
             {
                 getDeals();                
                 $('#adddeal').modal('hide');
                $( ".fileinput-remove" ).trigger( "click" );
             }
           },
           error:function(jqxhr){
             $('#spinner').hide();      
             showMsg('#msg', 'Deal already exists with this name.', 'red');
           }
         });
    }
}



function changeVendorStatus(id, status)
{
  $.ajax({
    type: "POST",
    url: apiUrl + 'vendor_status',
    dataType : "JSON",
    data: {id:id, status : status},
    beforeSend:function(){

    },
    success:function(data){
    $('#spinner').hide();      
      if(data.status == 'success')
      {
          getAllVendors('');
          showMsg('#statusmsg', 'Vendor status updated successfully.', 'green');
      }
    },
    error:function(jqxhr){
    }
  });  
}

function getAllEvents(type)
{
    $.ajax({
      type: 'GET',
      url: apiUrl + 'events',
      dataType : "JSON",
      data: {},
      beforeSend:function(){

      },
      success:function(data){

        var pendinghtml = '';
        var activehtml = '';
        var deactivehtml = '';
        $.each(data.data, function( index, events ) {
          var link = '';
          console.log(events.first_name);
          if(events.status == 'ongoing')
          {
            link = '<a href="javascript:void(0);" onclick="changeEventStatus('+events.id+', \'expired\');">Expired</a>';          
          }
          else if(events.status == 'expired')
          {
            link = '<a href="javascript:void(0);" onclick="changeEventStatus('+events.id+', \'ongoing\');">Ongoing</a>';          
          }
          else if(events.status == 'pending')
          {
            link = '<a href="javascript:void(0);" onclick="changeEventStatus('+events.id+', \'ongoing\');">Ongoing</a>';
          }

          link += ' | <a href="editevent.php?id='+events.id+'" target="blank">Edit</a>';
          link += ' | <a href= "javascript:void(0);" onclick="deleteEvent('+events.id+')">Delete</a>';

          var html = '<tr>\
                      <td>'+events.first_name +  ' ' + events.last_name+'</td>\
                      <td>'+events.event_name+'</td>\
                      <td>'+events.venue+'</td>\
                      <td>' +link+ '</td>\
                   </tr>';

          if(events.status == 'ongoing')
          {
            activehtml += html;
          }
          else if(events.status == 'expired')
          {
            deactivehtml += html;
          }
          else if(events.status == 'pending')
          {
            pendinghtml += html;
          }

        });

        $('#pendingbody').html(pendinghtml);        
        $('#activebody').html(activehtml);        
        $('#deactivebody').html(deactivehtml);


        nohtml = '<tr>\
                        <td colspan="4" align="center">No Events found.</td>\
                     </tr>';

      if(pendinghtml == '')
        $('#pendingbody').html(nohtml);        
      if(activehtml == '')
      {
        $('#activebody').html(nohtml);        
      }
      if(deactivehtml == '')
        $('#deactivebody').html(nohtml);        



      },
      error:function(jqxhr){
      }
    });

}


function getSingleEvent(id)
{
    $.ajax({
      type: 'GET',
      url: apiUrl + 'events',
      dataType : "JSON",
      data: {id:id},
      beforeSend:function(){

      },

      success:function(data){
        $('#event_id').val(data.data.id);
        $('#first_name').val(data.data.first_name);
        $('#last_name').val(data.data.last_name);
        $('#event_name').val(data.data.event_name);
        $('#venue').val(data.data.venue);
        
      },
      error:function(jqxhr){
      }
    });
}

function getVendorDeals(vendor_id)
{
    $.ajax({
      type: 'GET',
      url: apiUrl + 'vendordeals',
      dataType : "JSON",
      data: {vendor_id:vendor_id},
      beforeSend:function(){

      },
      success:function(data){
        var html = '';
       $.each(data.data, function( index, value ) {
        var checked = '';
        if(value.is_vendor)
          checked = 'checked="checked"';

        html += '<div class="col-lg-3">\
              <div class="panel">\
                <div class="panel-body">\
                <span style="margin-right:10px;"><input '+checked+' class="deal_checks" type="checkbox" value="'+value.id+'"></span>'+value.deal_name+'\
                <br>'+value.start_date+' - '+value.end_date+'\
                </div>\
              </div>\
            </div>';          

          });
      if(html == '')
      {
       $('#vendor_deals').html('<p>There are no deals</p>');
       $('#dealsave').hide();        
      }
       else        
       $('#vendor_deals').html(html);

      },
      error:function(jqxhr){
      }
    });
}

function saveVendorDeals(vendor_id)
{
  var deal_ids = [];

    $('input:checkbox.deal_checks').each(function () {
        if(this.checked)
        {
          var deal_id = $(this).val();
          deal_ids.push(deal_id);
        }
    });

    $.ajax({
      type: 'POST',
      url: apiUrl + 'vendordeals',
      dataType : "JSON",
      data: {vendor_id:vendor_id, deal_ids:deal_ids},
      beforeSend:function(){
        
      },
      success:function(data){
        if(data.status == 'success')
        { 
          showMsg('#dealsmsg', 'Vendor deals updated', 'green')
        }
      },
      error:function(jqxhr){
      }
    });  
}

function deleteEvent(id)
{
    $.ajax({
      type: 'POST',
      url: apiUrl + 'deleteevent',
      dataType : "JSON",
      data: {id:id},
      beforeSend:function(){

      },
      success:function(data){
        getAllEvents();
      },
      error:function(jqxhr){
      }
    });
  }

function changeEventStatus(id, status)
{
  $.ajax({
    type: "POST",
    url: apiUrl + 'event_status',
    dataType : "JSON",
    data: {id:id, status : status},
    beforeSend:function(){

    },
    success:function(data){
    $('#spinner').hide();      
      if(data.status == 'success')
      {
          getAllEvents('');
          showMsg('#statusmsg', 'Event status updated successfully.', 'green');
      }
    },
    error:function(jqxhr){
    }
  });  
}

function addEditPromoVendors()
{
    var id         = $('#promo_vendor_id').val();
    var vendor_id  = $('#promohtml').val();
    var start_date = $('#start_date').val();
    var end_date   = $('#end_date').val();
    var check      = true;
    console.log(id);console.log(vendor_id);console.log(start_date);console.log(end_date);console.log(allImages);

     if(vendor_id == '')
     {
         $('#vendor_id').focus();
         $('#vendor_id').addClass('error-class');
         check = false;
     }
     else if(start_date == '')
     {
         $('#start_date').focus();
         $('#start_date').addClass('error-class');
         check = false;
     }
     else if(end_date == '')
     {
         $('#end_date').focus();
         $('#end_date').addClass('error-class');
         check = false;
     }
    
     if(id == '')
     {
       route = 'addpromovendors';
     }
     else
     {
       route = 'editpromovendors';
     }

     if(check)
     {

         $('#spinner').show();      
         $.ajax({
           type: "POST",
           url: apiUrl + route,
           dataType : "JSON",
           data: {id:id, vendor_id:vendor_id, start_date : start_date,end_date:end_date,images:allImages},
           beforeSend:function(){


           },
           success:function(data){
           $('#spinner').hide();      
             if(data.status == 'success')
             {
                 //getDeals();                
                 $('#addpromo').modal('hide');
                $( ".fileinput-remove" ).trigger( "click" );
             }
           },
           error:function(jqxhr){
             $('#spinner').hide();      
             showMsg('#msg', 'Promo already exists with this name.', 'red');
           }
         });
    }
}

function showPromoAddPopup()
{
    promoReset();
}

function promoReset()
{
    $('#promo_vendor_id').val('');
    $('#promohtml').val('');
    $('#start_date').val('');
    $('#end_date').val('');
    $( ".fileinput-remove" ).trigger( "click" );
    allImages = [];
    $('#existing_images').html('');    
}

function getAllPromoVendors()
{
  var id = $('#promo_vendor_id').val();

    $.ajax({
      type: 'GET',
      url: apiUrl + 'promovendors',
      dataType : "JSON",
      //data: {id: id},
      beforeSend:function(){

      },
      success:function(data){
        var html = '';
        var options = '';
        if(data.data.length > 0)
        {

            $.each(data.data, function( index, value ) {
                //options += '<option value="'+value.id+'">'+value.deal_name+' </option>';
                
                html += '<tr>\
                            <td>'+value.vendor_id+'</td>\
                            <td>'+value.start_date+'</td>\
                            <td>'+value.end_date+'</td>\
                            <td><a href="javascript:void(0);" data-toggle="modal" onclick="getSinglePromoVendor('+value.id+');" data-target="#addpromo">Edit</a> | <a href="javascript:void(0);" onclick="deletePromoVendor('+value.id+');">Delete</a></td>\
                         </tr>';

            });            
        }
        else
        {
            html += '<tr>\
                        <td colspan="6" align="center">Promo Vendors not found</td>\
                     </tr>';            
        }

        $('#promobody').html(html);

      },
      error:function(jqxhr){
      }
    });
}


function deletePromoVendor(id)
{
    $.ajax({
      type: 'POST',
      url: apiUrl + 'deletepromovendor',
      dataType : "JSON",
      data: {id:id},
      beforeSend:function(){

      },
      success:function(data){
        getDeals();
      },
      error:function(jqxhr){
      }
    });
}
