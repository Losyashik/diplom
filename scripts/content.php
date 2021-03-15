<?php
include "html.php";
switch ($_POST["page"]) {
    case "./":
        echo "<p>Текст1...</p>";
    break;

    case "./reports":
        echo "<p>Текст2...</p>";
    break;

    case "./curator_page":
        echo "<p>Текст3...</p>";
    break;
}

?>