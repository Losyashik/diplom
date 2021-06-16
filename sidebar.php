<?php
$link = mysqli_connect('localhost','root','','dota2news');
session_start();
if (isset($_GET['exit'])) {
    unset($_SESSION['login']);
    session_destroy();//Сброс сессии авторизации
    $ser=$_SERVER['REQUEST_URI'];
    $ser=substr($ser,0,-7);
    header('Location:'.$ser);
}
if(empty($_SESSION['login'])){
    $log = '<nav class="main-nav"><ul><!-- inser more links here --><li><a class="cd-signin" href="#0">Sign in</a></li><li><a class="cd-signup" href="#0">Sign up</a></li></ul></nav>';
}
else{
    if($_SESSION['login'][0]['bol_admin']){
      $log = '<nav class="main"><li><a href="admin" target = "_blank">'.$_SESSION['login'][0]['name'].'</a></li><li><a class="cd-signup" href="index.php?exit=1">Exit</a></nav></li>';
    }
    else{
        $log = '<nav class="main"><li><a>'.$_SESSION['login'][0]['name'].'</a></li><li><a class="cd-signup" href="index.php?exit=1">Exit</a></nav></li>';
    }
}
if(isset($_POST['login'])){
    $e_mail = $_POST['e-mail'];
    $password = md5($_POST['password']);
    $query = 'SELECT * FROM `user` WHERE `e-mail` = "'.$e_mail.'" AND `password` = "'.$password.'"';
    $result = mysqli_query($link,$query) or die(mysqli_error($link));
    if(mysqli_num_rows($result)==1){
        for($data=[]; $row=mysqli_fetch_assoc($result); $data[]=$row);
        $_SESSION['login'] = $data;
    }
    else{
        echo('none');
    }
    $ser=$_SERVER['REQUEST_URI'];
	$ser=substr($ser,0,strlen($ser));
	echo $ser;
    header('Location:index.php');
}
if(isset($_POST['registration'])){
	$name = $_POST['name'];
	$mail = $_POST['mail'];
	$password = md5($_POST['password']);

	$link->query("INSERT INTO `user`(`name`, `e-mail`, `password`) VALUES ('$name', '$mail', '$password')") or die($link->error);
	$ser=$_SERVER['REQUEST_URI'];
	$ser=substr($ser,0,strlen($ser));
	$query = 'SELECT * FROM `user` WHERE `e-mail` = "'.$e_mail.'" AND `password` = "'.$password.'"';
    $result = mysqli_query($link,$query) or die(mysqli_error($link));
    if(mysqli_num_rows($result)==1){
        for($data=[]; $row=mysqli_fetch_assoc($result); $data[]=$row);
        $_SESSION['login'] = $data;
    }
    header('Location:index.php');
}
?>
<header>
<link rel="stylesheet" href="css/style.css"> <!-- Gem style -->
    <nav class="container1">
      <a href="index.php" >
          <div class="logotip">
          </div>
      </a>
      <div class="nav-toggle"><span></span></div>
      <form action="" method="get" id="searchform">
        <input type="text" placeholder="Искать на сайте...">
        <button type="submit"><i class="fa fa-search"></i></button>
      </form>
      <ul id="menu">
        <li><a href="index.php">Главная</a></li>
        <li><a href="news.php">Новости</a></li>
        <li><a href="rating.php">Рейтинг</a></li>
			<?php echo($log);?>
      </ul>
    </nav>
</header>
	<div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
		<div class="cd-user-modal-container"> <!-- this is the container wrapper -->
			<ul class="cd-switcher">
				<li><a href="#0">Войти</a></li>
				<li><a href="#0">Создать аккаунт</a></li>
			</ul>

			<div id="cd-login" method = "POST"> <!-- log in form -->
				<form class="cd-form" method="POST">
					<p class="fieldset">
						<label class="image-replace cd-email" for="signin-email">E-mail</label>
						<input class="full-width has-padding has-border" name="e-mail" id="signin-email" type="text" placeholder="E-mail">
						<!-- <span class="cd-error-message">Error message here!</span> -->
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signin-password">Password</label>
						<input class="full-width has-padding has-border" id="signin-password" name="password" type="text"  placeholder="Password">
						<a href="#0" class="hide-password">Скрыть</a>
						<!-- <span class="cd-error-message">Error message here!</span> -->
					</p>
					<p class="fieldset">
						<input class="full-width" type="submit" name="login" value="Login">
					</p>
				</form>
				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div> <!-- cd-login -->

			<div id="cd-signup"> <!-- sign up form -->
				<form class="cd-form" method="POST"> 
					<p class="fieldset">
						<label class="image-replace cd-username" for="signup-username">Никнейм</label>
						<input class="full-width has-padding has-border" name="name" id="signup-username" type="text" placeholder="Username">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-email" for="signup-email">E-mail</label>
						<input class="full-width has-padding has-border" name = 'mail' id="signup-email" type="email" placeholder="E-mail">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signup-password">Пароль</label>
						<input class="full-width has-padding has-border" name='password' id="signup-password" type="text"  placeholder="Password">
						<a href="#0" class="hide-password">Скрыть</a>
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<input class="full-width has-padding" name='registration' type="submit" value="Create account">
					</p>
				</form>

				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div> <!-- cd-signup -->
			<a href="#0" class="cd-close-form">Close</a>
		</div> <!-- cd-user-modal-container -->
	</div> <!-- cd-user-modal -->