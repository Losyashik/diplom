<?php
	$link=mysqli_connect('localhost','root','','dota2news');
	$result = $link->query("SELECT title_img as img, title, text, id,datatime AS date, 'NewsPage.php' AS `tab` FROM news UNION SELECT img, title,text,id,date, 'events.php' AS tab FROM events ORDER BY `date`  DESC");
	for($data = [];$row = $result->fetch_assoc();$data[]=$row);
	$result = '';
	foreach($data as $elem){
		$result.='<div class="post-item">';
			$result.='<div class="item-content">';
				$result.='<div class="item-icon tree"><img src="'.$elem['img'].'" alt=""></div>';
				$result.='<div class="item-body">';
					$result.='<h3>'.$elem['title'].'</h3>';
					$text = $elem['text'];
					if($elem['tab']=='events.php'){
						$text = substr($text,0,220);
					}
					else{
						$start = mb_strpos($text,'&lt;p class=&quot;text&quot;&gt;')+32;
						$finish = mb_strpos($text,'&lt;/p&gt;');
						if(($finish-$start)> 220)
							$text = mb_substr($text,$start+32,220);
						else
							$text = mb_substr($text,$start,$finish-$start);
					}
					$text = htmlspecialchars_decode($text);
					$result.='<p>'.$text.'...</p>';
				$result.='</div>';
				$result.='<div class="item-footer">';
					$result.='<a href="'.$elem['tab'].'?id='.$elem['id'].'" class="link"><span>Подробнее</span></a>';
				$result.='</div>';
			$result.='</div>';
		$result.='</div>';
	}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dota2News</title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic|Playfair+Display:400,700&subset=latin,cyrillic">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/newsCSS.css">
  <link rel="stylesheet" type="text/css" href="assets/css/media.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
  <style>
	.item-icon {
		background-size: auto;
		width: auto;
		height: 100px;
	}
	  img{
		  height:100%;
		  object-fit: cover;
		  
	  }
  </style>
</head>
<body>
<?php
	include "sidebar.php"
?>    
<div class="container">
<div class="post-wrap">
	<?php
		echo $result;
	?>
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