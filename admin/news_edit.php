<?php
$link = mysqli_connect('localhost', 'root', '', 'dota2news');
if (isset($_GET['id'])) {
    $query = 'select *  from news where id=' . $_GET['id'];
    $res = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($res);
    $title = $data['title'];
    $text = htmlspecialchars_decode($data['text']);
    $bol = true;
    $a = $_GET['id'];
} else {
    $query = 'SELECT MAX(id) as mid FROM news';
    $a = mysqli_query($link, $query);
    $a = mysqli_fetch_array($a);
    $a = $a['mid'];
    $a += 1;
    $bol = false;
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Адаптивная вёрстка сайта</title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic|Playfair+Display:400,700&subset=latin,cyrillic">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/media.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/NewsPageCSS.css">
    <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../assets/js/jquery-3.5.1.js"></script>
    <!--  <script type="text/javascript" src="../assets/js/jsNews_left.js"></script>-->
    <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
    <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>-->
    <style type="text/css">
        .article_main{
            position: relative;
        }
        .article_main:hover::before{
            display: block;
            text-align: center;
            position: absolute;
            right: -17px;
            writing-mode: vertical-lr;
            height: 100%;
            cursor: pointer;
            line-height: 15px;
            color: crimson;
            border-left: 2px solid;
            content: 'Удалить блок';
        }
        .article_main p {
            margin-bottom: 20px;
        }

        .article_main p:last-child {
            margin-bottom: 0;
        }

        .container {
            min-height: 100vh;
            margin-bottom: 60px;
            padding-bottom: 20px;
        }

        .button_right_block {
            width: 160px;
            position: fixed;
            right: 0;
            top: 200px;
            padding: 20px;
            background: #626262;
        }

        .button_right_block button {
            margin: 5px auto;
            width: 100%;
            padding: 2px;
        }

        .content_article * {
            outline: none;
        }

        .image_1_article {
            background: none;
            padding: 30px 0;
        }

        .image_1_article img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .edit_image {
            width: 100%;
            height: 100%;
            opacity: .8;
            background: #000000;
            position: relative;
            top: -290px;
            display: none;
            text-align: center;
            vertical-align: middle;
            color: #FFFFFF;
        }

        .edit_image:hover {
            display: block;
        }
        .delite_image{
            display: block;
            margin-bottom: 15px;
            z-index: 120;
            border: 2px solid;
            width: 20%;
            margin: 15px auto 0 auto;
        }
        .delite_image:hover{
            color: crimson;
            
        }
        .image_1_article img:hover+.edit_image {
            display: block;
        }

        .edit_image div {
            opacity: 1;
            display: block;
            top: 140px;
            z-index: 100;
            width: 100%;
            position: relative;
        }

        .select_title {
            width: 60%;
            height: 500px;
            overflow: auto;
            position: fixed;
            top: 50px;
            left: 20%;
            background: #9E9C9C;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding-bottom: 70px;
            z-index: 100;
        }

        .select_title h1 {
            height: auto;
            width: 100%;
            height: 10%;
            margin-top: 15px;
            text-align: center;
        }

        .select_title button {
            width: 20%;
            position: fixed;
            bottom: calc(100% - 550px);
            margin: 10px 40%;
            height: 50px;
            z-index: 101;
        }

        .select_title img {
            display: block;
            width: 30%;
            margin: 3px;
            height: 200px;
            object-fit: cover;
        }

        img.selected {
            z-index: 101;
            width: 80%;
            height: auto;
            top: 115px;
            left: 40%;
        }
    </style>
</head>

<body id="body">

    <div class="button_right_block">
        <button id="add_image">Добавить изображение</button>
        <button id="add_paragraph">Добавить блок текста</button>
        <?php
        if(isset($_GET['id'])){
            echo '<button id="submit">Сохранить</button>';
        }
        else{
            echo '<button id="submit">Опубликовать</button>';
        }
        ?>
        <form id="images" method="post" enctype="multipart/form-data" style="display:none;">

        </form>
    </div>
    <div class="container">
        <div class="container_more_news">
            <strong class="News-sidebar_title">
                <a href="../news.php">Новости</a>
                <hr class="News_line">
            </strong>

            <div class="news_content">
                <div class="left_block">
                    <!-- Дополнительная новость -->
                    <p class="left_block_title">Valve подняла цену на Dota Plus для игроков из России на 30%</p>
                    <hr> <!-- Заголовок -->
                    <p class="left_block_article">Valve обновила цены на Dota Plus для пользователей из России. Разработчики не сообщили, чем вызвано подорожание. Предположительно, корректировка связана с изменением курса рубля по отношению к доллару.</p> <!-- Основная информация -->
                    <a href="" class="button_left_block">Подробнее</a> <!-- Кнопка подробнее -->
                </div>
                <div class="left_block">
                    <!-- Дополнительная новость -->
                    <p class="left_block_title">Valve подняла цену на Dota Plus для игроков из России на 30%</p>
                    <hr> <!-- Заголовок -->
                    <p class="left_block_article">Valve обновила цены на Dota Plus для пользователей из России. Разработчики не сообщили, чем вызвано подорожание. Предположительно, корректировка связана с изменением курса рубля по отношению к доллару.</p> <!-- Основная информация -->
                    <a href="" class="button_left_block">Подробнее</a> <!-- Кнопка подробнее -->
                </div>
            </div>
        </div>
        <div class="content_article">
            <div class="dota-text"><strong>Dota2</strong></div><br>
            <div class="title-text"><strong contenteditable="true">
                    <?php
                    if ($bol) {
                        echo $title;
                    } else {
                        echo 'Введите заголовок';
                    }
                    ?>
                </strong>
            </div> <!-- Заголовок -->
            <div class="date_time">15.09.1999, 14:51</div> <!-- Дата -->
            <div class="content">
                <?php
                if ($bol) {
                    echo $text;
                }
                ?>
            </div>
        </div>
    </div> <!-- конец div class="container"-->



    <footer>
        <div class="container3">
            <div class="footer-col"><span>Dota2News © 2020</span></div>
            <div class="footer-col">
                <div class="social-bar-wrap">
                    <a title="Facebook" href="" target="_blank"><i class="fa fa-facebook"></i></a>
                    <a title="Twitter" href="" target="_blank"><i class="fa fa-twitter"></i></a>
                    <a title="Pinterest" href="" target="_blank"><i class="fa fa-pinterest"></i></a>
                    <a title="Instagram" href="" target="_blank"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <a href="mailto:admin@yoursite.ru">Обратная связь</a>
            </div>
        </div>
    </footer>
    <script>
        <?php
        if ($bol) {
            echo 'var bol = true;';
        } else {
            echo 'var bol = false;';
        }
        ?>

        var blockNews = '';
        var article = $('.content');
        var countImage = 0;
        var titleImage;
        var id = <?php echo $a; ?>;
        var dir = 'NewsId' + id;
        var a = true;
        editedImg = [];

        function createElem(element, className, id) {
            elem = document.createElement(element);
            if (className != undefined)
                elem.setAttribute('class', className);
            if (id != undefined) {
                elem.setAttribute('id', id);
            }
            return elem
        }
        if (bol) {
            $('.text').attr('contenteditable', 'true');
            $('img').each(function(index){
                $(this).attr('src','../'+$(this).attr('src'));
                div = createElem('div');
                a_delite = createElem('a','delite_image');
                label = createElem('label', 'edit_image');
                label.setAttribute('for', 'img' + index);
                imageBlock = $(this).parent()
                imageBlock.append(label);
                label.append(div);
                div.append('Изменить изображение');
                div.append(a_delite);
            a_delite.append('Удалить изображение');
                input = createElem('input', 'image', 'img' + index);
                input.setAttribute('name', $(this).attr('id'));
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/jpeg,image/png,image/gif');
                $('#images').append(input);
                a = false;
            }
            )
        }
        $('.content').on('click','.article_main', function(){
            if (this.offsetWidth - event.offsetX < 0) {
                $(this).detach();
            }
        });
        function createImage() {
            div = createElem('div');
            a_delite = createElem('a','delite_image');
            imageBlock = createElem('div', 'image_1_article');
            image = createElem('img', undefined, 'image' + countImage);
            label = createElem('label', 'edit_image');
            label.setAttribute('for', 'img' + countImage);
            article.append(imageBlock);
            imageBlock.append(image);
            imageBlock.append(label);
            label.append(div);
            div.append('Изменить изображение');
            div.append(a_delite);
            a_delite.append('Удалить изображение');

            input = createElem('input', 'image', 'img' + countImage);
            input.setAttribute('name', 'image' + countImage);
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/jpeg,image/png,image/gif');
            $('#images').append(input);
            countImage += 1;
        }

        function createTextBlock() {
            articleMain = createElem('div', 'article_main');
            paragraph = createElem('p', 'text');
            paragraph.setAttribute('contenteditable', 'true');
            article.append(articleMain);
            articleMain.append(paragraph);
            paragraph.focus()
        }
        
        $('.content').on('click', '.image_1_article label a',function(){
            event.cancelBubble = true
            inp_del = $(this).parent().parent().attr('for');
            $("#"+inp_del).detach();
            $(this).parent().parent().parent().detach();
        })
        $('#add_paragraph').on('click', createTextBlock);
        $('#add_image').on('click', createImage);

         
        $('#submit').on('click', e => {
            select = document.createElement('div')
            select.setAttribute('class', 'select_title')
            selectBut = document.createElement('button')
            selectBut.setAttribute('id', 'select')
            selectTitle = document.createElement('h1')
            $('#body').append(select)
            select.append(selectTitle)

            selectTitle.innerHTML = 'Выберете главное изображение новости'
            $('#images input').each(function(index, event) {
                imageName = event.name;
                let fileType = event.value.substr(event.value.indexOf('.'));
                image = document.createElement('img')
                image.setAttribute('src', $('#' + imageName).attr('src'));
                if(bol){
                    if(editedImg.indexOf(imageName) != -1){
                        image.setAttribute('name', index + fileType)
                    }
                    else{
                        from = $('#' + imageName).attr('src').lastIndexOf('/')+1; 
                        var to = $('#' + imageName).attr('src').length;
                        newstr = $('#' + imageName).attr('src').substring(from,to);
                        image.setAttribute('name',newstr);
                    }
                }   
                else{
                    image.setAttribute('name', index + fileType)
                }
                select.append(image);
                
            });
            select.append(selectBut);
            selectBut.innerHTML = 'Выбрать и опубликовать'
        });

        $('#body').on('click', '.select_title button', submit);

        $('#body').on('click', '.select_title img', e => {

            if (titleImage == e.currentTarget.name) {
                $('.select_title img').removeClass('selected');
                titleImage = undefined;
            } else {
                titleImage = e.currentTarget.name;
                $('.select_title img').removeClass('selected');
                e.currentTarget.setAttribute('class', 'selected');
                e.currentTarget.focus()
            }
            console.log(titleImage);
        })

        function submit() {
            let title = $('.title-text strong').html();
            $('#images input').each(function(index, event) {
                imageName = event.name;

                if (bol){
                    
                    if(editedImg.indexOf(imageName) != -1){ 
                        console.log('aaaa');
                        let fileType = event.value.substr(event.value.indexOf('.'));
                        $('#' + imageName).attr('src', 'assets/img/news/' + dir + '/' + index + fileType);
                        value = event.files[0];
                        let data = new FormData();

                        data.append(index,value)

                        data.append('count', index);
                        data.append('id', id);
                        data.append('title', dir);
                        for (key of data.keys()) {
                                console.log(`${key}: ${data.get(key)}`);
                            }
                        // AJAX запрос
                        $.ajax({
                            url: 'ajax.php',
                            type: 'POST', // важно!
                            data: data,
                            cache: false,
                            dataType: 'json',
                            // отключаем обработку передаваемых данных, пусть передаются как есть
                            processData: false,
                            // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
                            contentType: false,
                            // функция успешного ответа сервера
                            success: data => {
                                alert(data);
                            }
                        });
                    }
                    else{
                        $('#' + imageName).attr('src', $('#' + imageName).attr('src').slice(3));
                    }
                }
                else{
                    let fileType = event.value.substr(event.value.indexOf('.'));
                    $('#' + imageName).attr('src', 'assets/img/news/' + dir + '/' + index + fileType);
                    value = event.files[0];
                    let data = new FormData();

                    data.append(index,value)

                    data.append('count', index);
                    data.append('title', dir);
                    for (key of data.keys()) {
                            console.log(`${key}: ${data.get(key)}`);
                        }
                    // AJAX запрос
                    $.ajax({
                        url: 'ajax.php',
                        type: 'POST', // важно!
                        data: data,
                        cache: false,
                        dataType: 'json',
                        // отключаем обработку передаваемых данных, пусть передаются как есть
                        processData: false,
                        // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
                        contentType: false,
                        // функция успешного ответа сервера
                        success: data => {
                            alert(data);
                        }
                    });
                }
            });
            $('.text').removeAttr('contenteditable');
            $('.text').each(function(index, event) {
                console.log(event);
                text_p = event.innerHTML;
                console.log(text_p);
                text_p = text_p.replace(/<[^>]+>/g, '');
                event.innerHTML = text_p;
            })
            $('.edit_image').detach();
            let text = article.html();
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                data: {
                    'text': text,
                    'title': title,
                    'img-title': titleImage,
                    'mid': dir,
                    'maxId':id
                },
                success: data => {
                    if(bol)
                        alert("Новость изменена");
                    else
                        alert("Новость добавлена");
                    window.location.reload();
                }
            });
        }

        $('.content_article').on('keydown', '.text', event => {
            block = event.currentTarget;
            if (event.keyCode === 13) {
                paragraph = createElem('p', 'text');
                paragraph.setAttribute('contenteditable', 'true');
                event.preventDefault();
                block.insertAdjacentElement('afterend', paragraph);
                paragraph.focus()
            }
            if (event.code === 'Backspace') {
                if (block.innerHTML == '') {
                    len = block.parentNode.childNodes.length;
                    console.log(len)
                    const range = document.createRange();
                    if(len>1){
                        range.selectNodeContents(block.previousSibling);
                        range.collapse(false);
                        const sel = window.getSelection();
                        sel.removeAllRanges();
                        sel.addRange(range);
                        block.parentNode.removeChild(block);
                    }
                    else{
                        block.parentNode.remove()
                    }
                    
                }
            }
        });

        $('#images').on('change', '.image', function(e,index) {
            imageName = e.currentTarget.name;
            input = e.currentTarget;
            editedImg.push(imageName);
            fileType = e.currentTarget.value.substr(e.currentTarget.value.indexOf('.'));
            files = e.currentTarget.files;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {

                    $('#' + imageName).attr('src', e.target.result);

                }

                reader.readAsDataURL(input.files[0]);
            }
        });

        
        $('.title-text strong').on('focus', e => {
            if (a) {
                e.currentTarget.innerHTML = '';
                a = false;
            }
        });

        $('.nav-toggle').on('click', function() {
            $('#menu').toggleClass('active');
        });
    </script>
</body>

</html>