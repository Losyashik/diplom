<?php
function translit($str) {
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
}
$menu = array(
    '1' => array("name" => "Список групп", "page" => "./group_list", "src"=>"images/Untitled-2.png"),
    '2' => array("name" => "Отчеты", "page" => "./reports", "src"=>"images/Untitled-3.png"),
    '3' => array("name" => "Для куратора", "page" => "./curator_page", "src"=>"images/Untitled-1.png")
);
$groups = array();
$discipline_url = array();
$link = mysqli_connect('','root','','isup');
$result = $link->query("SELECT id, `name` FROM `groups` WHERE id in (SELECT group_id FROM gdp WHERE id=".$_SESSION['user']['id'].")");
for($data=[];$row = mysqli_fetch_assoc($result);$data[]=$row);
foreach($data as $elem){
    $groups[] = array("name" => $elem['name'], "page" => "./".translit($elem['name']));
}
foreach($groups as $group){
    $result = $link->query("SELECT * FROM discipline WHERE id in (SELECT discipline_id FROM gdp WHERE group_id in (SELECT id FROM groups WHERE name = '".$group['name']."') AND teacher_id = ".$_SESSION['user']['id'].")") or die(mysqli_error($link));
    for($data=[];$row = mysqli_fetch_assoc($result);$data[]=$row);
    foreach($data as $discipline){
        $discipline_url[] = array("name" => $discipline['name']." ".$group['name'], "page" => "./".translit($group['name']."_".$discipline['name']));
    }
}
class load_page_vars {

    function title(){

        global $menu;
        global $groups;
        global $discipline_url;
        $item = $menu;
        $item_groups = $groups;
        $i=0;
        foreach($item as $k => $value)
        {
            $i++;
            if($item[$i]["page"] == ".".$this->state())
            {
                return $item[$i]["name"];
            }        
        } 
        foreach($item_groups as $value){
            if($value["page"] == ".".$this->state())
            {
                return $value["name"];
            }       
        }
        foreach($discipline_url as $value){
            if($value["page"] == urldecode(".".$this->state()))
            {
                return $value["name"];
            }       
        }
        return "Error 404";
    }

    function menu(){

        global $menu;

        $str = '';
        $i=0;
        foreach($menu as $k => $value)
        {
            $i++;
            $str.= "<a href='".$menu[$i]["page"].($menu[$i]['page']==".".$this->state()?"' class='navigation_block selected'":"' class='navigation_block'")." title='".$menu[$i]["name"]."'><img src=".$menu[$i]['src']."><p>".$menu[$i]["name"]."</p></a>";
        }
        return $str;
    }



    function content($page, $name){
        $post = array(
            'page' => ".".$page,
            'name' => $name,
            'user[id]' => $_SESSION['user']['id'],
            'user[full_name]'=>$_SESSION['user']['full_name']
        );
         
        $data = http_build_query($post);//Посмотреть что ето
        $opts = array(
                  'http' => array(
                      'method' => 'POST',
                      'header' => 
                        "Content-type: application/x-www-form-urlencoded\r\n".
                        "Content-Length: " . strlen($data) . "\r\n",
                      'content' => $data,
                  )
               );

        $context  = stream_context_create($opts);

        $url = $this->siteURL()."/scripts/content.php";
        $content = file_get_contents($url,FALSE,$context);

        return $content;
    }
    function state() {
        $request = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
        $str_repl = str_replace($request, '', $_SERVER['REQUEST_URI']);
        return $str_repl;
    }

    function siteURL()
    {
        //Проверка протокола http или https
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
          $protocol = 'https://';
        }
        else {
          $protocol = 'http://';
        }
        //Путь где находится index.php
        $siteUrl = $protocol.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];
        //Возвращаем url index.php без названия файла
        return dirname($siteUrl);
        
    }

}
$data = new load_page_vars();
?>