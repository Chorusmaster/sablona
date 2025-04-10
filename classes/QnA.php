<?php

namespace otazkyodpovede;
error_reporting(E_ALL);
ini_set('display_errors', "On");
define('__LOCAL_ROOT__', dirname(__FILE__, 2));
require_once(__LOCAL_ROOT__.'/db/config.php');
require_once(__LOCAL_ROOT__.'/classes/Database.php');

use Database;
use PDO;
use PDOException;

class QnA extends Database{
    protected $connection;

    public function __construct() {
        $this->connect();
        $this->connection = $this->getConnection();
    }

    public function getQnA(){

        try {
            //získame dáta z databázy
            $sql = "SELECT otazka, odpoved FROM qna";
            $statement = $this->connection->prepare($sql);
            $statement->execute();

            // vkladáme získane dáta sem
            $qna_data = $statement->fetchAll();

            // vrácame získaný array
            return $qna_data;

        } catch (PDOException $e) {
            echo "Chyba pri čítaní dát z databázy: " . $e->getMessage();

            return null;

        }
    }

    public function showQnA() {
        //získame array s dátami
        $qna_data = $this->getQnA();

        //ak bolo niečo s databázy získané, vypíšeme to
        if (!is_null($qna_data)) {
            echo '<section class="container">';
            for ($i = 0; $i < count($qna_data); $i++) {
                echo '<div class="accordion">                    
                <div class="question">' .
                    $qna_data[$i]["otazka"] . '                     
                </div>                    
                <div class="answer">' .
                    $qna_data[$i]["odpoved"] . '                    
                </div>            
                </div>';
            }
            echo '</section>';

        } else {
            echo "Načítať dáta sa nepodarilo";
        }
    }

    public function insertQnA(){

        $qna_data = $this->getQnA();

        try {
            $data = json_decode(file_get_contents
            (__ROOT__.'/data/datas.json'), true);
            $otazky = $data["otazky"];
            $odpovede = $data["odpovede"];

            $this->connection->beginTransaction();

            $sql = "INSERT INTO qna (otazka, odpoved) VALUES (:otazka, :odpoved)";
            $statement = $this->connection->prepare($sql);

            for ($i = 0; $i < count($otazky); $i++) {

                //či je otázka unikátna
                $isDifferent = true;

                //overujeme, čí kľúč existuje aby sme predišli chýbam, spojeným s rôzným počtom záznamov v json a databáze
                if (array_key_exists($i, $qna_data)) {
                    for ($j = 0; $j < count($qna_data); $j++) {
                        if ($otazky[$i] == $qna_data[$j]["otazka"] && $odpovede[$i] == $qna_data[$j]["odpoved"]) {
                            //ak program nášiel zhodné údaje, označí otázku v tomto opakovani vonkajšieho cyklu ako neunikátnu
                            $isDifferent = false;
                        }
                    }
                }

                //ak je otázka unikátna, resp. ešte nie je v databáze
                if ($isDifferent) {
                    $statement->bindParam(':otazka', $otazky[$i]);
                    $statement->bindParam(':odpoved', $odpovede[$i]);
                    $statement->execute();
                }
            }
            $this->connection->commit();

        } catch (PDOException $e) {
            echo "Chyba pri vkladaní dát do databázy: " . $e->getMessage();
            $this->connection->rollback();

        }
    }

    public function resetQnA()
    { //Pomocna funkcia pre testovanie - mázanie všetkých údajov

        try {
            $sql = "DELETE FROM qna"; //Zmazať všetko z tabuľky
            $statement1 = $this->conn->prepare($sql);
            $sql = "ALTER TABLE qna AUTO_INCREMENT = 1"; //Nastaviť auto-increment na hodnotu 1, resp. resetovať ho
            $statement2 = $this->conn->prepare($sql);
            $statement1->execute();
            $statement2->execute();

            echo "dáta boli úspešne zmazané z tabuľky";

        } catch (PDOException $e) {
            echo "Chyba pri mazaní dát v databáze: " . $e->getMessage();

        }
    }
}


