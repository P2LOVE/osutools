<?php

// Буду стараться по возможности комментить PHP для себя, да и в целом для упрощения кодревью :) 
$dbc = mysqli_connect("localhost", "root", "", "accs"); // Адрес БД, логин, пасс, бд
if(isset($_POST['but'])){
    $errorInfo = false;
    $usrnm = mysqli_real_escape_string($dbc, trim($_POST['usrnm'])); // Очистка строки
    $psswrd = mysqli_real_escape_string($dbc, trim($_POST['psswrd'])); // ^
    $eml = $_POST['eml']; // Бинд эмейла на пхп переменную
    if (!empty($eml) && (strpos($eml, '@'))){ // Проверка на наличие собаки в эмейле
        $eml = mysqli_real_escape_string($dbc, trim($_POST['eml'])); // Очистка строки
    }
    else {
        $eml = false; // Если собаки нет, то эмейл не идет в запрос на бд
    }
    $ircip = $_POST['ircip']; // Бинд айпи из инпута 
    if (!empty($ircip)){ // Проверка на наличие айпи
    $ircip = mysqli_real_escape_string($dbc, trim($_POST['ircip'])); // Очистка строки
    }
    else { 
        $ircip = mysqli_real_escape_string($dbc, '192.241.219.151'); // Дефолтный айпи irc сервака осу
    }
    if(!empty($usrnm) && (!empty($psswrd))){ // Проверка на заполненность обязательных полей
        $query = "SELECT * FROM `users` WHERE IRCLOGIN = '$usrnm'"; // Поиск на совпадение в бд юзернейма
        $data = mysqli_query($dbc, $query); // Составление + отправка SQL запроса
        if(mysqli_num_rows($data) !== 0) {  // Проверка нахождения юзернейма
            $query = "SELECT * FROM `users` WHERE IRCLOGIN = '$usrnm' AND IRCPASS = '$psswrd'"; // Запрос на проверку пароля в случае находа юзернейма
            $data = mysqli_query($dbc, $query);  // Составление + отправка SQL запроса
        if(mysqli_num_rows($data) !== 0 ) { // При совпадении логпасса смена значения онлайна
            $query = "SELECT ONOFF FROM `users` WHERE IRCLOGIN = '$usrnm'"; // Проверка статуса онлайна в БД
            $data = mysqli_query($dbc, $query);  // Составление + отправка SQL запроса
            $arr = mysqli_fetch_array($data);
            $onlinestats = implode($arr);
        if($onlinestats == 'onon' && (empty($eml)))  {
            $query = "UPDATE `users` SET `ONOFF`='off' WHERE `IRCLOGIN` = '$usrnm'"; // Запрос на отключениие онлайна без эмейла
            mysqli_query($dbc, $query);  // Составление + отправка SQL запроса
        } 
        if($onlinestats == 'onon'  && (!empty($eml))) { 
            $query = "UPDATE `users` SET `ONOFF`='off' WHERE `IRCLOGIN` = '$usrnm'"; // ^ но с эмейлом
            mysqli_query($dbc, $query);  // Составление + отправка SQL запроса
    }
        if($onlinestats == 'offoff'  && (!empty($eml))) {
        $query = "UPDATE `users` SET `ONOFF`='on' WHERE `IRCLOGIN` = '$usrnm'"; 
        mysqli_query($dbc, $query);  // Составление + отправка SQL запроса
    }
        if($onlinestats == 'offoff'  && (empty($eml))) { 
        $query = "UPDATE `users` SET `ONOFF`='on' WHERE `IRCLOGIN` = '$usrnm'"; 
        mysqli_query($dbc, $query); 
        }}}
    if(mysqli_num_rows($data) == 0 && (empty($eml))) { // Если не нашелся в бд такой логин добавляем его в БД
        $onoff = 'on'; // Говнокодэлемент
        $query = "INSERT INTO `users` (IRCLOGIN, IRCPASS, IRCIP, ONOFF) VALUES ('$usrnm', '$psswrd', '$ircip', '$onoff')"; // Отправка всех указанных данных в БД
        mysqli_query($dbc, $query);  // Составление + отправка SQL запроса
        $onlinestats = 'offoff';
    }

    if(mysqli_num_rows($data) == 0 && (!empty($eml))) {
        $onoff = 'on'; // Говнокодэлемент
        $query = "INSERT INTO `users` (IRCLOGIN, IRCPASS, EMAIL, IRCIP, ONOFF) VALUES ('$usrnm', '$psswrd', '$eml', '$ircip', '$onoff')"; // ^ Но с эмейлом
        mysqli_query($dbc, $query);  // Составление + отправка SQL запроса
        $onlinestats = 'offoff';
    }
}
else {
    echo '<script> var $errorInfo = "Nickname or Password is empty!"</script>';
}
} 
?>
<head> 
    <meta charset='utf-8'>
    <title>osu!tools</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../styles/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script> var $status = '<?php echo $onlinestats;?>'</script>
