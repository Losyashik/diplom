<?php
$link = mysqli_connect('localhost', 'root', '', 'dota2news');
if (isset($_GET['id'])) {
    $query = 'select *  from events where id=' . $_GET['id'];
    $res = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($res);
    $data['text'] = htmlspecialchars_decode($data['text']);
    $data['img'] = '../'.$data['img'] ;
    $bol = true;
    $a = $_GET['id'];
} else {
    $query = 'SELECT MAX(id) as mid FROM events';
    $data = ['name'=>'Введите название ткрнира','title'=>'Ввеите заголовок','text'=>'Введите информацию о ивенте','location'=>'Введите локацию','formate'=>'Введите формат турнира','summ'=>'Введите сумму призовых','img'=>'','date'=>''];
    $a = mysqli_query($link, $query);
    $a = mysqli_fetch_array($a);
    $a = $a['mid'];
    $a += 1;
    $bol = false;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <style>
	  strong.item1{
		  min-width: 20%;
		  min-height: 25px;
		  display: inline-block;
	  }
	  img{
		  height: 500px;
		  object-fit: cover;
	  }
	  .img-event{
		  height: 500px;
	  }
	  img:hover + .edit_image{
		display: block;
	  }
	  .edit_image {
            width: 100%;
            height: 100%;
            opacity: .8;
            background: #000000;
            position: relative;
            top: -500px;
            display: none;
            text-align: center;
            vertical-align: middle;
            color: #FFFFFF;
        }
		.edit_image:hover {
            display: block;
        }
		.edit_image div {
            opacity: 1;
            
            display: block;
            top: 220px;
            z-index: 100;
            width: 100%;
            position: relative;
        }
		button{
			position: fixed;
			top:20px;
			right: 20px;
			width: 10%;
			font-size: 15pt;
			background-color: #d50a0a;
		}
  </style>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dota2News</title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic|Playfair+Display:400,700&subset=latin,cyrillic">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
  <link rel="stylesheet" href="../css/style.css"> <!-- Gem style -->
  <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/events.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/media.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300&family=Crimson+Text:wght@700&display=swap" rel="stylesheet">
<script type="text/javascript" src="../assets/js/jquery-3.5.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
</head>
<body>
<button type='submit'>Опубликовать</button>
<input type="file" accept="image/jpeg,image/png,image/gif" id="img" name="img" style="display: none;">
<div class="container">
<div class="img-event"><img src='<?php echo $data['img'] ?>' alt="Изображение" id='image'><label class="edit_image" for="img"><div>Изменить изображение</div></label></div> <!-- Фото ивента -->
<div class="the_name_of_the_tournament"><span id="title" contenteditable="true"><?php echo $data['title'] ?></span></div> <!-- Название ивента -->
<div class="date">Дата проведения: <span><input id='date' value="<?php echo $data['date'] ?>" type="date"></span></div> <!-- Дата проведения -->
<hr>
<div class="text_tournament" contenteditable="true"><?php echo $data['text'] ?></div> <!-- информация о ивенте -->
<hr>
    
<div class="items">
                    <div class="item">
                        <span>Турнир</span><br>
                        <strong class="item1" id = "name"contenteditable="true"><?php echo $data['name'] ?></strong> <!-- Название турнира -->
                    </div>
<hr size="120">
                                            <div class="item">
                            <span>Локация</span><br>
                            <strong class="item1" id="location" contenteditable="true"><?php echo $data['location'] ?></strong> <!-- Город -->
                                            </div>
<hr size="120">
                                            <div class="item">
                            <span>Формат</span><br>
                            <strong class="item1" id="formate" contenteditable="true"><?php echo $data['formate'] ?></strong><!-- Формат -->
                                            </div>
<hr size="120">
                                        <div class="item">
                        <span>Сумма призовых</span><br>
						<strong>$</strong><strong class="item1" id='summ' contenteditable="true"><?php echo $data['summ'] ?></strong> <!-- Сумма в долларах -->
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
<script>
$('.nav-toggle').on('click', function(){
  $('#menu').toggleClass('active');
});
<?php 
	if ($bol) {
		echo 'var bol = true;';
	} else {
		echo 'var bol = false;';
	}
?>
editImage =false;
var id = <?php echo $a; ?>;
$('#img').on('change', function(event) {
    input=event.currentTarget;
    editImage = true;
	if (input.files && input.files[0]) {
        var reader = new FileReader();
		reader.onload = function(e) {
			$('#image').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
		}
    });
$('button').on('click',function(){
	event.preventDefault();
	title = $('#title').html();
	text = $('.text_tournament').html();
	name = $('#name').html();
	locat = $('#location').html();
	formate = $('#formate').html();
	summ = $('#summ').html();
	date = $('#date').val();
	data = new FormData();
  if(editImage){
    data.append('image',document.querySelector('#img').files[0]);
  }
	data.append('id',id);
	data.append('editIMG',editImage);
	data.append('title',title);
	data.append('date',date);
	data.append('text_event',text);
	data.append('name',name);
	data.append('location',locat);
	data.append('formate',formate);
	data.append('summ',summ);
	$.ajax({
		url:'ajax.php',
		type:'POST',
		data:data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		success: data => {
                    
                }

	});
	//window.location.reload();
});
</script>
</body>
</html>