var server = window.location.hostname;
if(server == 'localhost')
  var apiUrl = location.protocol + "//"+server+"/businessapp/bd/slim.php/api/";
else
  var apiUrl = location.protocol + "//"+server+"/beta/slim.php/api/";

function showMsg(id, msg, type)
{
    $(id).html(msg).addClass(type).slideDown('fast').delay(2500).slideUp(1000,function(){$(id).removeClass(type)}); 
}

function resetContact()
{
    $('#name').val('');
    $('#phone').val('');
    $('#email').val('');
    $('#message').val('');
    $('select option:first-child').attr("selected", "selected");
}

function validateEmail(email){
    var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    var valid = emailReg.test(email);

    if(!valid) {
        return false;
    } else {
        return true;
    }
}

function addSubscriber()
{
    var email = $.trim($('#subscriber_email').val());
    $('#subscriber_email').parent().removeClass('has-error');

    if(email == '')
    {
        $('#subscriber_email').focus();
        $('#subscriber_email').parent().addClass('has-error');
        check = false;
    }
    else
    {
        if(validateEmail(email))
        {
            $('#subscriberspinner').show();        
            $.ajax({
              type: 'POST',
              url: apiUrl + 'add_subscriber',
              dataType : "JSON",
              data: {email:email},
              beforeSend:function(){

              },
              success:function(data){
                if(data.status == 'success')
                {
                    $('#subscriberspinner').hide();
                    showMsg('#subscribermsg', 'You are added to subscriber list', '');
                    $('#subscriber_email').val('');                
                }
                else
                {
                    showMsg('#subscribeerrorrmsg', 'You are already subscriber', '');
                }

              },
              error:function(jqxhr){
                $('#subscriberspinner').hide();
                showMsg('#subscribeerrorrmsg', 'You are already subscriber', '');

              }
            });            
        }
        else
        {
            $('#subscriber_email').focus();
            $('#subscriber_email').parent().addClass('has-error');
            check = false;
        }

    }
}

function sendContactQuery()
{
    var name = $.trim($('#name').val());
    var phone = $.trim($('#phone').val());
    var subject = $.trim($('#subject').val());
    var email = $.trim($('#email').val());
    var message = $.trim($('#message').val());
    var check = true;

    if(name == '')
    {
        $('#name').focus();
        $('#name').parent().addClass('has-error');
        check = false;
    }

    if(phone == '')
    {
        if(check)
            $('#phone').focus();
        $('#phone').parent().addClass('has-error');
        check = false;
    }

    if(email == '')
    {
        if(check)
            $('#email').focus();
        $('#email').parent().addClass('has-error');
        check = false;
    }
    else
    {
        if(!validateEmail(email))
        {
            if(check)
                $('#email').focus();
            $('#email').parent().addClass('has-error');
            check = false;            
        }
    }

    if(subject == '')
    {
        if(subject)
            $('#subject').focus();
        $('#subject').parent().addClass('has-error');
        check = false;
    }

    if(message == '')
    {
        if(message)
            $('#message').focus();
        $('#message').parent().addClass('has-error');
        check = false;
    }    


    if(check)
    {
        $('#spinner').show();
        $.ajax({
          type: 'POST',
          url: apiUrl + 'send_contact_query',
          dataType : "JSON",
          data: {name:name, phone: phone, email:email, subject:subject, message:message},
          beforeSend:function(){

          },
          success:function(data){
            $('#spinner').hide();
            showMsg('#contactmsg', 'Your query has been sent to admin.', '')
            resetContact();
          },
          error:function(jqxhr){
            $('#spinner').hide();
          }
        });        
    }

}
