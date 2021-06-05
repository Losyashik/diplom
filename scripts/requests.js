$(document).on('click', '.report_for_discipline', event => {

    conteinerPosition = $('.conteiner').offset()
    conteinerWidth = $('.conteiner').width()
    modalWidth = $('.open_request_block').width()

    y = event.pageY - conteinerPosition.top;
    if ((conteinerPosition.left + conteinerWidth) < (event.clientX + modalWidth)) {
        x = event.pageX - conteinerPosition.left - modalWidth;
    }
    else
        x = event.pageX - conteinerPosition.left;
    $('.open_request_block').css({ top: y, left: x })
    $('.open_request_block').show();
})
$(document).on('click', '.sort .select_item', event => {
    item = $(event.currentTarget);
    list = item.parent();
    select = list.prev('.select');
    id = select.data('name');
    if (title != '' && title != undefined) {
        titleIn[id] = $(item[0].children[0]).html();
        titleDate = titleIn['mounth'] + ' ' + titleIn['year'] + ' года';
    }
    if (item.data('value') == 0) {
        delete data[id]
    }
    else {
        data[id] = item.data('value')
    }
    sortContent(data, url);
})
$(document).on('keyup', '#search_group', event => {
    item = $(event.currentTarget);
    if (item.val() == "")
        delete data['search']
    else
        data['search'] = item.val()
    console.log(data);
    sortContent(data, url);
})
$(document).on("change", '.select_day', event => {
    date = $(event.currentTarget).val();
    data['date'] = date;
    sortContent(data, url);
})
function CallPrint(strid) {
    var prtContent = document.querySelector(strid);
    var prtCSS = '<link rel="stylesheet" href="styles/style.css" type="text/css" />';
    var WinPrint = window.open('', '', 'left=50,top=50,width=1230,height=620,toolbar=0,scrollbars=1,status=0');
    WinPrint.document.write('<style>body{size: landscape;}</style>')
    WinPrint.document.write('<h2 style="text-align:center;">' + title + titleDate + '</h1>');
    WinPrint.document.write('<div id="print" class="contentpane">');
    WinPrint.document.write(prtCSS);
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.write('</div>');
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.onload = () => { WinPrint.print(); }
}
$(document).on('change', '#kol', event => {
    block = '';
    kol = $(event.currentTarget).val();
    for (i = 0; i < kol; i++) { block += "<div class='student'><input type='text' name='students[]' placeholder='Фамилия Имя через пробел'></div>"; }
    $('.stud_inp').html(block);
})

