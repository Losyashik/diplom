function checkLecture() {
    date = $('#date_lecture').val()
    pair_number = $('#pair_number').val()
    if (pair_number != '' & date != '') {
        $.ajax({
            url: 'scripts/add_students/checkLecture.php',
            method: 'post',
            data: {
                pair_number: pair_number,
                date: date,
                gdp: gdp
            },
            success: function(result) {
                $("#script").html(result);
                edit();
            }
        })
    }
};

function check(checkBlock) {
    studentId = checkBlock.data('value');
    if (!checkBlock.hasClass('checked')) {
        checkBlock.removeClass('checked');
        checkedId.push(studentId)
    } else {
        checkBlock.addClass('checked');
        checkedId.splice(checkedId.indexOf(studentId), 1)
    }
    console.log(studentId);
}
var checkedId = Array();
$(document).on('click', '.student_name', event => {
    checkBlock = $(event.currentTarget);
    check(checkBlock);
})
$(document).on('click', '#button_add_lecture', function() {
    date = $('#date_lecture').val()
    pair_number = $('#pair_number').val()
    if (pair_number == '') {
        $('#pair_number').css('background', '#f00')
        return false;
    }
    if (date == '') {
        $('#date_lecture').css('background', '#f00')
        return false;
    }
    $.ajax({
        url: "scripts/add_students/add_students.php",
        method: "post",
        data: {
            "pair_number": pair_number,
            "date": date,
            "discipline": disciplineId,
            "lectureId": lectureId,
            "gdp": gdp,
            "students[]": checkedId
        },
        success: function(result) {
            alert(result);
            checkLecture()
        }
    })
})
$(document).on('change', '.add_lecture', function(event) {
    checkLecture();
});