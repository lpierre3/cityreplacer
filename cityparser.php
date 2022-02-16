<?php

include 'inc/classes/DatabaseHandler.php';
include 'inc/classes/Database.php';
include 'inc/classes/DatabaseParser.php';
//use CityParser\Database;
//use CityParser\DatabaseParser;

//connect to database
//get all rows n database
/*
 * foreach row in database table
 *   parse title
 *   parse description
 *   update database table row
 */

try {
    $allCities = parse_ini_file('config/cities.ini');
    $parser = new DatabaseParser();
    $database = new Database('config/dbconfig.ini');
    $sqlQuery = 'select * from offers';
    $allRows = $database->getRows($sqlQuery);
    if (isset($allRows)) {
        foreach ($allRows as $row) {
            $title = $parser->parse($allCities['city'],$row['title']);
            $description = $parser->parse($allCities['city'],$row['description']);

            if ((strcmp($title, $row['title']) !== 0) || (strcmp($description, $row['description'] !==0))) {

                echo 'updating row='.$row['id'].'<br/>';

                echo 'title before= '.$row['title'].'<br/>';
                echo 'title after= '.$title.'<br/>';

                echo 'description before = '.$row['description'].'<br/><br/>';
                echo 'description after= '.$description.'<br/><br/>';

                $row['title'] = $title;
                $row['description'] = $description;
                $database->updateRow($row);
            }
        }
    }
} catch (Exception $e) {

}