<?php
$link = mysqli_connect('', 'root', '', 'isup');
function translit($str) {
    $rus = array(' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('~','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
}
function reversTranslit($str) {
    $rus = array(' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('~','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($lat, $rus, $str);
}
include_once('modules/sort.php');
if(isset($_POST['reports'])){
    $result = $link->query(sortGroup());
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        $result = '';
        foreach ($data as $elem) {
            $result .= "<div class='list_item report_name'><h5>" . $elem['name'] . "</h5><div class = 'discipline_list'>";
            
            $res = $link->query("SELECT * FROM discipline WHERE id in(SELECT discipline_id FROM gdp WHERE group_id = " . $elem['id'] . " AND teacher_id = " . $_SESSION['user']['id'] . ")");
            for ($arr = []; $row = mysqli_fetch_assoc($res); $arr[] = $row);
            foreach ($arr as $discipline) {
                $result .= "<a class='report_for_discipline'  title='Отчет за месяц по ".$discipline["name"]." группы ".$elem['name']."' href='./mounth_request_".translit($elem['name'])."_".translit($discipline['name']) ."'>".$discipline['name']."</a>";    
            } 
            $result.="</div></div>";
    }
    echo $result;
}
if(isset($_POST['group_list'])){
    $result = $link->query(sortGroup());
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        $result = "";
        foreach ($data as $elem) {
            $result .= "<a href='./" . translit($elem['name']) . "' title='" . $elem['name'] . "' class='list_item group_name'>" . $elem['name'] . "</a>";
        }
        echo $result;
}