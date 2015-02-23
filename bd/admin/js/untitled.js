
=======
}

function showdealAddPopup()
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
}

function getDeals()
{
  var id = $('#deal_id').val();

    $.ajax({
      type: 'GET',
      url: apiUrl + 'deals',
      dataType : "JSON",
      //data: {id: id},
>>>>>>> bed681e5408278c011dfd79473df1b8b9d19ea6c







=======
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
                            <td>'+value.status+'</td>\
                            <td><a href="javascript:void(0);" data-toggle="modal" onclick="getSingleDeal('+value.id+', \''+value.deal_name+'\', \''+value.start_date+'\', \''+value.end_date+'\', \''+value.desc+'\');" data-target="#adddeal">Edit</a> | <a href="javascript:void(0);" onclick="deleteDeal('+value.id+');">Delete</a></td>\
>>>>>>> bed681e5408278c011dfd79473df1b8b9d19ea6c













=======
                        <td colspan="6" align="center">Deals not found</td>\
                     </tr>';            
        }

        $('#dealbody').html(html);
       //$('#sub_cat_id').append(options);
>>>>>>> bed681e5408278c011dfd79473df1b8b9d19ea6c

