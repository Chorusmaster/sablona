<?php
include "classes/Menu.php";
$menuManager = new Menu();
?>

<body>
<header class="container main-header">
    <div class="logo-holder">
        <a href="<?php echo (isset($menuManager->getMenuData("header")['home']['path'])) ?
            $menuManager->getMenuData("header")['home']['path'] : ''; ?>">
            <img src="img/logo.png" height="40">
        </a>
    </div>
    <nav class="main-nav">
        <ul class="main-menu" id="main-menu container">
            <li><a href=<?php echo (array_key_exists("theme", $_GET) && $_GET["theme"] === "dark") ? "?theme=light" : "?theme=dark";
                //pracujeme priamo z _GET, preto potrebujeme overiť, či kľúč existuje
                ?>>Zmena témy</a></li>

                <?php
                    if ($menuManager->isValidMenuType("header")) {
                        $menuData = $menuManager->getMenuData("header");
                        $menuManager->printMenu($menuData);
                    } else {
                        echo "Neplatný typ menu";
                    }
                ?>
        </ul>
        <a class="hamburger" id="hamburger">
            <i class="fa fa-bars"></i>
        </a>
    </nav>
</header>
