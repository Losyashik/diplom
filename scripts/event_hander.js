window.onload = function() {
    //отправка ajax запроса для изменения контента
    function reAnswer(state, title){
        $.ajax ({
            url: "scripts/content.php",
            type: "POST",
            data: {page: state, name:title},
            success: function (result) { 
                $(".conteiner").html(result);
                $("#title").html(title)
             }
        });
    }

    function handlerAnchors() {
        $(".navigation a").removeClass('selected');
        $(this).addClass('selected');
        var state = {
            title: this.getAttribute( "title" ),
            url: this.getAttribute( "href",2)
        }
        console.log(state.url)
        history.pushState( state, state.title, state.url );//запись в историю браузера перехода
        document.title = state.title;
        reAnswer(state.url, state.title);

        return false;
    }

    var anchors = document.getElementsByTagName( 'a' );
    for( var i = 0; i < anchors.length; i++ ) {
        anchors[ i ].onclick = handlerAnchors;
    }
    //Изменение стия меню при переходе через стрелки браузера и вызов функции reAnswer
     window.onpopstate = function( e ) {
         $(".navigation a").removeClass('selected');
         $('.navigation a[href$="' + history.state.url + '"]').addClass('selected');
         document.title = history.state.title;
         reAnswer(history.state.url, history.state.title);
    }
}