</head>
<body>
    <center><div class='header'><p class='hdr-text'>osu!tools</p></div>
        <div class='content'>
            <div class='preload' id='animation'></div>
            <div class='contenthdr'><p class='chdr-text'>New features at github.com/p2love</p></div>
            <p class='eohdr'>Endless online</p>
            <form class='contentins' method="POST">
                <p class='eofaq'>For use Endless Online:</p>
                <p class='eoftext' align='left'>Get your <a href="https://osu.ppy.sh/p/irc"><u>IRC</u></a> password here<br>Use your osu! nickname as username</p>
                <p class='alerttext' align='left'>STATUS WILL BE DISCARDED WHEN YOU INVALIDATE YOUR PERMANENT HASH<br>AND REGENERATE IRC PASSWORD.</p>
                <div id='dform' class='defform'>
                    <div class='ust'>Username*</div>
                    <input class='username' name="usrnm" placeholder='Your username' onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your username'">
                    <div class='pst'>IRC Password*</div>
                    <input name="psswrd" class='password'  placeholder='Your password' onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your password'">
                    <div class='emt'>E-Mail</div>
                    <input class='email' name="eml" placeholder='Your e-mail' onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your e-mail'">
                    <div class='einfo'>*you will get notification about expired<br>password and other status changes</div>
                    <div id="last"></div>
                    <div id="cbx" class='checkdiv'><label class='check'>I'm playing not on official osu!Bancho</label><input type='checkbox' id="cbxx" class='cb' ></div>
                    <form class='status' method="GET"><div class='crt crtColor' id='circle'></div><div class='status' id="stat">Current endless online status</div></form>
                    <button id="but" name="but" class='submit' type="sumbit">Change!</button>
                    </div>
            </form>
            </div>
            <div class='foot'>
            <span class='footT'>
                <a href='https://vk.me/0id19'><i id="vk" class="fab fa-vk border"></i></a>
                <a href='https://github.com/P2LOVE'><i id="git" class="fab fa-github border"></i></a>
                <a href='https://www.youtube.com/c/p2love'><i id="yt" class="fab fa-youtube border"></i></a>
                <a href='https://twitter.com/OsuTools'><i id="tw" class="fab fa-twitter border"></i></a>
                <a href='https://t.me/LoliPain'><i id="tlg" class="fab fa-telegram-plane border"></i></a>
                <p class='credit'>osu!tools by p2love &#169; 2019</p>
            </span>
            </div>
            </center>
            
            
</body>
<script src="../js/ircAdvanced.js"></script>
<script src="../js/status.js"></script>
<script src="../js/lottie.js"></script>
<script src="../js/preloader.js"></script>
<script src="../js/icons.js"></script>
<script src="../js/errorFunc.js"></script>
<script>errorFunc()</script>