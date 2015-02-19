var server = window.location.hostname;
if(server == 'localhost')
  var apiUrl = location.protocol + "//"+server+"/businessapp/bd/index.php/api/";
else
  var apiUrl = location.protocol + "//"+server+"/bd/index.php/api/";


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

function getSubCategories()
{
  var cat_id = $('#cat_id').val();

    $.ajax({
      type: 'GET',
      url: apiUrl + 'sub_cat',
      dataType : "JSON",
      data: {cat_id: cat_id},
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
function getCategories()
{
    $.ajax({
      type: 'GET',
      url: apiUrl + 'categories',
      dataType : "JSON",
      data: {},
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
          type: "POST",
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
  var id = $.trim($('#id').val());
  $('#first_name, #last_name, #business_name, #street_address, #post_code, #office_number, #cell_number, #city, #state, #email_address, #website, #facebook, #twitter, #youtube, #instagram').val('');

  $('select option:first-child').attr("selected", "selected");

  var daysArr = [1, 2, 3, 4, 5, 6, 7];
  $.each(daysArr, function( index, value ) {
     $('#start_time' + value).datetimepicker({
        datepicker:false,
        value : "09:00",
        format:'H:i',
        step:60
     });

     $('#end_time' + value).datetimepicker({
        datepicker:false,
        value : "06:00",
        format:'H:i',
        step:60
     });               

  });

  $( ".fileinput-remove" ).trigger( "click" );



}

function checkBusinessName(name)
{
  if(name!="")
  {
    $('#business_spinner').show();    
     $.ajax({
      type: "GET",
      url: apiUrl + 'vendor_name',
      dataType : "JSON",
      data: {name:name},
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

function addBusiness()
{
  var id = $.trim($('#id').val());
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

  if(first_name == "")
  {
    $('#first_name').parent().addClass('has-error');
    if(check)
      $('#first_name').focus();
    check = false;
  }

  if(business_name == "")
  {
    if(check)
      $('#business_name').focus();
      $('#business_name').parent().addClass('has-error');
    check = false;
  }

  if(check)
  {
    $('#submit_spinner').show();    
     $.ajax({
      type: "POST",
      url: apiUrl + 'business_add',
      dataType : "JSON",
      data: {first_name: first_name, last_name: last_name, business_name: business_name, address: street_address, postcode: post_code, cat_id: cat_id, sub_cat_id:sub_cat_id, office_number:office_number, cell_number: cell_number, country:country, city: city, state: state, country: country, email: email_address, website: website, facebook: facebook, youtube: youtube, twitter: twitter, instagram: instagram, images : allImages, days: days},
      beforeSend:function(){

      },
      success:function(data){
        $('#submit_spinner').hide();    

        if(data.status == 'success')
        {
          businessReset();
          $('.alert-success').html('Business added successfully').slideDown('fast').delay(2500).slideUp(1000,function(){}); 
          var body = $("html, body");
          body.animate({scrollTop:700}, '500', 'swing', function() { 
             alert("Finished animating");
          });
        }

      },
      error:function(jqxhr){
        $('#submit_spinner').hide();
        $('.alert-danger').html('Business name already exists').slideDown('fast').delay(2500).slideUp(1000,function(){}); 
        var body = $("html, body");
        body.animate({scrollTop:700}, '500', 'swing', function() { 
           alert("Finished animating");
        });
      }
    });        
  }

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
  var end_time = $.trim($('#end_time').val());
  var office_number = $.trim($('#office_number').val());
  var cell_number = $.trim($('#cell_number').val());
  var email_address = $.trim($('#email_address').val());
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

}