<?php
$date = $_POST['date'];
$group = $_POST['group'];
$link = mysqli_connect('', 'root', '', 'isup');
$result = $link->query("SELECT * FROM `lecture` WHERE date='$date' AND gdp_id in (SELECT id FROM gdp WHERE group_id = (SELECT id FROM groups WHERE name = '$group'))");
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
$result = '
    <table>
        <tr>
            <th class="pair">№</th>
            <th class="name">Предмет</th>
            <th>Отсутствующие</th>
        </tr>
';
foreach ($data as $elem) {
    $res = mysqli_fetch_assoc($link->query("SELECT * FROM `discipline` WHERE `id` in (SELECT `discipline_id` FROM `gdp` WHERE id = ".$elem['gdp_id'].")"))['name'];
    $result .= "
        <tr>
            <td class='pair'>".$elem['pair_number']."</td>
            <td class='name'>$res</td>
            <td>";
        $res = $link->query("SELECT * FROM `students` WHERE `id` in (SELECT `student_id` FROM `result` WHERE `lecture_id` = ".$elem['id'].")");
        for($students=[];$row = mysqli_fetch_assoc($res);$students[]=$row);
        $count=0;
        $lenght = count($students);
        foreach($students as $student){
            $count++;
            if($count == $lenght)
                $result.= $student['surname'];
            else
                $result.= $student['surname'].", ";
        }
    $result .= "</td>
        </tr>
    ";
}
echo $result . '</table>';
