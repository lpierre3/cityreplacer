<?php

include 'inc/classes/DatabaseHandler.php';
include 'inc/classes/Database.php';
include 'inc/classes/DatabaseParser.php';

try {
    $allCities = parse_ini_file('config/cities.ini');
    $parser = new DatabaseParser();
    $database = new Database('config/dbconfig.ini');
    $sqlQuery = 'select * from offers';
    $allRows = $database->getRows($sqlQuery);
    if (isset($allRows)) {
        foreach ($allRows as $row) {
            $title = $parser->parse($allCities['city'], $row['title']);
            $description = $parser->parse($allCities['city'], $row['description']);

            if ((strcmp($title, $row['title']) !== 0) || (strcmp($description, $row['description'] !== 0))) {
                $row['title'] = $title;
                $row['description'] = $description;
                $database->updateRow($row);
            }
        }
    }
} catch (Exception $e) {
    echo 'Exception: ' . $e->getMessage();
}