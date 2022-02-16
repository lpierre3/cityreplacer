<?php
//namespace CityParser;

abstract class DatabaseHandler
{

    abstract public function connect(string $configFile);
}