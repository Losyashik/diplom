<?php
include "html.php";
$link = mysqli_connect('localhost','root','','isup');
switch ($_POST["page"]) {
    case "./":
        //$link->query('SELECT * FROM ');
    break;

    case "./reports":
        echo "<p>Текст2...</p>";
    break;

    case "./curator_page":
        echo "<p>Текст3...</p>";
    break;
}

?>