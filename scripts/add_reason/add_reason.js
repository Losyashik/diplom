url_reason = 'scripts/add_reason/add_reason.php'
$(document).on('click', '#add_reason_button', event => {
    form = $(event.target).parent()
    add_data = {add:true}
    let bool = true;
    $(form).children('input,textarea').each(function (i, e) {
        val = $(e).val()
        nameInp = e.name
        if (val == '' || val == 0) {
            if (nameInp == "studId")
                $(e).next().css({ border: '2px solid #f00' })
            else
                $(e).css({ border: '2px solid #f00' })
            if(bool){
                bool=false;
            }
        }
        else {
            if (nameInp == "studId")
                $(e).next().removeAttr('style')
            else
                $(e).removeAttr('style')
            if (nameInp != '')
                add_data[nameInp] = val;
        }
    })
    if (bool) {
        $.ajax({
            url: url_reason,
            type: 'post',
            data: add_data,
            success: function (text) {
                $(form).trigger('reset')
                alert(text);
                sortContent(data,url)
            }
        })
        
    }
    else {
        return false;
    }
})
$(document).on('click','.delete_reason', event=>{
    reason = event.target.dataset.id;
    studId = data['sId']
    add_data = {delete:true,reason_id:reason,studId:studId}
    console.log(add_data);
    $.ajax({
        url: url_reason,
        type: 'post',
        data: add_data,
        success: function (text) {
            alert('Удалено');
            sortContent(data,url)
        }
    })
})