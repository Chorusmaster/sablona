<?php
function pridajPozdrav()
{
    $hour = date('H');
    if ($hour < 12) {
        echo "<h3>Dobré ráno</h3>";
    } elseif ($hour < 18) {
        echo "<h3>Dobrý deň</h3>";
    } else {
        echo "<h3>Dobrý večer</h3>";
    }
}

function generateSlides($dir) {
    $files = glob($dir . "/*.jpg");
    $json = file_get_contents("data/datas.json");
    $data = json_decode($json, true);
    $text = $data["text_banner"];

    foreach ($files as $file) {
        echo '<div class="slide fade">';
        echo '<img src="' . $file . '">';
        echo '<div class="slide-text">';
        echo ($text[basename($file)]);
        echo '</div>';
        echo '</div>';
    }
}

function insertQnA(){
    $json = file_get_contents("data/datas.json");
    $data = json_decode($json, true);
    $otazky = $data["otazky"];
    $odpovede = $data["odpovede"];
    echo '<section class="container">';
    for ($i = 0; $i < count($otazky); $i++) {
        echo '<div class="accordion">                    
        <div class="question">'.
            $otazky[$i].'                     
        </div>                    
        <div class="answer">'.
            $odpovede[$i].'                    
        </div>            
        </div>';
    }
    echo '</section>';
}

function insertPortfolio(int $cols = 4, int $rows = 2) {
    $json = file_get_contents("data/datas.json");
    $data = json_decode($json, true);
    $data = $data["portfolio"];
    $index = 0;

    for ($i = 0; $i < $rows; $i++) {
        echo '<div class="row">';
        for ($j = 0; $j < $cols; $j++) {
            echo '<a href="' . $data[$index][2] .'" class="col-25 portfolio text-white text-center" id=' . $data[$index][1] . '>
            ' . $data[$index][0] . '
        </a>';
        $index++;
        }
        echo '</div>';
    }
}

function getCSS(){
    $jsonStr = file_get_contents("data/datas.json");
    $data = json_decode($jsonStr, true);
    $stranka = basename($_SERVER['REQUEST_URI'], ".php");
    if ($stranka == "sablona") $stranka = "index";

    $suboryCSS = $data['stranky'][$stranka];
    foreach ($suboryCSS as $subor) {
        echo "<link rel='stylesheet' href='$subor'>";
    }
}


function validateMenuType(string $type) : bool
{
    $menuTypes = [
        'header',
        'footer'
    ];
    if (in_array($type, $menuTypes)) {
        return true;
    } else {
        return false;
    }
}

function getMenuData(string $type) : array
{
    $menu = [];
    if (validateMenuType($type)) {
        if ($type == "header") {
            $menu = [
                'home' => [
                    'name' => 'Domov',
                    'path' => 'index.php',
                ],
                'portfolio' => [
                    'name' => 'Portfólio',
                    'path' => 'portfolio.php',
                ],
                'qna' => [
                    'name' => 'Q&A',
                    'path' => 'qna.php',
                ],
                'kontakt' => [
                    'name' => 'Kontakt',
                    'path' => 'kontakt.php',
                ],
            ];
        }
    }
    return $menu;
}

function printMenu(array $menu){
    foreach($menu as $menuName => $menuData) {
        echo '<li><a href="' . $menuData['path'] . '">' . $menuData['name'] . '</a></li>';
    }
}
?>