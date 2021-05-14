<?php
$link = mysqli_connect('', 'root', '', 'isup');
$result = $link->query("SELECT * FROM lecture WHERE date='".$_POST['date']."' AND pair_number = ".$_POST['pair_number']);
if(mysqli_num_rows($result)>0){
    session_start();
    $result = $link->query("SELECT * FROM lecture WHERE gdp_id in (SELECT id FROM gdp WHERE teacher_id=".$_SESSION['user']['id']." AND discipline_id = ".$_POST['discipline'].") AND date='".$_POST['date']."' AND pair_number = ".$_POST['pair_number']);
    
    if(mysqli_num_rows($result)>0){
        $lecture_id = mysqli_fetch_assoc($result)['id'];
        echo "
            <script>
                function edit(){
                    ";
                    $result = $link->query("SELECT * FROM result WHERE lecture_id in (SELECT id FROM lecture WHERE date='".$_POST['date']."' AND pair_number = ".$_POST['pair_number'].")")or die (mysqli_error($link));
                    for($data = [];$row=mysqli_fetch_assoc($result);$data[]=$row);
                    $result ='';
                    foreach($data as $elem){
                        $result.=$elem['student_id'].",";
                    }
                    echo "
                    checkedId=[$result];
                    lectureId=$lecture_id;
                    $('.student_name').each(function(i,e){
                        i = $(e).data('value')
                        if(!checkedId.includes(i)){
                            $(e).addClass('checked');
                        }
                    })
                }
            </script>
        ";
    }
    else{
        echo "
        <script>
            funcyion edit(){
                alert('Невозможно создать запись. Проверьте правильность введенных данных') 
            }
        </script>
        ";
    }
}
else
    echo "
    <script>
        function edit(){
            $('.student_name').removeClass('checked');
            lectureId=0;
        }
    </script>
    ";
