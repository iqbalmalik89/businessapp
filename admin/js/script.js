
var apiUrl = 'http://localhost/businessapp/index.php/api/';

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
                window.location = 'index.php';
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

function deleteCat(id)
{
    $.ajax({
      type: 'DELETE',
      url: apiUrl + 'category',
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

function getSingleCategory(cat_id, cat_name)
{
    $('#cat_id').val(cat_id);
    $('#cat_name').val(cat_name);

}

function showAddPopup()
{
    catReset();
}

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
        if(data.data.length > 0)
        {
            $.each(data.data, function( index, value ) {
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
                        <td>Categories not found</td>\
                     </tr>';            
        }

        $('#categorybody').html(html);

      },
      error:function(jqxhr){
      }
    });
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
        method = 'POST';
    }
    else
    {
        method = 'PUT';        
    }

    if(check)
    {
        $.ajax({
          type: method,
          url: apiUrl + 'category',
          dataType : "JSON",
          data: {id:cat_id, cat_name:cat_name},
          beforeSend:function(){

          },
          success:function(data){
            if(data.status == 'success')
            {
                getCategories();                
                $('#addcat').modal('hide');
            }
          },
          error:function(jqxhr){
          }
        });
    }

}
