<?php
$link = mysqli_connect('','root','','isup');
session_start();
if(isset($_POST['login'])){
    $login = $_POST['login'];
    $password = $_POST['password'];
    $result = $link->query("SELECT * FROM teacher WHERE login='$login'");
    if(mysqli_num_rows($result)>0){
        for($data=[]; $row=mysqli_fetch_assoc($result);$data=$row);
        if(password_verify($password,$data['password'])){
            $_SESSION['user']=[
                "id"=>$data['id'],
                "full_name"=>$data['surname'].' '.$data['name'].' '.$data['patronymic'],
                "role" => $data['role_id'],
                "last_time" => time()
            ];
            header('Location:/');
        }
    }
    
}
if(isset($_POST['exit'])){
    unset($_SESSION['user']);
}
function openLoginWindow()
{
    //echo password_hash('123',1);
    $content = '
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="styles/style.css">
        <script src="scripts/jquery-3.4.1.js"></script>
        <title>Авторизация</title>
    </head>  
    <div class="modal_window" id="login">
        <div class="hidden_block"></div>
        <form class="login" method="POST">
            <h2>Авторизация</h2>
            <input name="login" type="text" placeholder="Логин">
            <input name="password" type="password" placeholder="Пароль">
            <input type="submit" value="Войти" name="loginin">
        </form>
    </div>
    <script>
        $(window).ready(function () {
            $("#login form").css({"top":"30%","opacity":"1"});
        });
    </script>
    ';
    echo $content;
    exit;

}
