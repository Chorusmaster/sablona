<?php

namespace otazkyodpovede;
define('__ROOT__', dirname(__FILE__, 2));
require_once(__ROOT__.'/db/config.php');

use Exception;
use PDO;
use PDOException;

class QnA{
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $config = DATABASE;
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        );

        try {
            $this->conn = new PDO('mysql:host=' . $config['HOST'] . ';dbname=' .
                $config['DBNAME'] . ';port=' . $config['PORT'], $config['USER_NAME'],
                $config['PASSWORD'], $options);
        } catch (PDOException $e) {
            die("Chyba pripojenia: " . $e->getMessage());
        }
    }

    private function reconnect(){
        if (is_null($this->conn)) {
            $this->connect();
        }
    }

    public function getQnA(){

        $this->reconnect();

        try {
            $sql = "SELECT otazka, odpoved FROM qna";
            $statement = $this->conn->prepare($sql);
            $statement->execute();

            $qna_data = $statement->fetchAll();

            return $qna_data;

        } catch (PDOException $e) {
            echo "Chyba pri čítaní dát z databázy: " . $e->getMessage();

            return null;

        } finally {
            $this->conn = null;
        }
    }

    public function showQnA() {
        $qna_data = $this->getQnA();

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

        }
    }

    public function insertQnA(){

        $qna_data = $this->getQnA();
        $this->reconnect();

        try {
            $data = json_decode(file_get_contents
            (__ROOT__.'/data/datas.json'), true);
            $otazky = $data["otazky"];
            $odpovede = $data["odpovede"];

            $this->conn->beginTransaction();

            $sql = "INSERT INTO qna (otazka, odpoved) VALUES (:otazka, :odpoved)";
            $statement = $this->conn->prepare($sql);

            for ($i = 0; $i < count($otazky); $i++) {

                $isDifferent = true;

                if (array_key_exists($i, $qna_data)) {
                    for ($j = 0; $j < count($qna_data); $j++) {
                        if ($otazky[$i] == $qna_data[$j]["otazka"] && $odpovede[$i] == $qna_data[$j]["odpoved"]) {
                            $isDifferent = false;
                        }
                    }
                }

                if ($isDifferent) {
                    $statement->bindParam(':otazka', $otazky[$i]);
                    $statement->bindParam(':odpoved', $odpovede[$i]);
                    $statement->execute();
                }
            }
            $this->conn->commit();

        } catch (PDOException $e) {
            echo "Chyba pri vkladaní dát do databázy: " . $e->getMessage();
            $this->conn->rollback();

        } finally {
            $this->conn = null;
        }
    }

    public function resetQnA(){

        $this->reconnect();

        try {
            $sql = "DELETE FROM qna";
            $statement1 = $this->conn->prepare($sql);
            $sql = "ALTER TABLE qna AUTO_INCREMENT = 1";
            $statement2 = $this->conn->prepare($sql);
            $statement1->execute();
            $statement2->execute();

            echo "dáta boli úspešne zmazané z tabuľky";

        } catch (PDOException $e) {
            echo "Chyba pri mazaní dát v databáze: " . $e->getMessage();

        } finally {
            $this->conn = null;
        }
    }
}


