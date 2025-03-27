<?php
include_once "functions.php";
$menu = getMenuData("header");
?>

<body>
<header class="container main-header">
    <div>
        <a href=<?php echo $menu['home']['path']; ?>>
            <img src="img/logo.png" height="40">
        </a>
    </div>
    <nav class="main-nav">
        <ul class="main-menu" id="main-menu container">
            <li><a href=<?php echo (array_key_exists("theme", $_GET) && $_GET["theme"] === "dark") ? "?theme=light" : "?theme=dark"; ?> >Zmena témy</a></li>
            //pracujeme priamo z _GET, preto potrebujeme overiť, či kľúč existuje

            <?php printMenu($menu); ?>
        </ul>
        <a class="hamburger" id="hamburger">
            <i class="fa fa-bars"></i>
        </a>
    </nav>
</header>
