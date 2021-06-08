<?php
//$group = $_POST['group'];
$student_id = $_POST['sId'];
$link = mysqli_connect('', 'root', '', 'isup');

$result = $link->query("SELECT * FROM reason WHERE id in (SELECT reason_id FROM result WHERE student_id = $student_id)") or die ($link->error);
if($result->num_rows==0){
    echo "
    <div class='reason list_item'>Справок нет</div>
    ";
}
else{
    for($arr = [];$row = $result->fetch_assoc();$arr[]=$row);
    $result='';
    foreach($arr as $elem){
        $result.="
        <div class='reason list_item'>
            <table>
                <tr>
                    <th>Дата начала</th>
                    <th>Дата окончания</th>
                    <th>Причина</th>
                    <td rowspan=2><div class='delete_reason' data-id='".$elem['id']."'>Удалить</div></td>
                </tr>
                <tr>
                    <td>".date('d.m.Y',strtotime($elem['date_start']))."</td>
                    <td>".date('d.m.Y',strtotime($elem['date_end']))."</td>
                    <td>".$elem['reason']."</td>
                </tr>
            </table>
        </div>
        ";
    }
    echo $result;
}

                        
                   
