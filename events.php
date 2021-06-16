<?php
	$id = $_GET['id'];
	$link = mysqli_connect('localhost','root','','dota2news');
	$result = $link->query("SELECT * FROM events WHERE id = $id");
	for($data = []; $row = $result->fetch_assoc(); $data[]=$row);
	$data = $data[0];
	$data['date'] = date('d.m.Y',strtotime($data['date']));
	

?>
<!DOCTYPE html>
<html lang="ru" >
<head>
  <meta charset="utf-8">
  <style>
	  img{
		  height: 500px;
		  object-fit: cover;
	  }
  </style>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo($data['title'])?></title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic|Playfair+Display:400,700&subset=latin,cyrillic">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
  <link rel="stylesheet" href="css/style.css"> <!-- Gem style -->
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/events.css">
  <link rel="stylesheet" type="text/css" href="assets/css/media.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300&family=Crimson+Text:wght@700&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
</head>
<body>
<?php
	include "sidebar.php";
	
	?>
    
<div class="container" >
	
<div class="img-event"><img src="<?php echo $data['img']?>"></div> <!-- Фото ивента -->
<div class="the_name_of_the_tournament"><span><?php echo $data['title']?></span></div> <!-- Название ивента -->
<div class="date">Дата проведения: <span><?php echo $data['date']?></span></div> <!-- Дата проведения -->
<hr>
<div class="text_tournament"><span><?php echo $data['text']?></span></div> <!-- информация о ивенте -->
<hr>
    
<div class="items">
                    <div class="item">
                        <span>Турнир</span><br>
                        <strong class="item1"><?php echo $data['name']?></strong> <!-- Название турнира -->
                    </div>
<hr size="120">
                                            <div class="item">
                            <span>Локация</span><br>
                            <strong class="item1"><?php echo $data['location']?></strong> <!-- Город -->
                                            </div>
<hr size="120">
                                            <div class="item">
                            <span>Формат</span><br>
                            <strong class="item1"><?php echo $data['formate']?></strong><!-- Формат -->
                                            </div>
<hr size="120">
                                        <div class="item">
                        <span>Сумма призовых</span><br>
                        <strong class="item1">$<?php echo $data['summ']?></strong> <!-- Сумма в долларах -->
                                        </div>
</div>

</div> <!-- конец div class="container"-->

<footer>
  <div class="container3">
    <div class="footer-col"><span>Dota2News © 2020</span></div>
    <div class="footer-col">
      <div class="social-bar-wrap">
        <a title="Facebook" href="" target="_blank"><i class="fa fa-facebook"></i></a>
        <a title="Twitter" href="" target="_blank"><i class="fa fa-twitter"></i></a>
        <a title="Pinterest" href="" target="_blank"><i class="fa fa-pinterest"></i></a>
        <a title="Instagram" href="" target="_blank"><i class="fa fa-instagram"></i></a>
      </div>
    </div>
    <div class="footer-col">
      <a href="mailto:admin@yoursite.ru">Обратная связь</a>
    </div>
  </div>
</footer>
<script src="assets/js/main.js"></script>
<script src="assets/js/modernizr.js"></script>
<script type="text/javascript"></script>
<script type="text/javascript" src="assets/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="assets/js/ajax-form.js"></script>   
<script>
$('.nav-toggle').on('click', function(){
  $('#menu').toggleClass('active');
});
</script>
</body>
</html>