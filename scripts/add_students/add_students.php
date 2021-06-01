<?php
$link = mysqli_connect('', 'root', '', 'isup');
function editStudents($id)
{
    global $link;
    if(isset($_POST['students'])){
        foreach($_POST['students'] as $student){
            $res = $link->query("SELECT `student_id` FROM `result` WHERE `lecture_id`=$id");
            if($res->num_rows>0){
                for($data=[];$row = $res->fetch_assoc();$data[]=$row);
                foreach($data as $row){
                    $studId = $row['student_id'];
                    if(!in_array($studId,$_POST['students']))
                        $link->query("DELETE FROM `result` WHERE `lecture_id`=$id AND `student_id`=$studId"); 
                }
            }
            $res = $link->query("SELECT * FROM `result` WHERE `lecture_id`=$id AND `student_id`=$student");
            if($res->num_rows==0)
                $link->query("INSERT INTO `result` (`student_id`, `lecture_id`) VALUES ('$student', '$id')");
        }
    }
}
if(isset($_POST['lectureId']) AND $_POST['lectureId']!=0){
    $id = $_POST['lectureId'];
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

