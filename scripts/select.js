function openSelect(list) {
    if (!list.hasClass('activ')) {
        $(list[0]).addClass('activ');
        $(list[0].children).each(function(i, e) {
            $(e).slideDown(300)
        });
    } else {
        $(list[0].children).each(function(i, e) {
            $(e).slideUp(300)
        });
        $(list[0]).removeClass('activ');
    }
}
$(document).mouseup(function(e) {
    var container = $(".select_list");
    if (container.has(e.target).length === 0) {
        if ($('.select_block').has(e.target).length === 0) {
            container.each((i,e)=>{
                if($(e).hasClass('activ'))
                    openSelect($(e))
            })
        }
    }
});
$(document).on('click', '.select', event => {
    list = $(event.currentTarget).next(".select_list");
    openSelect(list);
});
$(document).on('click', '.select_item', event => {
    item = $(event.currentTarget);
    var list = item.parent();
    openSelect(list);
    $(list[0].children).each(function(i, e) {
        if ($(e).hasClass('selected')) {
            $(e).removeClass('selected');
        }
    });
    item.addClass('selected');
    select = list.prev('.select');
    id = select.data('name');

    $('#' + id).val(item.data('value'));
    $(select[0].children[0]).html($(event.currentTarget.children).html());
})