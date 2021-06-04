
var state = {
    title: "Панель администратора",
    url: "./admin"
}
$('.submit').on('click', event=>{
    
    dataName  = event.currentTarget.name;
    form = $(event.target).parent()
    bol=true;
    error = form.children('.error')[0]
    event.preventDefault();
    if(dataName=="group"){
        $($(form).children()[0]).children('input:not(.submit), textarea').each(function (i, e) {
            val = $(e).val()
            nameInp = e.name
            if (val == '' || val == 0) {
                bol = false;
                if ($(e).hasClass('select'))
                    $(e).next().css({ border: '2px solid #f00' })
                else
                    $(e).css({ border: '2px solid #f00' })
            }
            else {
                if ($(e).hasClass('select'))
                    $(e).next().removeAttr('style')
                else
                    $(e).removeAttr('style')
            }
        })
        stud= $($($(form).children()[1]).children('.stud_inp')[0]).children()
        if(stud.length>0)
            stud.each(function (i, e) {
                val = $(e.childNodes[0]).val()
                if (val == '' || val == 0) {
                    bol=false;
                    $(e).css({ border: '2px solid #f00' })
                }
                else {
                    $(e).removeAttr('style')
                }
            })
        else{
            bol=false;
        }
        
    }
    else{
        $(form).children('input:not(.submit),textarea').each(function (i, e) {
            
            val = $(e).val()
            nameInp = e.name
            if (val == '' || val == 0) {
                bol = false;
                if ($(e).hasClass('select'))
                    $(e).next().css({ border: '2px solid #f00' })
                else
                    $(e).css({ border: '2px solid #f00' })
            }
            else {
                if ($(e).hasClass('select'))
                    $(e).next().removeAttr('style')
                else
                    $(e).removeAttr('style')
            }
        })
    }
    if(bol){
        add_data = $(form).serialize()
        add_data+= "&formName="+dataName;
        $.ajax({
            url:'scripts/scripts_for_admin/edit.php',
            type:'post',
            data:add_data,
            success:function(text){
                $(error).html(text);
                add_data='';
                $(form)[0].reset();
            }
        })
    }   
    else{
        return false;
    }
})
$('.delete_admin').on('click',event=>{
    listName = $(event.currentTarget).data('name-list');
    id = $(event.currentTarget).data('delete-id');
    add_data = {formName:listName,id:id}
    switch(listName){
        case 'delete_specialty':
            title = "Вы уверены что хотите удалить специальность и все данные связанные с ней? Если да, то введите true";       
        break;
        case 'delete_teacher':
            title = "Вы уверены что хотите удалить преподавателя и все данные связанные с ним? Если да, то введите true";
        break;
        case 'delete_discipline':
            title = "Вы уверены что хотите удалить дисцыплину и все данные связанные с ней? Если да, то введите true";
        break;
        case 'delete_gdp':
            title = "Вы уверены что хотите удалить данную связь и все данные связанные с ней? Если да, то введите true";
        break;
        case 'delete_group':
            title = "Вы уверены что хотите удалить группу и все данные связанные с ней? Если да, то введите true";
        break;
    }
    
    result = prompt(title);
   
    if(result){
        console.log(result);
        $.ajax({
            url:'scripts/scripts_for_admin/edit.php',
            type:'post',
            data:add_data,
            success:function(text){
                alert(text);
                add_data='';
            }
        })
    }
     else{
        return false;
    }
})
$(document).on('click', '.hidden_block', event => {
    reAnswer(state.url, state.title);
})

