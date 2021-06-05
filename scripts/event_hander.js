title = undefined;
//отправка ajax запроса для изменения контента
function reAnswer(state, title) {
    $.ajax({
        url: "scripts/content.php",
        type: "post",
        data: { page: state, name: title },
        success: function (result) {
            $(".conteiner").html(result);
            $("#title").html(title)
            $('.loader').hide();
        }
    });
}
window.onload = function () {

    function handlerAnchors(event) {
        $('.loader').show();
        $(".navigation a").removeClass('selected');
        $(this).addClass('selected');
        var state = {
            title: event.currentTarget.getAttribute("title"),
            url: event.currentTarget.getAttribute("href", 2)
        }
        console.log(state.url)
        history.pushState(state, state.title, state.url);//запись в историю браузера перехода
        document.title = state.title;
        reAnswer(state.url, state.title);

        return false;
    }

    $(document).on('click', 'a', function (event) {
        handlerAnchors(event);
    })
    //Изменение стиля меню при переходе через стрелки браузера и вызов функции reAnswer
    window.onpopstate = function () {
        $('.loader').show();
        $(".navigation a").removeClass('selected');
        $('.navigation a[href$="' + history.state.url + '"]').addClass('selected');
        document.title = history.state.title;
        reAnswer(history.state.url, history.state.title);
    }
}
function sortContent(data, url) {
    $.ajax({
        url: url,
        type: "post",
        data: data,
        success: function (content) {
            $('.conteiner_list').html(content);
        }
    })
}
$(document).on('click', '.open_modal_window', event => {
    modalId = event.currentTarget.dataset.modalId
    $('#' + modalId).show()
})
$(document).on('click', '.hidden_block', event => {
    modalId = event.currentTarget.dataset.modalId
    $('#' + modalId).hide()
})
