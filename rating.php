<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dota2News</title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic|Playfair+Display:400,700&subset=latin,cyrillic">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/media.css"> <!-- Gem style -->
  <link rel="stylesheet" href="assets/css/mediaRating1.css"> <!-- Gem style -->
  <link rel="stylesheet" type="text/css" href="assets/css/Rating1.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
  <script src="js/modernizr.js"></script> <!-- Modernizr -->
</head>
<body>
<?php
  include "sidebar.php"
?>  
    
    <div class="container">
      <div class="topKomand">
        <h3>ТОП команд</h3></div>
        <div class="table">
          <div class="table-header">
            <div class="header__item"><a id="name" class="filter__link" href="#">Место</a></div>
            <div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">Команда</a></div>
            <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">Рейтинг</a></div>
            <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">Доля побед</a></div>
            <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">Последняя игра</a></div>
          </div>
          <div class="table-content">
            <?php 
              $query = 'SELECT *,country.src as flag_img FROM `command`,`country` WHERE `country`.`id`=command.flag_img order by `rating` DESC';
              $result = mysqli_query($link,$query);
              for($data=[]; $row=mysqli_fetch_assoc($result);$data[]=$row);
              $result = '';
              $i = 0;
              foreach($data as $elem){
                $i++;
                
                $result.='<div class="table-row">';
                if($i<=3){
                  $result.='<div class="table-data">';
                    $result.='<div class="place1"><img src="assets/img/top'.$i.'.png"></div>';
                  $result.='</div>';
                }
                else{
                  $result.='<div class="table-data">';
                    $result.='<div class="place1"><span class="span1">'.$i.'</span></div>';
                  $result.='</div>';
                }
                  $result.='<div class="table-data">';
                    $result.='<div class="flag"><img src="'.$elem['flag_img'].'" width="30px" height="30px"></div>';//флаг команды
                    $result.='<div class="logokomand"><img src="'.$elem['logo_img'].'" width="50px" height="60px"></div>';//логотип команды
                    $result.='<div class="komanda1">'.$elem['name'].'</div>';//название команды
                  $result.='</div>';
                  $result.='<div class="table-data">';
                    $result.='<div class="rating">'.$elem['rating'].'</div>';//рейтинг команды
                  $result.='</div>';
                  $result.='<div class="table-data">';
                    $result.='<div class="dolya">'.$elem['wins'].'%</div>'; //Доля побед команды
                  $result.='</div>';
                  $result.='<div class="table-data">';
                    if($elem['last_game']){
                      $result.='<div class="last_game">Win</div>';//Последняя игра команды
                    }
                    else{
                      $result.='<div class="last_game">---</div>';//Последняя игра команды
                    }
                    
                  $result.='</div>';
                $result.='</div>';
                $result.='<hr>';
                  
              }
              echo $result;
            ?>
      <a id="anchor" class="anchor100"></a>

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