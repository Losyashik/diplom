<?php
$link = mysqli_connect('localhost', 'root', '', 'isup');

if(isset($_POST['add'])){
    $start = $_POST['start'];
    $end = $_POST['end'];
    $description = $_POST['description'];
    $studId = $_POST['studId'];

    $result = $link->query("SELECT reason_id FROM result WHERE student_id = $studId");
    if($result->num_rows>0){
        $link->query("INSERT INTO `reason`(`date_start`, `date_end`, `reason`) VALUES ('$start','$end','$description')");
        echo($link->error);
        $reason_id = $link->insert_id;
        $link->query("UPDATE `result` SET `reason_id`=$reason_id WHERE lecture_id IN (SELECT id FROM lecture WHERE `date` >= '$start' AND `date` <= '$end') AND student_id=$studId");
        echo("Добавлено");
    }
    else{
        echo('В выбранный период данный студент либо присутствовал на парах, либо преподавательеще не добавил пропуски студента');
    }
    
}
if(isset($_POST['delete'])){
    $studId = $_POST['studId'];
    $reason_id = $_POST['reason_id'];
    echo "UPDATE `result` SET `reason_id` = NULL WHERE id_student = $studId; "."DELETE FROM `reason` SET WHERE id = $reason_id";
    $link->query("UPDATE `result` SET `reason_id` = NULL WHERE student_id = $studId AND reason_id = $reason_id");
    $link->query("DELETE FROM `reason` SET WHERE id = $reason_id");

}

