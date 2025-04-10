<?php
class Menu
{
    private array $validateMenuTypes = ["header", "footer"];
    public function isValidMenuType(string $type) : bool
    {
        return in_array($type, $this -> validateMenuTypes);
    }

    public function printMenu(array $menu): void{
        foreach($menu as $menuName => $menuData) {
            echo '<li><a href="' . $menuData['path'] . (array_key_exists("theme", $_GET) ? "?theme=" . $_GET["theme"] : "?theme=light") . '">' . $menuData['name'] . '</a></li>';
        }
    }

    public function getMenuData(string $type) : array
    {
        $menu = [];
        if (!$this->isValidMenuType($type)) {
            throw new InvalidArgumentException("Invalid menu type: $type");
        }
        $menuData = [
            'header' => [
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
            ]
        ];
        return $menuData[$type];
    }
}