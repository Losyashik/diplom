<?php
function echoArr($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}
function sortGroup()
{
    session_start();
    $query = "SELECT * FROM `groups` WHERE id in (SELECT group_id FROM gdp WHERE teacher_id=".$_SESSION['user']['id'].")";
    if (isset($_POST['specialty']))
        $query .= " AND specialty_id = ".$_POST['specialty'];
    if (isset($_POST['course']))
        $query .= " AND course_id = ".$_POST['course'];
    if(isset($_POST['search']))
        $query .= " AND name LIKE '%".$_POST['search']."%'";
    return $query;
}