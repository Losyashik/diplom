<?php
$link = mysqli_connect('', 'root', '', 'isup');
function editStudents($id)
{
    global $link;
    if(isset($_POST['students'])){
        foreach($_POST['students'] as $student){
            $link->query("INSERT INTO `result` (`student_id`, `lecture_id`) VALUES ('$student', '$id')");
        }
    }
}
if(isset($_POST['lectureId']) AND $_POST['lectureId']!=0){
    $id = $_POST['lectureId'];
    $link->query("DELETE FROM `result` WHERE `lecture_id`=$id")or die(mysqli_error($link));
    editStudents($id);
    echo "Изменения сохранены";
}
else{
    $date = $_POST['date'];
    $pair_number = $_POST['pair_number'];
    $gdp = $_POST['gdp'];
    $link->query("INSERT INTO `lecture` ( `date`, `pair_number`, `gdp_id`) VALUES ('$date', '$pair_number', '$gdp')");
    $id = $link->insert_id;
    editStudents($id);
    echo "Запись сохранена";
}

