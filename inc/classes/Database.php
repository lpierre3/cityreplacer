<?php

//namespace CityParser;

class Database extends DatabaseHandler
{
    private $pdo;
    private $dbTable;

    function __construct(string $configFile) {
        $this->connect($configFile);
    }

    public function connect(string $configFile) {
        $dbParams = parse_ini_file($configFile);
        try {
            $this->pdo = new PDO('mysql:host=' . $dbParams['host'] . ';port=' . $dbParams['port'] . ';dbname=' . $dbParams['name'] . ';charset=utf8', $dbParams['user'], $dbParams['pass']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->dbTable = $dbParams['dbtable'];
        } catch (PDOException $e) {
            echo 'Exception: ' . $e->getMessage();
        }
    }

    public function getRows(string $sqlQuery) {
        $rows = array();
        $stmt = null;

        try {
            $stmt = $this->pdo->prepare($sqlQuery);
            if ($stmt->execute()) {
                if ((isset($stmt) && ($stmt->rowCount() > 0))) {
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
        } catch (PDOException $e) {
            echo 'Exception: ' . $e->getMessage();
        }
        return $rows;
    }

    public function updateRow($row) {
        try {
            $stmt = $this->pdo->prepare("update $this->dbTable set title:=title, description=:description WHERE id=:id");
            $stmt->bindValue(':title', $row['title']);
            $stmt->bindValue(':description', $row['description']);
            $stmt->bindValue(':id', $row['id']);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Exception: ' . $e->getMessage();
        }
    }
}

