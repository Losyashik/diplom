
<?php
function echoArr($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}
$link = mysqli_connect('', 'root', '', 'isup');
if (isset($_POST['gdp'])) {
    $gdp = $_POST['gdp'];
    $gdp_bool = TRUE;
} else {
    $gdp_bool = FALSE;
}
$group_name = $_POST['group'];
$mounth = $_POST['mounth'];
$year = $_POST['year'];
$sum_u = 0;
$sum_n = 0;
$sum_s = 0;
echo "<table>
    <tr>
 	<td>№</td>
 	<td style='width: 12vw'>ФИ</td>
";
//	ini_set('display_errors','Off');
$result = '';
if ($gdp_bool) {
    $result = $link->query("SELECT * FROM lecture WHERE gdp_id=$gdp AND date>='$year-$mounth-1' AND date<='$year-$mounth-" . cal_days_in_month(CAL_GREGORIAN, $mounth, $year) . "' ORDER BY `date` ASC");
    $num = mysqli_num_rows($result);
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    $result = '';
    foreach ($data as $elem) {
        $day = date('d', strtotime($elem['date']));
        $result .= "<td class='h'>$day</td>";
    }
} else {
    $num = cal_days_in_month(CAL_GREGORIAN, $mounth, $year);
    for ($i = 1; $i <= $num; $i++) {
        $result .= "<td class='h'>$i</td>";
    }
}
echo $result . "<td style='text-align:center;'>итог</td>
	 		<td style='text-align:center;'>уваж.</td>
	 		<td style='text-align:center;'>не уваж</td>
 		</tr>";
$query = "SELECT * FROM students WHERE group_id in (SELECT id FROM groups WHERE name ='$group_name')";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
$result = "";
$no = 0;
foreach ($data as $elem) {
    $no++;
    $stud_id = $elem['id'];
    $result .= '<tr>';
    $result .= '<td>' . $no . '</td>';
    $result .= '<td>' . $elem['surname'] . " " . $elem['name'] . '</td>';
    $sum = 0;
    $sum_uv = 0;
    if ($gdp_bool) {
        $res = $link->query("SELECT * FROM lecture WHERE gdp_id=$gdp AND date>='$year-$mounth-1' AND date<='".$year."-".$mounth."-" . cal_days_in_month(CAL_GREGORIAN, $mounth, $year)."' ORDER BY `date` ASC");
        for ($data_pair = []; $row = mysqli_fetch_assoc($res); $data_pair[] = $row);
        foreach ($data_pair as $el) {
            $day = date('d', strtotime($el['date']));
            $query = "SELECT result, reason_id FROM result WHERE lecture_id in (SELECT id FROM lecture WHERE gdp_id = $gdp AND id=".$el['id'].") AND lecture_id=".$el['id']." AND student_id = '$stud_id'";
            $res = mysqli_query($link, $query) or die(mysqli_error($link));
            $res = mysqli_fetch_assoc($res);
            $reason = $res['reason_id'];
            $res = $res['result'];
            if ($res == "н") {
                $result .= "<td style='text-align:center;'>" . $res . "</td>";
                $sum += 2;
                if ($reason != NULL) {
                    $sum_uv += 2;
                }
            } else {
                $result .= "<td style='text-align:center;'></td>";
            }
        }
    } else {
        for ($i = 1; $i <= cal_days_in_month(CAL_GREGORIAN, $mounth, $year); $i++) {
            $query = "SELECT result, reason_id FROM result WHERE lecture_id in (SELECT id FROM lecture WHERE date = '$year-$mounth-$i') AND student_id = '$stud_id'";
            $res = mysqli_query($link, $query) or die(mysqli_error($link));
            for ($data_pair = []; $row = mysqli_fetch_assoc($res); $data_pair[] = $row);
            $col = 0;
            if (mysqli_num_rows($res) > 0) {
                foreach ($data_pair as $res) {
                    if ($res['result'] == "н") {
                        $col += 2;
                        $sum += 2;
                        if ($res['reason_id'] != NULL) {
                            $sum_uv += 2;
                        }
                    }
                }
                $result .= "<td style='text-align:center;'>" . $col . "</td>";
            }
            else{
                $result .= "<td style='text-align:center;'></td>";
            }
        }
    }
    $result .= "<td style='text-align:center;'>" . $sum . "</td>";
    $sum_s += $sum;
    $result .= "<td style='text-align:center;'>" . $sum_uv . "</td>";
    $sum_u += $sum_uv;
    $result .= "<td style='text-align:center; width:3.4vw'>" . ($sum - $sum_uv) . "</td>";
    $sum_n += ($sum - $sum_uv);
    $result .= '<tr>';
}

echo $result;
echo "<tr style='width: 100%;'>";
$result = "";
for ($i = 0; $i < $num + 2; $i++) {
    $result .= "<td class='sum' style='border:none'></td>";
}
$result .= "<td style='text-align:center;'>" . $sum_s . "</td>";
$result .= "<td style='text-align:center;'>" . $sum_u . "</td>";
$result .= "<td style='text-align:center;'>" . $sum_n . "</td>";
echo $result;
