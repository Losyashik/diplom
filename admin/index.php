<?php
    function rmRec($path) {
        if (is_file($path)) return unlink($path);
        if (is_dir($path)) {
        foreach(scandir($path) as $p) if (($p!='.') && ($p!='..'))
            rmRec($path.DIRECTORY_SEPARATOR.$p);
        return rmdir($path); 
        }
        return false;
    }
    $link = mysqli_connect('localhost','root','','dota2news');
    if(isset($_GET['id_news'])){
        $query = 'delete from news where id = '.$_GET['id_news'];
        mysqli_query($link,$query) or die(mysqli_error($link));
        rmRec('../assets/img/news/NewsId'.$_GET['id_news']);
        header('Location:index.php');
    }
    if(isset($_GET['id_trans'])){
        $id = $_GET['id_trans'];
        $res = $link->query("SELECT gamer_img FROM trans WHERE id = $id");
        $res = $res->fetch_assoc();
        $res = '../'.$res['gamer_img'];
        unlink($res);
        $link->query("DELETE FROM trans WHERE id = $id");
        header('Location:index.php');
    }
    if(isset($_GET['event_id'])){
        $id = $_GET['event_id'];
        $res = $link->query("SELECT img FROM events WHERE id = $id");
        $res = $res->fetch_assoc();
        $res = '../'.$res['img'];
        unlink($res);
        $link->query("DELETE FROM events WHERE id = $id");
        header('Location:index.php');
    }
    if(isset($_POST['add_transfer'])){
        $mid = $link->query('SELECT MAX(id) as mid FROM trans');
        $mid = $mid->fetch_assoc();
        $mid = $mid['mid'];
        $mid+=1;

        $img = $_FILES['image'];
        $prew = $_POST['prew'];
        $curr = $_POST['curr'];
        $date = $_POST['date'];

        $name_image = $img['name'];
        $type = stripos($name_image, '.', mb_strlen($img['name']) - 5);
        $type = substr($img['name'], $type, mb_strlen($img['name']));
        $dir = "../assets/img/transfers/$mid$type";
        if(move_uploaded_file($img['tmp_name'], $dir))
        {
            $link->query("INSERT INTO `trans`(`id`, `gamer_img`, `previous_command`, `current_command`, `data`) VALUES ($mid,'assets/img/transfers/$mid$type','$prew','$curr','$date' )") or die ($link->error);
            header('Location:index.php');
        }
        else
           { echo('error upload file');}
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Панель администратора</title>
    <script type="text/javascript" src="../assets/js/jquery-3.5.1.js"></script>
</head>
<style type="text/css">
    .edite_blank{
        display: inline-block;
        margin-left: 2%;
        width: 13%;
        padding: 2px 0;
        border: 2px solid;
        color: #000;
        text-decoration: none;
    }
    table{
        border-collapse: collapse;
    }
    td,tr{
        border: 2px solid;
    }
    td{
        padding: 2px;
    }
    .table_news{
        max-width: 60%;
        float: left;
    }
    .transfer_edit{
        text-align: center;
        overflow: auto;
        width: 37%;
        float: left;
        margin:1%;
        border:2px solid;
        height: 50vh;
    }
    .table-wrap{
        width: 100%;
    }
    .table-wrap table{
        width: 100%;
    }
    .select_image{
        height: 100px;
        overflow: hidden;
        margin:2%

    }
    .select_image img{
        width:100px;
        height: 100px;
        display: block;
        margin:0 auto;

    }
    .select_image label{
        width: 100px;
        height: 100px;
        margin:0 auto;
        position: relative;
        bottom: 100px;
        display: none;
        
    }
    .select_image label div{
        width: 100%;
        height: 100%;
        opacity: 1;
        color: #fff;
        justify-content: center;
        display: flex;
        background-color: rgba(0, 0, 0, .6);
    }
    .select_image img:hover +  label{
        display: block;
    }
    .select_image label:hover{
        display: block;
    }
    .events_edit{
        width: 37%;
        margin: 0 2%;
        float: right;
    }
    .events_edit table{
        width: 100%;
    }
</style>
<body>
    <a class="edite_blank" href="rating_edit.php" target='_blank'>Изменение рейтинга</a>
    <a class="edite_blank" href="news_edit.php" target='_blank'>Создание новостей</a>
    <a class="edite_blank" href="edit_events.php" target='_blank'>Создание мероприятий</a>
    <table class="table_news">
        <caption align="center">Список новостей</caption>
        <tr>
                <th>№</th>
                <th>title</th>
                <th>date</th>
                <th>edit</th>
                <th>delete</th>
            </tr>
        <tbody >
            <?php
                $query = "select * from news order by datatime ASC";
                $res = mysqli_query($link, $query) or die(mysqli_error($link));
                for($data=[];$row=mysqli_fetch_assoc($res);$data[]=$row);
                $res = '';
                $i = 0;
                foreach ($data as $elem){
                    $i++;
                    $res .= "<tr>";
                        $res .= "<td>$i</td>";
                        $res .= "<td>".$elem['title']."</td>";
                        $res .= "<td>".$elem['datatime']."</td>";
                        $res .= "<td><a href='news_edit.php?id=".$elem['id']."' target='_blank'>Изменить</a></td>";
                        $res .= "<td><a href='index.php?id_news=".$elem['id']."'>Удалить</a></td>";
                    $res .= "<tr>";
                }
                echo $res;
            ?>
        </tbody>
    </table>
    <div class="transfer_edit">
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="image" style="display: none;" id='inpImg' accept="image/jpeg,image/png,image/gif">
            <div class = "select_image">
                <img src="" id='image'>
                <label for='inpImg'>
                    <div><span style="padding-top:30%">Выберете изображение</span></div>
                </label>
            </div>
            <input type="text" name="prew" placeholder="предидущаяя">&#9654;
            <input type="text" name="curr" placeholder="настоящая"><br>
            Дата перехода:<input type="date" name="date">
            <input type="submit" name = "add_transfer" value="add_transfer">
        </form>
        <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Игрок</th>
                  <th>Трансфер</th>
                  <th>Дата</th>
                  <th>Удалить</th>
                </tr>
              </thead>
              <tbody>
              <?php
                  $query = "SELECT * FROM trans";
                  $res = mysqli_query($link, $query);
                  for ($data = [];$row = mysqli_fetch_assoc($res); $data[]=$row);
                  $res='';
                  foreach ($data as $elem){
                      $res .= '<tr>';
                          $res .= '<td data-label=""><img src="../'.$elem['gamer_img'].'" style="object-fit: cover; object-position: center;" width="60px" height="60px" alt=""></td>';
                          $res .= '<td data-label="">'.$elem['previous_command'].'<br> &#9660; <br>'.$elem['current_command'].'</td>';
                          $elem['data'] = date('d.m.Y',strtotime($elem['data']));
                          $res .= '<td data-label="">'.$elem['data'].'</td>';
                          $res .= '<td data-label=""><a href="?id_trans='.$elem['id'].'">Удалить</a></td>';
                      $res .= '</tr>';
                  }
                  echo $res;
              ?>
              </tbody>
            </table>
    </div>
    </div>
    <div class="events_edit">
        <table>
            <tr>
                <th>№</th>
                <th>title</th>
                <th>date</th>
                <th>edit</th>
                <th>delete</th>
            </tr>
            <?php
                $res = $link->query('SELECT * FROM events');
                for($data=[];$row = $res->fetch_assoc(); $data[]=$row);
                $res = '';
                foreach($data as $elem){
                    $res.="<tr>";
                        $res.="<td>".$elem['id']."</td>";
                        $res.="<td>".$elem['title']."</td>";
                        $res.="<td>".$elem['date']."</td>";
                        $res.="<td><a target='_blank' href='edit_events.php?id=".$elem['id']."'>Изменить</a></td>";
                        $res.="<td><a href='?event_id=".$elem['id']."'>Удалить</a></td>";
                    $res.="</tr>";

                }
                echo $res;
            ?>
        </table>
    </div>
    <script>
        $('#inpImg').on('change', function(event) {
        input=event.currentTarget;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            }
		
    });
    </script>
</body>
</html>