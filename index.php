<?php 
    include("scripts/menu.php");
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
    <h1 id="title"> <?php echo $data->title();?></h1>
    <main class="login-informaton">
        <p>Фамилия Имя Отчество</p>    
        <button class="exit">Выход</button>
    </main>
    <main class="conteiner">
        <?php echo($data->content($data->state(),$data->title())); ?>
    </main>
    
</body>
</html>