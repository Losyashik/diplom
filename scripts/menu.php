<?php
$menu = array(
    '1' => array("name" => "Список групп", "page" => "./", "src"=>"images/Untitled-2.png"),
    '2' => array("name" => "Отчеты", "page" => "./reports", "src"=>"images/Untitled-3.png"),
    '3' => array("name" => "Для куратора", "page" => "./curator_page", "src"=>"images/Untitled-1.png")
);
class load_page_vars {

    function title(){

        global $menu;
        $item = $menu;

        $i=0;
        foreach($item as $k => $value)
        {
            $i++;
            if($item[$i]["page"] == ".".$this->state())
            {
                return $item[$i]["name"];
            }        
        }
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
        );
         
        $data = http_build_query($post);//Посмотреть что ето

        $opts = array(
                  'http' => array(
                      'method' => 'POST',
                      'header' => "Content-type: application/x-www-form-urlencoded\r\nContent-Length: " . strlen($data) . "\r\n",
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