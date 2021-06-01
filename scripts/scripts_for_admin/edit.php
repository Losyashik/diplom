<?php
$link = mysqli_connect('localhost', 'root', '', 'isup');
function echoArr($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}
switch ($_POST['formName']){
    case 'specialty':
        $result = $link->query("INSERT INTO specialty(`name`,`code`) VALUES ('".$_POST['title']."','".$_POST['code']."')");
        if($result){
            echo "<font color='#0f0'>Добавлено</font>";
        }
        else{
            echo "Ошибка";
        }
    break;
    case "discipline":
        $result = $link->query("INSERT INTO discipline(`name`) VALUES ('".$_POST['title']."')");
        if($result){
            echo "<font color='#0f0'>Добавлено</font>";
        }
        else{
            echo "Ошибка";
        }
    break;
    case "teacher":
        if($_POST['password']==$_POST['dbl_password']){
            $password = password_hash($_POST['password'],1);
            $result = $link->query("INSERT INTO teacher(`name`,`surname`,`patronymic`,`login`,`password`,`role_id`) VALUES ('".$_POST['name']."','".$_POST['surname']."','".$_POST['patronymic']."','".$_POST['login']."','$password','".$_POST['role']."')");
            if($result){
                echo "<font color='#0f0'>Добавлено</font>";
            }
            else{
                echo "Ошибка";
            }
        }
        else{
            echo('Пароли не совпадают');
        }
    break;
    case "gdp":
        $result = $link->query("SELECT id FROM gdp WHERE`group_id` = ".$_POST['group']." and `discipline_id` = ".$_POST['discipline']." and `teacher_id` = ".$_POST['teacher']);
        if(mysqli_num_rows($result)==0){
            $result = $link->query("INSERT INTO gdp(`group_id`,`discipline_id`,`teacher_id`) VALUES ('".$_POST['group']."','".$_POST['discipline']."','".$_POST['teacher']."')");
            if($result){
                echo "<font color='#0f0'>Добавлено</font>";
            }
            else{
                echo "Ошибка";
            }
        }
        else{
            echo "Днная связь уже существует";
        }
    break;
    case "group":
       $result = $link->query("INSERT INTO groups(`name`, `specialty_id`,`course_id`,`curator_id`) VALUES ('".$_POST['title']."','".$_POST['specialty']."','".$_POST['course']."','".$_POST['teacher']."')");
        if($result){
            $id = $link->insert_id;
            foreach($_POST['students'] as $student){
                $student = explode(' ',$student);
                $result = $link->query("INSERT INTO students(`name`,`surname`,`group_id`) VALUES ('".$student[1]."','".$student[0]."','$id')");
                if(!$result){
                    echo "Ошибка: "."INSERT INTO students(`name`,`surname`,`group_id`) VALUES ('".$student[1]."','".$student[0]."','$id')";
                    break;
                }
            }
            if(!$result){
                break;
            }
            echo "<font color='#0f0'>Добавлено</font>";   
        }
        else{
            echo "Ошибка";
        }
        break;
        case 'delete_specialty':
            $id = $_POST['id'];
            $link->query("DELETE FROM reason WHERE id in (SELECT reason_id FROM result WHERE student_id in (SELECT id FROM students WHERE group_id in (SELECT id FROM groups WHERE specialty_id = $id)))") or die($link->error);
            $link->query("DELETE FROM result WHERE student_id in (SELECT id FROM students WHERE group_id in (SELECT id FROM groups WHERE specialty_id = $id))") or die($link->error);
            $link->query("DELETE FROM students WHERE group_id in (SELECT id FROM groups WHERE specialty_id = $id)") or die($link->error);
            $link->query("DELETE FROM lecture WHERE gdp_id in(SELECT id FROM gdp WHERE group_id in (SELECT id FROM groups WHERE specialty_id = $id))") or die($link->error);
            $link->query("DELETE FROM gdp WHERE group_id in (SELECT id FROM groups WHERE specialty_id = $id)") or die($link->error);
            $link->query("DELETE FROM groups WHERE specialty_id = $id") or die($link->error);
            $link->query("DELETE FROM specialty WHERE id = $id") or die($link->error);
            break;
        case 'delete_teacher':
            $id = $_POST['id'];
            $link->query("DELETE FROM reason WHERE id in (SELECT reason_id FROM result WHERE lecture_id in (SELECT id FROM lecture WHERE gdp_id in (SELECT id FROM gdp WHERE teacher_id = $id)))") or die($link->error);
            $link->query("DELETE FROM result WHERE lecture_id in (SELECT id FROM lecture WHERE gdp_id in (SELECT id FROM gdp WHERE teacher_id = $id))") or die($link->error);
            $link->query("DELETE FROM lecture WHERE gdp_id in (SELECT id FROM gdp WHERE teacher_id = $id)") or die($link->error);
            $link->query("DELETE FROM gdp WHERE teacher_id = $id") or die($link->error);
            $link->query("DELETE FROM teacher WHERE id = $id") or die($link->error);
        break;
        case 'delete_discipline':
            $id = $_POST['id'];
            $link->query("DELETE FROM reason WHERE id in (SELECT reason_id FROM result WHERE lecture_id in (SELECT id FROM lecture WHERE gdp_id in (SELECT id FROM gdp WHERE discipline_id = $id)))") or die($link->error);
            $link->query("DELETE FROM result WHERE lecture_id in (SELECT id FROM lecture WHERE gdp_id in (SELECT id FROM gdp WHERE discipline_id = $id))") or die($link->error);
            $link->query("DELETE FROM lecture WHERE gdp_id in (SELECT id FROM gdp WHERE discipline_id = $id)") or die($link->error);
            $link->query("DELETE FROM gdp WHERE discipline_id = $id") or die($link->error);
            $link->query("DELETE FROM discipline WHERE id = $id") or die($link->error);
        break;
        case 'delete_gdp':
            $id = $_POST['id'];
            $link->query("DELETE FROM reason WHERE id in (SELECT reason_id FROM result WHERE lecture_id in (SELECT id FROM lecture WHERE gdp_id in (SELECT id FROM gdp WHERE id = $id)))") or die($link->error);
            $link->query("DELETE FROM result WHERE lecture_id in (SELECT id FROM lecture WHERE gdp_id in (SELECT id FROM gdp WHERE id = $id))") or die($link->error);
            $link->query("DELETE FROM lecture WHERE gdp_id in (SELECT id FROM gdp WHERE id = $id)") or die($link->error);
            $link->query("DELETE FROM gdp WHERE id = $id") or die($link->error);
        break;
        case 'delete_group':
            $id = $_POST['id'];
            $link->query("DELETE FROM reason WHERE id in (SELECT reason_id FROM result WHERE lecture_id in (SELECT id FROM lecture WHERE gdp_id in (SELECT id FROM gdp WHERE group_id = $id)))") or die($link->error);
            $link->query("DELETE FROM result WHERE lecture_id in (SELECT id FROM lecture WHERE gdp_id in (SELECT id FROM gdp WHERE group_id = $id))") or die($link->error);
            $link->query("DELETE FROM lecture WHERE gdp_id in (SELECT id FROM gdp WHERE group_id = $id)") or die($link->error);
            $link->query("DELETE FROM gdp WHERE group_id = $id") or die($link->error);
            $link->query("DELETE FROM students WHERE group_id = $id") or die($link->error);
            $link->query("DELETE FROM groups WHERE id = $id") or die($link->error);
        break;
    default:
        EchoArr($_POST);
}