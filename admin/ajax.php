<?php

// data.append('location',locat);
// data.append('formate',formate);
// data.append('summ',summ);
    $link = mysqli_connect('localhost','root','','dota2news');
    if(isset($_POST['formate'])){
        $id = $_POST['id'];
        $editIMG = $_POST['editIMG'];
        $date = $_POST['date'];
        $name = $_POST['name'];
        $text = htmlspecialchars($_POST['text_event']);
        $formate = $_POST['formate'];
        $title = $_POST['title'];
        $location = $_POST['location'];
        $summ = $_POST['summ'];
        var_dump($editIMG);
        $query = 'select * from events where id='.$id;
        $result = mysqli_query($link,$query);
        if($result->num_rows>0){
            if($editIMG == 'true'){
                $img = $_FILES['image'];
                $dirFiles = scandir("../assets/img/events");
                foreach($dirFiles as $elem){
                    $pos = strpos($elem, '.');
                    if(substr($elem,0, $pos)=='event'.$id){
                        if(unlink("../assets/img/events/$elem")){
                            var_dump('delete');
                        }
                    }
                }
                $name_image = $img['name'];
                $type = stripos($name_image, '.', mb_strlen($img['name']) - 5);
                $type = substr($img['name'], $type, mb_strlen($img['name']));
                $dir = "../assets/img/events/event$id$type";
                if(move_uploaded_file($img['tmp_name'], $dir))
                    $link->query("UPDATE `events` SET `title`='$title',`name`='$name',`img`='assets/img/events/event$id$type',`text`='$text',`date`='$date',`location`='$location',`formate`='$formate',`summ`=$summ WHERE id = $id") or die ($link->error);
                else
                    echo('error upload file');
            }
            else
                $link->query("UPDATE `events` SET `title`='$title',`name`='$name',`text`='$text',`date`='$date',`location`='$location',`formate`='$formate',`summ`=$summ WHERE id = $id") or die ($link->error);
        }
        else{
            $img = $_FILES['image'];
            $name_image = $img['name'];
            $type = stripos($name_image, '.', mb_strlen($img['name']) - 5);
            $type = substr($img['name'], $type, mb_strlen($img['name']));
            $dir = "../assets/img/events/event$id$type";
            if(move_uploaded_file($img['tmp_name'], $dir))
                $link->query("INSERT INTO `events`(`id`, `title`, `name`, `img`, `text`, `date`, `location`, `formate`, `summ`) VALUES ('$id', '$title', '$name', 'assets/img/events/event$id$type', '$text', '$date', '$location', '$formate', '$summ')") or die ($link->error);
            else
                echo('error upload file');
        }
    }
    if(isset($_GET['id']) and isset($_GET['name']) and isset($_GET['text'])){
        $text = $_GET['text'];
        $id = $_GET['id'];
        $name = $_GET['name'];
        $link->query("UPDATE `command` SET `$name` = '$text' WHERE id = $id");
    }
    if(isset($_POST['count'])) {
        $id = $_POST['id'];
        $count = $_POST['count'];
        $title = $_POST['title'];
        if(!file_exists("../assets/img/news/$title")){
            mkdir("../assets/img/news/$title");
        }

        $query = 'select * from news where id='.$id;
        $result = mysqli_query($link,$query);
        if($result->num_rows>0){
            $dirFiles = scandir("../assets/img/news/$title");
            foreach($dirFiles as $elem){
                $pos = strpos($elem, '.');
                if(substr($elem,0, $pos)==$count){
                    if(unlink("../assets/img/news/$title/$elem")){
                        var_dump('delete');
                    }
                }
            }
        }
        
        $img = $_FILES[$count];
        
        $name = $img['name'];
        $type = stripos($name, '.', mb_strlen($img['name']) - 5);
        $type = substr($img['name'], $type, mb_strlen($img['name']));
        move_uploaded_file($img['tmp_name'], "../assets/img/news/$title/$count$type");
    }
    if(isset($_POST['text'])){
        
        $html =  htmlspecialchars($_POST['text']);
        $id = $_POST['maxId'];
        $dir = $_POST['mid'];
        $title = htmlspecialchars($_POST['title']);
        $titleImg = $_POST['img-title'];
        $titleImg = "assets/img/news/$dir/$titleImg";
        $query = 'select * from news where id='.$id;
        $result = mysqli_query($link,$query);
        if($result->num_rows>0){
            $query = "UPDATE `news` SET `title`='$title',`text`='$html',`title_img`='$titleImg' WHERE id = $id";
        }
        else{
            $query = 'INSERT INTO `news`(`id`,`title`, `text`, `title_img`) VALUES ('.$id.',"'.$title.'","'.$html.'","'.$titleImg.'")';
        }
        mysqli_query($link,$query) or die(mysqli_error($link));
        echo $html;
    }

