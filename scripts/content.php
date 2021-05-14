<?php
$link = mysqli_connect('localhost','root','','isup');
session_start();
if(isset($_POST['user'])){
    $user =$_POST['user'];
}
else{
    $user = $_SESSION['user'];
}
function translit($str) {
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
}
function reversTranslit($str) {
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($lat, $rus, $str);
}
$discipline = array();
$groups = array();
$result = $link->query('SELECT * FROM groups WHERE id in (SELECT group_id FROM gdp WHERE teacher_id = '.$user['id'].')');
for($data=[];$row = mysqli_fetch_assoc($result);$data[]=$row);
foreach($data as $elem){
    $groups[]="./".translit($elem['name']);
}
$result = $link->query('SELECT * FROM discipline WHERE id in (SELECT DISTINCT discipline_id FROM gdp WHERE teacher_id = '.$user['id'].')');
for($data=[];$row = mysqli_fetch_assoc($result);$data[]=$row);
foreach($data as $elem){
    $discipline[]=translit($elem['name']);
}
if(isset($_POST["page"]))
    $page = $_POST["page"];
    switch ($page) {
        case "./group_list":
            echo"
            <nav class='sort'>
                <div class='sort_interface'>
                    <div class='select_block'>
                        
                        <div class='select' data-name='specialty'><span>Все специальности</span></div>
                        <div class='select_list'>
                            <div class='select_item selected' data-value='0'><span>Все специальности</span></div>
                            ";
                            $result = $link->query('SELECT * FROM specialty');
                            for($data = []; $row = mysqli_fetch_assoc($result);$data[]=$row);
                            $result='';
                            foreach($data as $elem){
                                $result.="<div class='select_item' data-value='".$elem['id']."'><span>".$elem['name']."</span></div>";
                            }

                        echo $result."
                        </div>
                        <input type='hidden' id='specialty' value = '0'>
                    </div>
                    <div class='select_block'>
                        <input type='hidden' id = 'course' value = '0'>
                        <div class='select' data-name='course'><span>Все курсы</span></div>
                        <div class='select_list hidden'>
                            <div class='select_item selected' data-value='0'><span>Все курсы</span></div>
                            ";
                            $result = $link->query('SELECT * FROM course');
                            for($data = []; $row = mysqli_fetch_assoc($result);$data[]=$row);
                            $result='';
                            foreach($data as $elem){
                                $result.="<div class='select_item' data-value='".$elem['id']."'><span>".$elem['number']."</span></div>";
                            }

                        echo $result."
                        </div>
                    </div>
                </div>
                <div class='sort_interface' id='search'>
                    <input type='search' name='group' id='search_group'>
                    <button class = 'search_button'>Поиск</button>
                </div>
            </nav>
            ";
            $result = $link->query("SELECT id, `name` FROM `groups` WHERE id in (SELECT group_id FROM gdp WHERE teacher_id=".$user['id'].")");
            for($data=[];$row = mysqli_fetch_assoc($result);$data[]=$row);
            $result="<div id='groups_list' class='list'>";
            foreach($data as $elem){
                $result.="<a href='./".translit($elem['name'])."' title='".$elem['name']."' class='list_item group_name'>".$elem['name']."</a>";
            }
            echo $result.="</div>";
        break;

        case "./reports":
            echo "
                <div class='list'>
                    <a href=''class='list_item report_name' >report name</a>
                    <a href=''class='list_item report_name'>report name</a>
                </div>
            ";
        break;

        case "./curator_page":
            echo "
                <div class='list'>
                    <a href=''class='list_item curator_report_name' >Отчет по посещаемости группы за месяц</a>
                    <a href=''class='list_item curator_report_name'>Сипсок отсутствующих за день</a>
                    <a href=''class='list_item curator_report_name'>Добавление справок/записок</a>
                    <a href=''class='list_item curator_report_name'>Список группы</a>
                </div>
            ";
        break;
        case $_POST['page'] and in_array($_POST['page'],$groups):
            $result = $link->query('SELECT * FROM discipline WHERE id in (SELECT discipline_id FROM gdp WHERE teacher_id = '.$user['id'].' AND group_id in (SELECT id FROM groups WHERE name = "'.substr(reversTranslit($_POST['page']),2).'"))') or die (mysqli_error($link));
            for($data=[];$row = mysqli_fetch_assoc($result);$data[]=$row);
            $result="<div id='discipline_list' class='list'>";
            foreach($data as $elem){
                $result.="<a href='".$_POST['page']."_".translit($elem['name'])."' title='".$elem['name']." ".substr(reversTranslit($_POST['page']),2)."' class='list_item discipline_name'>".$elem['name']."</a>";
            }
            echo $result."
            </div>
            ";
        break;
        case $_POST['page'] and (in_array(explode('_',$_POST['page'])[0],$groups) and in_array(urldecode(explode('_',$_POST['page'])[1]),$discipline)):
            $group_name = reversTranslit(substr(explode('_',$_POST['page'])[0],2));
            $discipline_name = reversTranslit(urldecode(explode('_',$_POST['page'])[1]));
            $discipline_id = mysqli_fetch_assoc($link->query("SELECT id FROM discipline WHERE name = '$discipline_name'"))['id'];  
            $group_id = mysqli_fetch_assoc($link->query("SELECT id FROM groups WHERE name = '$group_name'"))['id'];  
            $gdp = mysqli_fetch_assoc($link->query("SELECT id FROM gdp WHERE group_id = $group_id and discipline_id = $discipline_id"))['id'];
            echo"
                <nav class='sort'>
                    <div class='sort_interface'>
                        <input class='add_lecture' id='date_lecture' max='".date('Y-m-d')."' type='date' >
                        <input placeholder='введите № пары' id='pair_number' class='add_lecture' type='text'>
                    </div>
                    <div class='sort_interface' id='add_lecture'><button id='button_add_lecture'>Сохранить</button></div>
                </nav>
                <div class='list' id='name_list'>
                ";
                $result = $link->query("SELECT * FROM students WHERE group_id = (SELECT id FROM groups WHERE name = '$group_name')");
                for($data = []; $row = mysqli_fetch_assoc($result);$data[] = $row);
                $result='';
                foreach($data as  $elem){
                    $result.="<div class='list_item student_name' data-value='".$elem['id']."'>".$elem['surname'].' '.$elem['name']."</div>";
                }
                echo $result.="
                </div>
                
                <script>
                var disciplineId = ".$discipline_id.";
                var lectureId = 0;
                var gdp = ".$gdp.";
                </script>
                ";
        break;
        case "./admin": 
            echo "<p>admin</p>";
        break;
        default:
        echo "Error 404";
    }   
?>