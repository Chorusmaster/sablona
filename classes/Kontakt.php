<?php

namespace formular;
use Database;

error_reporting(E_ALL);
ini_set('display_errors', "On");
define('__LOCAL_ROOT__', dirname(__FILE__, 2));
require_once(__LOCAL_ROOT__.'/classes/Database.php');

class Kontakt extends Database
{
    protected $connection;

    public function __construct()
    {
        $this->connect();
        $this->connection = $this->getConnection();
    }

    public function ulozitSpravu($meno, $email, $sprava) {
        $sql = "INSERT INTO kontakt_formular (meno, email, sprava) 
        VALUE ('" . $meno . "', '" . $email . "', '" . $sprava . "')";
        $statement = $this->connection->prepare($sql);
        try {
            $insert = $statement->execute();
            header("Location: http://localhost/cvicnasablona/thankyou.php");
            http_response_code(200);
            return $insert;
        } catch (\Exception $exception) {
            return http_response_code(404);
        }
    }
    public function __destruct() {
        $this->connection = null;
    }
}