<?php
$link = mysqli_connect('localhost', 'root', '', 'isup');
session_start();
if (isset($_POST['user'])) {
    $user = $_POST['user'];
} else {
    $user = $_SESSION['user'];
    if (isset($_SESSION['user']))
        if (time() - $_SESSION['user']['last_time'] <= 1200) {
            $_SESSION['user']['last_time'] = time();
            $user = $_SESSION['user'];
        } else {
            unset($_SESSION['user']);
            header('Location:/');
        }
    else {
        openLoginWindow();
    }
}
$result = $link->query("SELECT name FROM groups WHERE curator_id = ".$user['id']);
if(mysqli_num_rows($result)>0){
    $supervised_group = mysqli_fetch_assoc($result)['name'];
}
include_once "modules/arrays.php";
$page = $_POST["page"];
switch ($page) {
    case "./group_list":
        echo "
            <nav class='sort'>
                <div class='sort_interface'>
                    <div class='select_block'>
                        
                        <div class='select' data-name='specialty'><span>Все специальности</span></div>
                        <div class='select_list'>
                            <div class='select_item selected' data-value='0'><span>Все специальности</span></div>
                            ";
        $result = $link->query('SELECT * FROM specialty');
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        $result = '';
        foreach ($data as $elem) {
            $result .= "<div class='select_item' data-value='" . $elem['id'] . "'><span>" . $elem['name'] . "</span></div>";
        }

        echo $result . "
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
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        $result = '';
        foreach ($data as $elem) {
            $result .= "<div class='select_item' data-value='" . $elem['id'] . "'><span>" . $elem['number'] . "</span></div>";
        }

        echo $result . "
                        </div>
                    </div>
                </div>
                <div class='sort_interface' id='search'>
                    <input type='search' placeholder='Поиск по названию группы' name='group' id='search_group'>
                </div>
            </nav>
            <div id='groups_list' class='list conteiner_list'></div>
            <script>
                data = {group_list:true};
                url = 'scripts/sort_group_content.php'
                sortContent(data,url)
            </script>";
        break;

    case "./reports":
        echo "
            <nav class='sort'>
                <div class='sort_interface'>
                    <div class='select_block'>
                        <div class='select' data-name='specialty'><span>Все специальности</span></div>
                        <div class='select_list'>
                            <div class='select_item selected' data-value='0'><span>Все специальности</span></div>
                            ";
                            $result = $link->query('SELECT * FROM specialty');
                            for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
                            $result = '';
                            foreach ($data as $elem) {
                                $result .= "<div class='select_item' data-value='" . $elem['id'] . "'><span>" . $elem['name'] . "</span></div>";
                            }

                            echo $result . "
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
                            for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
                            $result = '';
                            foreach ($data as $elem) {
                                $result .= "<div class='select_item' data-value='" . $elem['id'] . "'><span>" . $elem['number'] . "</span></div>";
                            }

                            echo $result . "
                        </div>
                    </div>
                </div>
                <div class='sort_interface' id='search'>
                    <input type='search' name='group' placeholder='Поиск по названию группы' id='search_group'>
                </div>
            </nav>
            <div class='list conteiner_list' id='reports'></div>
            <script>
                data = {reports:true};
                url = 'scripts/sort_group_content.php'
                sortContent(data,url)
            </script>
        ";
        break;
    
    case "./admin":
        echo "
            <div class='list'>
                <div class='list_item admin_list'>
                    Специальности
                    <button class='open_modal_window add_button' data-modal-id='add_specialty'>Добавить</button>
                    <div class='list'>
                    ";
                    $result = $link->query("SELECT * FROM specialty");
                    for($data=[];$row = $result->fetch_assoc();$data[]=$row);
                    $result='';
                    foreach($data as $elem){
                        $result.="
                        <table>
                            <tr>
                                <td>".$elem['name']."</td>
                                <td><span class='delete_admin' data-name-list = 'delete_specialty' data-delete-id='".$elem['id']."'>Удалить</span></td>
                            </tr>
                        </table>
                        ";
                    }
                    echo $result;
                    echo "
                    </div>
                </div>
                <div class='list_item admin_list'>
                    Преподаватели
                    <button class='open_modal_window add_button' data-modal-id='add_teacher'>Добавить</button>
                    <div class='list'>
                    ";
                    $result = $link->query("SELECT * FROM teacher");
                    for($data=[];$row = $result->fetch_assoc();$data[]=$row);
                    $result='';
                    foreach($data as $elem){
                        $result.="
                        <table>
                            <tr>
                                <td>".$elem['surname']." ".$elem['name']." ".$elem['patronymic']."</td>
                                <td><span class='delete_admin' data-name-list = 'delete_teacher' data-delete-id='".$elem['id']."'>Удалить</span></td>
                            </tr>
                        </table>
                        ";
                    }
                    echo $result;
                    echo "
                    </div>
                </div>
                <div class='list_item admin_list'>
                    Дисциплины
                    <button class='open_modal_window add_button' data-modal-id='add_discipline'>Добавить</button>
                    <div class='list'>
                    ";
                    $result = $link->query("SELECT * FROM discipline");
                    for($data=[];$row = $result->fetch_assoc();$data[]=$row);
                    $result='';
                    foreach($data as $elem){
                        $result.="
                        <table>
                            <tr>
                                <td>".$elem['name']."</td>
                                <td><span class='delete_admin' data-name-list = 'delete_discipline' data-delete-id='".$elem['id']."'>Удалить</span></td>
                            </tr>
                        </table>
                        ";
                    }
                    echo $result;
                    echo "
                    </div>
                </div>
                <div class='list_item admin_list'>
                    Связь дисциплина-группа-преподаватель
                    <button class='open_modal_window add_button' data-modal-id='add_gdp'>Добавить</button>
                    <div class='list'>
                    ";
                    $result = $link->query("SELECT * FROM gdp");
                    for($data=[];$row = $result->fetch_assoc();$data[]=$row);
                    $result='';
                    foreach($data as $elem){
                        $result.="
                        <table>
                            <tr>
                                <td>".$link->query("SELECT name FROM discipline WHERE id =".$elem['discipline_id'])->fetch_assoc()['name']."</td>
                                <td>".$link->query("SELECT surname FROM teacher WHERE id =".$elem['teacher_id'])->fetch_assoc()['surname']."</td>
                                <td>".$link->query("SELECT name FROM groups WHERE id =".$elem['group_id'])->fetch_assoc()['name']."</td>
                                <td><span class='delete_admin' data-name-list = 'delete_gdp' data-delete-id='".$elem['id']."'>Удалить</span></td>
                            </tr>
                        </table>
                        ";
                    }
                    echo $result;
                    echo "
                    </div>
                </div>
                <div class='list_item admin_list'>
                    Группы
                    <div class='list'>
                    ";
                    $result = $link->query("SELECT * FROM groups");
                    for($data=[];$row = $result->fetch_assoc();$data[]=$row);
                    $result='';
                    foreach($data as $elem){
                        $result.="
                        <table>
                            <tr>
                                <td>".$elem['name']."</td>
                                <td><span class='delete_admin' data-name-list = 'delete_group' data-delete-id='".$elem['id']."'>Удалить</span></td>
                            </tr>
                        </table>
                        ";
                    }
                    echo $result;
                    echo "
                    </div>
                </div>
            </div>
            <div class='modal_window' id='add_teacher' >
                <div class='hidden_block' data-modal-id='add_teacher'></div>
                <form class = 'add_teacher' style = 'top:5%'>
                    <h2>Добавление преподователя</h2>
                    <input type='text' name='surname' placeholder='Фамилия'>
                    <input type='text' name='name' placeholder='Имя'>
                    <input type='text' name='patronymic' placeholder='Отчество'>
                    <input type='text' name='login' placeholder='логин'>
                    <input type='password' name='password' placeholder='Пароль'>
                    <input type='password' name='dbl_password' placeholder='Повторите пароль'>
                    <label><input type='radio' value='1' name='role'>Администратор</label><label><input checked value='2' type='radio' name='role'>Преподаватель</label>
                    <div class='error'></div>
                    <input type='submit' value='Добавить' class='submit' onclick='event.preventDefault();' name='teacher'>
                </form>
            </div>
            <div class='modal_window' id='add_specialty'>
                <div class='hidden_block' data-modal-id='add_specialty'></div>
                <form method='POST' class = 'add_speciality' style='top:30%'>
                    <h2>Добавление специальности</h2>
                    <input type='text' name='title' placeholder='Название'>
                    <input type='text' name='code' placeholder='Код'>
                    <div class='error'></div>
                    <input type='submit' class='submit' onclick='event.preventDefault();' name='specialty' value='Добавить'>
                </form>
            </div>
            <div class='modal_window' id='add_discipline'>
                <div class='hidden_block' data-modal-id='add_discipline'></div>
                <form class = 'add_discipline' style='top:30%;'>
                    <h2>Добавление дисциплины</h2>
                    <input type='text' name='title' placeholder='Название'>
                    <div class='error'></div>
                    <input type='submit' class='submit' onclick='event.preventDefault();' value='Добавить' name='discipline'>
                </form>
            </div>
            <div class='modal_window' id='add_gdp'>
                <div class='hidden_block' data-modal-id='add_gdp'></div>
                <form class = 'add_gdp' style='top:20%'>
                    <h2>Связь дисциплина-группа-преподаватель</h2>
                    <input class='select' id='group' type='hidden' name='group'>
                    <div class='select_block'>
                        <div class='select' data-name='group'><span>Выберете группу</span></div>
                        <div class='select_list'>
                            <div class='select_item selected' data-value='0'><span>Выберете группу</span></div>
                            ";
                            $result = $link->query("SELECT * FROM groups");
                            for($data=[];$row = $result->fetch_assoc();$data[]=$row);
                            $result='';
                            foreach($data as $elem){
                                $result.="<div class='select_item' data-value='".$elem['id']."'><span>".$elem['name']."</span></div>";
                            }
                            echo $result."
                        </div>
                    </div>
                    <input class='select' id='discipline' type='hidden' name='discipline'>
                    <div class='select_block'>
                        <div class='select' data-name='discipline'><span>Выберете дисциплину</span></div>
                        <div class='select_list'>
                            <div class='select_item selected' data-value='0'><span>Выберете дисциплину</span></div>
                            ";
                            $result = $link->query("SELECT * FROM discipline");
                            for($data=[];$row = $result->fetch_assoc();$data[]=$row);
                            $result='';
                            foreach($data as $elem){
                                $result.="<div class='select_item' data-value='".$elem['id']."'><span>".$elem['name']."</span></div>";
                            }
                            echo $result."
                        </div>
                    </div>
                    <input class='select' id='teacher' type='hidden' name='teacher'>
                    <div class='select_block'>
                        <div class='select' data-name='teacher'><span>Выберете преподавателя</span></div>
                        <div class='select_list'>
                            <div class='select_item selected' data-value='0'><span>Выберете преподавателя</span></div>
                            ";
                            $result = $link->query("SELECT * FROM teacher");
                            for($data=[];$row = $result->fetch_assoc();$data[]=$row);
                            $result='';
                            foreach($data as $elem){
                                $result.="<div class='select_item' data-value='".$elem['id']."'><span>".$elem['surname']."</span></div>";
                            }
                            echo $result;
                            echo"
                        </div>
                    </div>
                    <div class='error'></div>
                    <input type='submit' class='submit' onclick='event.preventDefault();' value='Добавить' name='gdp'>
                </form>
            </div>
            <form class = 'add_group'>
                <div class='data group_data'>
                    <h2>Добавление группы</h2>
                    <input class='select' id='specialty' type='hidden' name='specialty'>
                    <div class='select_block'>
                        <div class='select' data-name='specialty'><span>Выберете специальность</span></div>
                        <div class='select_list'>
                            <div class='select_item selected' data-value='0'><span>Выберете специальность</span></div>
                            ";
                            $result = $link->query("SELECT * FROM specialty");
                            for($data=[];$row = $result->fetch_assoc();$data[]=$row);
                            $result='';
                            foreach($data as $elem){
                                $result.="<div class='select_item' data-value='".$elem['id']."'><span>".$elem['name']."</span></div>";
                            }
                            echo $result;
                            echo "
                        </div>
                    </div>
                    <input class='select' id='curator' type='hidden' name='teacher'>
                    <div class='select_block'>
                        <div class='select' data-name='curator'><span>Выберете куратора</span></div>
                        <div class='select_list'>
                            <div class='select_item selected' data-value='0'><span>Выберете куратора</span></div>
                            ";
                            $result = $link->query("SELECT * FROM teacher");
                            for($data=[];$row = $result->fetch_assoc();$data[]=$row);
                            $result='';
                            foreach($data as $elem){
                                $result.="<div class='select_item' data-value='".$elem['id']."'><span>".$elem['surname']."</span></div>";
                            }
                            echo $result;
                            echo "
                        </div>
                    </div>
                    <input type='text' name='title' placeholder='Название'>
                    <input type='text' name='course' placeholder='Курс'>
                    <input type='text' id='kol' placeholder='Количество студентов'>
                </div>
                <div class='data students_data'>
                <h2>Добавление студентов</h2>
                    <div class='stud_inp'></div>
                </div>
                <div class='error'></div>
                <input type='submit' class='submit' onclick='event.preventDefault();' value='Добавить' name='group'>
            </form>
            <script src='scripts/scripts_for_admin/edit.js'></script>
        ";
    break;
//Вывод списка дисциплин для выбора
    case $page and in_array(substr($page, 2), array_keys($groups)):
        $result = $link->query('SELECT * FROM discipline WHERE id in (SELECT discipline_id FROM gdp WHERE teacher_id = ' . $user['id'] . ' AND group_id in (SELECT id FROM groups WHERE name = "' . $groups[substr($page, 2)] . '"))') or die(mysqli_error($link));
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        $result = "<div id='discipline_list' class='list'>";
        foreach ($data as $elem) {
            $result .= "<a href='" . $page . "_" . translit($elem['name']) . "' title='" . $elem['name'] . " " . $groups[substr($page, 2)] . "' class='list_item discipline_name'>" . $elem['name'] . "</a>";
        }
        echo $result . "
            </div>
            ";
        break;
//Вывод списка для выбора присутствующих
    case $page and (in_array(explode('_', substr($page, 2))[0], array_keys($groups)) and in_array(urldecode(explode('_', $page)[1]), array_keys($discipline))):
        $group_name = $groups[substr(explode('_', $page)[0], 2)];
        $discipline_name = $discipline[urldecode(explode('_', $page)[1])];
        $discipline_id = mysqli_fetch_assoc($link->query("SELECT id FROM discipline WHERE name = '$discipline_name'"))['id'];
        $group_id = mysqli_fetch_assoc($link->query("SELECT id FROM groups WHERE name = '$group_name'"))['id'];
        $gdp = mysqli_fetch_assoc($link->query("SELECT id FROM gdp WHERE group_id = $group_id and discipline_id = $discipline_id"))['id'];
        echo "
                <nav class='sort'>
                    <div class='sort_interface'>
                        <input class='add_lecture' id='date_lecture' max='" . date('Y-m-d') . "' type='date' >
                        <input placeholder='введите № пары' id='pair_number' class='add_lecture' type='text'>
                    </div>
                    <div class='sort_interface' id='add_lecture'><button id='button_add_lecture'>Сохранить</button></div>
                </nav>
                <div class='list' id='name_list'>
                ";
        $result = $link->query("SELECT * FROM students WHERE group_id = (SELECT id FROM groups WHERE name = '$group_name')");
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        $result = '';
        foreach ($data as  $elem) {
            $result .= "<div class='list_item student_name' data-value='" . $elem['id'] . "'>" . $elem['surname'] . ' ' . $elem['name'] . "</div>";
        }
        echo $result .= "
                </div>
                
                <script>
                var disciplineId = " . $discipline_id . ";
                var lectureId = 0;
                var gdp = " . $gdp . ";
                </script>
                ";
        break;
//вывод страницы отчета за месяц по предмету
    case $page and explode('_', substr(urldecode($page), 2))[0] == "mounth" and in_array(explode('_', substr(urldecode($page), 2))[2], array_keys($groups)) and in_array(explode('_', substr(urldecode($page), 2))[3], array_keys($discipline)):
        $group_name = $groups[explode('_', substr(urldecode($page), 2))[2]];
        $discipline_name = $discipline[explode('_', substr(urldecode($page), 2))[3]];
        $gdp = $link->query("SELECT id FROM gdp WHERE discipline_id in(SELECT id FROM discipline WHERE name = '$discipline_name') AND group_id in (SELECT id FROM groups WHERE name = '$group_name') AND teacher_id =".$user['id']);
        $gdp = mysqli_fetch_row($gdp)[0];
        echo "
                <nav class='sort'>
                    <div class='sort_interface'>
                        <div class='select_block'>
                            
                            <div class='select' data-name='mounth'><span>" . $mounth[date('m')] . "</span></div>
                            <div class='select_list'>
                                ";
        $result = '';
        foreach ($mounth as $key => $elem) {
            if ($key == date('m'))
            {
                $result .= "<div class='select_item selected' data-value='$key'><span>$elem</span></div>";
                $now_mounth = $elem; 
            }
            else
                $result .= "<div class='select_item' data-value='$key'><span>$elem</span></div>";
        }

        echo $result . "
                            </div>
                            <input type='hidden' id='mounth' value = '0'>
                        </div>
                        <div class='select_block'>
                            <div class='select' data-name='year'><span>" . date('Y') . "</span></div>
                            <div class='select_list'>
                                <div class='select_item' data-value='" . date('Y', strtotime("last Year")) . "'><span>" . date('Y', strtotime("last Year")) . "</span></div>
                                <div class='select_item selected' data-value='" . date('Y') . "'><span>" . date('Y') . "</span></div>
                                
                            </div>
                            <input type='hidden' id='year' value = '0'>
                        </div>
                    </div>
                    <div class='sort_interface' id='print_block'>
                        <button class='print' onclick='CallPrint(\".request_mounth\")'>Печать</button>
                    </div>
                </nav>
                <div class='conteiner_list request_mounth'></div>
                <script>
                    data = {gdp:'$gdp',group:'$group_name',mounth:'".date('m')."',year:'".date('Y')."'}
                    url = 'scripts/request_content.php';
                    titleIn = {mounth:'$now_mounth',year:".date('Y')."}
                    title = 'Отчет по $discipline_name группы $group_name за '
                    titleDate = titleIn['mounth']+' '+titleIn['year']+' года';
                    sortContent(data,url);
                </script>

                ";
        break;
//Error 404 если не куратор
    case $page and !isset($supervised_group):
        echo "Error 404";
    break;
//Страница куратора
    case "./curator_page":
        echo "
                <div class='list'>
                    <a href='./".translit($supervised_group)."_report_mounth' class='list_item curator_report_name' >Отчет по посещаемости группы $supervised_group за месяц</a>
                    <a href='./".translit($supervised_group)."_report_day' class='list_item curator_report_name'>Сипсок отсутствующих группы $supervised_group за день</a>
                    <a href='./add_reason_for_".translit($supervised_group)."' class='list_item curator_report_name'>Добавление справок/записок для групп $supervised_group</a>
                </div>
            ";
    break;
//Отчет за месяц для куратора
    case  "./".translit($supervised_group)."_report_mounth":
        echo "
                <nav class='sort'>
                    <div class='sort_interface'>
                        <div class='select_block'>
                            
                            <div class='select' data-name='mounth'><span>" . $mounth[date('m')] . "</span></div>
                            <div class='select_list'>
                                ";
        $result = '';
        foreach ($mounth as $key => $elem) {
            if ($key == date('m'))
            {
                $result .= "<div class='select_item selected' data-value='$key'><span>$elem</span></div>";
                $now_mounth = $elem; 
            }
            else
                $result .= "<div class='select_item' data-value='$key'><span>$elem</span></div>";
        }

        echo $result . "
                            </div>
                            <input type='hidden' id='mounth' value = '0'>
                        </div>
                        <div class='select_block'>
                            <div class='select' data-name='year'><span>" . date('Y') . "</span></div>
                            <div class='select_list'>
                                <div class='select_item' data-value='" . date('Y', strtotime("last Year")) . "'><span>" . date('Y', strtotime("last Year")) . "</span></div>
                                <div class='select_item selected' data-value='" . date('Y') . "'><span>" . date('Y') . "</span></div>
                            </div>
                            <input type='hidden' id='year' value = '0'>
                        </div>
                    </div>
                    <div class='sort_interface' id='print_block'>
                        <button class='print' onclick='CallPrint(\".request_mounth\")'>Печать</button>
                    </div>
                </nav>
                <div class='conteiner_list request_mounth'></div>
                <script>
                    data = {group:'$supervised_group',mounth:'".date('m')."',year:'".date('Y')."'}
                    url = 'scripts/request_content.php';
                    titleIn = {group:true, mounth:'$now_mounth',year:".date('Y')."}
                    title = 'Отчет по посещаемости группы $supervised_group за '
                    titleDate = titleIn['mounth']+' '+titleIn['year']+' года';
                    sortContent(data,url);
                </script>

                ";
    break;
//Отчет за день для куратора
    case "./".translit($supervised_group)."_report_day":
        echo "
                <nav class='sort'>
                    <div class='sort_interface'>
                        <input type='date' value='".date('Y-m-d')."' class='select_day'>  
                    </div>
                    </div>
                    <div class='sort_interface' id='print_block'></div>
                </nav>
                <div class='day_request conteiner_list'></div>
                <script>
                    url='scripts/request_day.php';
                    data = {group:'$supervised_group',date:'".date('Y-m-d')."'}
                    sortContent(data,url)
                </script>
                ";
    break;
//Добавление справок
    case "./add_reason_for_".translit($supervised_group):
        $result = $link->query("SELECT * FROM students WHERE group_id = (SELECT id FROM groups WHERE name='$supervised_group')") or die ($link->error);
        for($arr = [];$row = mysqli_fetch_assoc($result);$arr[]=$row);
        $result='';
        echo"
            <nav class='sort'>
                <div class='sort_interface'>
                    <div class='select_block'>
                        <div class='select' data-name='sId'><span>".$arr[0]['surname']." ".$arr[0]['name']."</span></div>
                        <div class='select_list'>
                        ";
                        foreach($arr as $elem){
                            $result .= "<div class='select_item' data-value='".$elem['id']."'><span>".$elem['surname']." ".$elem['name']."</span></div>";
                        }
                        echo $result;
                        echo"
                        </div>
                    </div>
                    <button id='button_add_reason' class='open_modal_window' data-modal-id='add_reason'>Добавить справку</button>
                </div>
                <div class='sort_interface' id='print_block'>
                </div>
            </nav>
            <div class='list conteiner_list' id='reason_list'></div>
            <script>
                data = {sId:1}
                url = 'scripts/reason_content.php';
                sortContent(data,url);
            </script>
            <div class='modal_window' id='add_reason'>
                <div class='hidden_block' data-modal-id='add_reason'></div>
                <form class = 'add_reason'>
                    <h2>Добавление справки</h2>
                    <input type='hidden' id='studId' name='studId'>
                    <div class='select_block'>
                        <div class='select' data-name='studId'><span>Выберете студента</span></div>
                        <div class='select_list'>
                        <div class='select_item selected' data-value='0'><span>Выберете студента</span></div>
                            $result
                        </div>
                    </div>
                    <input type='text' onfocus = 'this.type = \"date\"' onblur = 'this.value==\"\"?this.type = \"text\":0' placeholder = 'Введите дату начала справки' class='date' name='start'>  
                    <input type='text' onfocus = 'this.type = \"date\"' onblur = 'this.value==\"\"?this.type = \"text\":0' placeholder = 'Введите дату окончания справки' class='date' name='end'> 
                    <textarea placeholder='Краткое описание причины отсутсвия' name='description'></textarea>
                    <input type='submit' onclick='event.preventDefault();' value='Добавить справку' id='add_reason_button'>
                </form>
            </div>
            <script src='scripts/add_reason/add_reason.js'></script>
        ";
    break;
//Eroor 404
    default:
        echo "Error 404";
}
