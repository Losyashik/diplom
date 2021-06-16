<?php
    $link = mysqli_connect('localhost','root','','dota2news');
    $query = 'select * from news where id ='.$_GET['id'];
    $res = mysqli_query($link,$query);
    for ($data=[]; $row = mysqli_fetch_assoc($res); $data[]=$row);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $data[0]['title']?></title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic|Playfair+Display:400,700&subset=latin,cyrillic">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/media.css">
  <link rel="stylesheet" type="text/css" href="assets/css/NewsPageCSS.css">
  <script type="text/javascript" src="assets/js/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="assets/js/jsNews_left.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
  <script src="assets/js/main.js"></script>
<script src="assets/js/modernizr.js"></script>
  <script src="js/modernizr.js"></script>
</head>
<body>
<?php
  include "sidebar.php";
?>  

<div class="container">
    <div class="container_more_news">
    <strong class="News-sidebar_title">
        <a href="news.html">Новости</a>
        <hr class="News_line">
    </strong>
    <?php
      $result = $link->query("SELECT `id`, `title`, `text` FROM `news` WHERE id!=".$_GET['id']." and `datatime`>'2021-01-01' ORDER BY RAND() LIMIT 1");
      for($data1=[];$row = $result->fetch_assoc();$data1[]=$row);
      $result='';
      foreach($data1 as $elem){
        $result.='<div class="news_content">';
          $result.='<div class="left_block">';
            $result.='<p class="left_block_title">'.$elem['title'].'</p><hr>';
            $text = htmlspecialchars_decode($elem['text']);
            $text = substr($text,strpos($text,'<p class="text">')+16,270);
            $result.='<p class="left_block_article">'.$text.'...</p>';
            $result.='<a href="NewsPage.php?id='.$elem['id'].'" class="button_left_block">Подробнее</a>';
          $result.='</div>';
        $result.='</div>';
      }
      echo $result;
    ?>
    </div>
<div class="content_article">
    <div class="dota-text"><strong>Dota2</strong></div><br>
    <?php
    
    $res = '';
    foreach ($data as $elem){
        $DateTime = strtotime($elem['datatime']);
        $DateTime = date('d.m.Y, H:i',$DateTime);
        $res .= '<div class="title-text"><strong>'.$elem['title'].'</strong></div>';
        $res .= '<div class="date_time">'.$DateTime.'</div>';
        $res .= htmlspecialchars_decode($elem['text']);
    }
    echo $res;
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
    
<script>
$('.nav-toggle').on('click', function(){
  $('#menu').toggleClass('active');
});
</script>
</body>
</html>