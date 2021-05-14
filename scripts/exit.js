$('button.exit').on('click',function(){
    console.log('exit');    
    $.ajax({
        url: "scripts/login.php",
        type: "post",
        data: {exit:'1'},
        success:function(){
            location = location.href
        }
    })
})