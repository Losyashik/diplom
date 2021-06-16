<?php
$link = mysqli_connect('localhost', 'root', '', 'dota2news');
if (isset($_POST['add_rating'])) {
	$name = $_POST['name'];
	$max_id = array();
	$query = 'SELECT max(id) FROM command';
	$result = mysqli_query($link, $query);
	for (; $row = mysqli_fetch_assoc($result); $max_id[] = $row);
	foreach ($max_id as $arr) {
		$max_id = $arr['max(id)'];
	}
	$max_id += 1;
	$type_img = $_FILES['logo']['type'];
	$type_img = substr($type_img, 6, 5);
	$src_logo = "assets/img/" . $name . "." . $type_img;
	move_uploaded_file($_FILES['logo']['tmp_name'], "../" . $src_logo);
	$query = 'INSERT INTO `command`(`id`, `name`, `flag_img`, `logo_img`, `rating`, `wins`, `last_game`) VALUES (' . $max_id . ',"' . $name . '",' . $_POST['flag'] . ',"' . $src_logo . '",' . $_POST['rating'] . ',' . $_POST['wins'] . ',' . $_POST['last_game'] . ')';
	mysqli_query($link, $query) or die(mysqli_error($link));
	header('Location:rating_edit.php');
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<link rel="stylesheet" type="text/css" href="../assets/css/Rating1.css">
	<script type="text/javascript" src="../assets/js/jquery-3.5.1.js"></script>
	<title></title>
	<style>
		.table {
			width: 80%;
			margin: 0 auto;
		}

		input,
		select {
			display: inline-block;
			width: 80%;
			margin: 4px auto;
		}
		.name{
			font-size: 20px;
    		position: relative;
    		margin: -50px 0px 0px 160px;
		}
		.wins{
			position: relative;
    		margin: 39px 0px 40px -20px;
		}
		input::placeholder {
			color: #888;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="table">
		<div class="table-header">
			<div class="header__item"><a id="name" class="filter__link" href="#">Место</a></div>
			<div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">Команда</a></div>
			<div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">Рейтинг</a></div>
			<div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">Доля побед</a></div>
			<div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">Последняя игра</a></div>
		</div>
		<div class="table-row">
			<div class="table-data">
				<form id="add_rating" method="POST" enctype="multipart/form-data"></form>
			</div>
			<div class="table-data">
				<select form="add_rating" name="flag">
					<option>выберете страну</option>
					<?php
					$query = 'SELECT * FROM `country`';
					$result = mysqli_query($link, $query) or die(mysqli_error($link));
					for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
					$result = '';
					foreach ($data as $elem) {
						$result .= '<option value=' . $elem['id'] . '>' . $elem['country'] . '</option>';
					}
					echo $result;
					?>
				</select>
				<input name="logo" form="add_rating" type="file">
				<input form="add_rating" name="name" placeholder="Название команды" type="text">
			</div>
			<div class="table-data">
				<input form="add_rating" placeholder="Рейтинг" name="rating" type="number">
			</div>
			<div class="table-data">
				<input form="add_rating" name="wins" placeholder="% побед" type="number" min="0" max=100>
			</div>
			<div class="table-data">
				<input form="add_rating" name="last_game" placeholder="победа или поражение(1 или 0)" type="number" max="1" min="0">
			</div>
		</div>
		<?php
		$query = 'SELECT *,command.id as cid,country.src as flag_img FROM `command`,`country` WHERE `country`.`id`=command.flag_img order by `rating` DESC';
		$result = mysqli_query($link, $query)or die(mysqli_error($link));
		for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
		$result = '';
		$i = 0;
		foreach ($data as $elem) {
			$i++;

			$result .= '<div class="table-row">';
			if ($i <= 3) {
				$result .= '<div class="table-data">';
				$result .= '<div class="place1"><img src="../assets/img/top' . $i . '.png"></div>';
				$result .= '</div>';
			} else {
				$result .= '<div class="table-data">';
				$result .= '<div class="place1"><span class="span1">' . $i . '</span></div>';
				$result .= '</div>';
			}
			$result .= '<div class="table-data">';
			$result .= '<div class="flag"><img src="../' . $elem['flag_img'] . '" width="30px" height="30px"></div>'; //флаг команды
			$result .= '<div class="logokomand"><img src="../' . $elem['logo_img'] . '" width="50px" height="60px"></div>'; //логотип команды
			$result .= '<div class="name" name="'.$elem['cid'].'">' . $elem['name'] . '</div>'; //название команды
			$result .= '</div>';
			$result .= '<div class="table-data">';
			$result .= '<div class="rating" name="'.$elem['cid'].'">' . $elem['rating'] . '</div>'; //рейтинг команды
			$result .= '</div>';
			$result .= '<div class="table-data">';
			$result .= '<div class="wins"name="'.$elem['cid'].'">' . $elem['wins'] . '%</div>'; //Доля побед команды
			$result .= '</div>';
			$result .= '<div class="table-data">';
			if ($elem['last_game']) {
				$result .= '<div class="last_game">Win</div>'; //Последняя игра команды
			} else {
				$result .= '<div class="last_game">---</div>'; //Последняя игра команды
			}

			$result .= '</div>';
			$result .= '</div>';
			$result .= '<hr>';
		}
		echo $result;
		?>





		</table>
		<input style="position:absolute; width:120px; top:34px; right:5px;" form="add_rating" type="submit" name="add_rating" value="add command">

	</div>
	<script>
		$('.rating, .name, .wins').on('dblclick', function(){
			$(this).attr('contenteditable',"true");
		});
		$('.rating, .name, .wins').on('keydown', function(e){
			if(e.keyCode == '13'){
				e.preventDefault();
				text = $(this).html()
				id = $(this).attr('name')
				name = $(this).attr('class')
				$.ajax({
					url:'ajax.php',
					type:'get',
					data: {
						text:text,
						id:id,
						name:name
					},
					success: function(){
						alert('compeat');
					}
				})
				$(this).removeAttr('contenteditable');
			}
		});
	</script>
</body>

</html>