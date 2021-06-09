<?php
include_once("scripts/modules/login.php");
if (isset($_SESSION['user']))
    if (time() - $_SESSION['user']['last_time'] <= 1200) {
        $_SESSION['user']['last_time'] = time();
        $user = $_SESSION['user'];
    } else {
        unset($_SESSION['user']);
        header('Location:index.php');
    }
else {
    openLoginWindow();
}
include("scripts/menu.php");
$data = new load_page_vars();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="styles/style.css">
    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="scripts/event_hander.js"></script>
    <title><?php echo $data->title(); ?></title>
</head>

<body>
    <nav class="navigation_panel">
        <div class="navigation">
            <?php echo $data->menu(); ?>
        </div>
    </nav>
    <h1 id="title"> <?php echo $data->title(); ?></h1>
    <main class="login-informaton">
        <p><?php echo ($_SESSION['user']['full_name']) ?></p>
        <button class="exit">Выход</button>
    </main>
    <main class="conteiner">
        <?php echo ($data->content($data->state(), $data->title())); ?>
    </main>
    <script src="scripts/exit.js"></script>
    <script src="scripts/select.js"></script>
    <script src="scripts/requests.js"></script>
    <div id='script' style="display: none;"></div>
    <div class="loader">
        <img src="images/loader.gif" alt="Загрузка">
    </div>
</body>

</html>