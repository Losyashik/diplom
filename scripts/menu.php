<?php
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
$link = mysqli_connect('', 'root', '', 'isup');
function translit($str)
{
    $rus = array(" ", 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('~', 'A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
}
$menu = array(
    '1' => array("name" => "Список групп", "page" => "./group_list", "src" => "images/groups.png"),
    '2' => array("name" => "Отчеты", "page" => "./reports", "src" => "images/reports.png")
);
$result = $link->query("SELECT name FROM groups WHERE curator_id = " . $_SESSION['user']['id']);
if (mysqli_num_rows($result) > 0) {
    $menu[3] = array("name" => "Для куратора", "page" => "./curator_page", "src" => "images/curator.png");
    $supervised_group = mysqli_fetch_assoc($result)['name'];
}
switch ($_SESSION['user']['role']) {
    case 1:
        $menu[4] = array("name" => "Панель администратора", "page" => "./admin", "src" => "images/admin_icon.png");
        break;
}



$groups = array();
$discipline_url = array();
$result = $link->query("SELECT id, `name` FROM `groups` WHERE id in (SELECT group_id FROM gdp WHERE teacher_id=" . $_SESSION['user']['id'] . ")");
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
foreach ($data as $elem) {
    $groups[] = array("name" => $elem['name'], "page" => "./" . translit($elem['name']));
}
foreach ($groups as $group) {
    $result = $link->query("SELECT * FROM discipline WHERE id in (SELECT discipline_id FROM gdp WHERE group_id in (SELECT id FROM groups WHERE name = '" . $group['name'] . "') AND teacher_id = " . $_SESSION['user']['id'] . ")") or die(mysqli_error($link));
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    foreach ($data as $discipline) {
        $discipline_url[] = array("discipline_name" => $discipline['name'], "group_name" => $group['name'], "page" => translit($group['name'] . "_" . $discipline['name']));
    }
}
class load_page_vars
{

    function title()
    {
        global $supervised_group;
        global $menu;
        global $groups;
        global $discipline_url;
        $item = $menu;
        $item_groups = $groups;
        $i = 0;
        foreach ($item as $k => $value) {
            $i++;
            if ($item[$i]["page"] == "." . $this->state()) {
                return $item[$i]["name"];
            }
        }
        foreach ($item_groups as $value) {
            if ($value["page"] == "." . $this->state()) {
                return $value["name"];
            }
        }
        foreach ($discipline_url as $value) {
            if ("./" . $value["page"] == urldecode("." . $this->state())) {
                return $value["discipline_name"] . " " . $value['group_name'];
            } else if ("./day_request_" . $value["page"] == urldecode("." . $this->state())) {
                return "Отчет за день по " . $value["discipline_name"] . " по " . $value['group_name'];
            } else if ("./mounth_request_" . $value["page"] == urldecode("." . $this->state())) {
                return "Отчет за месяц по " . $value["discipline_name"] . " группы " . $value['group_name'];
            }
        }
        if (isset($supervised_group))
            switch (urldecode("." . $this->state())) {
                case "./" . translit($supervised_group) . "_report_mounth":
                    return "Отчёт по посещаймости группы $supervised_group за месяц";
                    break;
                case "./" . translit($supervised_group) . "_report_day":
                    return "Отчёт по посещаймости группы $supervised_group за день";
                    break;
                case "./add_reason_for_" . translit($supervised_group):
                    return "Добавление справок группы $supervised_group";
                    break;
            }
        return "Error 404";
    }

    function menu()
    {

        global $menu;

        $str = '';
        $i = 0;
        foreach ($menu as $k => $value) {
            $i++;
            $str .= "<a href='" . $menu[$i]["page"] . ($menu[$i]['page'] == "." . $this->state() ? "' class='navigation_block selected'" : "' class='navigation_block'") . " title='" . $menu[$i]["name"] . "'><img src=" . $menu[$i]['src'] . "><p>" . $menu[$i]["name"] . "</p></a>";
        }
        return $str;
    }



    function content($page, $name)
    {
        $post = array(
            'page' => "." . $page,
            'name' => $name,
            'user[id]' => $_SESSION['user']['id'],
            'user[full_name]' => $_SESSION['user']['full_name'],
            'user[role]' => $_SESSION['user']['role']
        );

        $data = http_build_query($post); //Перестройка данных для запроса
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' =>
                "Content-type: application/x-www-form-urlencoded\r\n" .
                    "Content-Length: " . strlen($data) . "\r\n",
                'content' => $data,
            )
        );

        $context  = stream_context_create($opts); //Создаиние контекста запроса

        $url = $this->siteURL() . "/scripts/content.php";
        $content = file_get_contents($url, FALSE, $context); //отправка post запроса в contrnt.php

        return $content;
    }
    function state()
    {
        $request = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
        $str_repl = str_replace($request, '', $_SERVER['REQUEST_URI']);
        return $str_repl;
    }

    function siteURL()
    {
        //Проверка протокола http или https
        if (
            isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
        ) {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        //Путь где находится index.php
        $siteUrl = $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"];
        //Возвращаем url index.php без названия файла
        return dirname($siteUrl);
    }
}
$data = new load_page_vars();
