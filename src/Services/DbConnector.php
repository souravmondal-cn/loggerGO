<?php

namespace Services;

use mysqli;

class DbConnector {

    const DB_NAME = DB_NAME;
    const DB_HOST = DB_HOST;
    const DB_USER = DB_USER;
    const DB_PASSWORD = DB_PASSWORD;

    public function connect() {
        return  new mysqli(self::DB_HOST, self::DB_USER, self::DB_PASSWORD, self::DB_NAME);
        if ($mysqli_connector->connect_error) {
            die('Error : (' . $mysqli_connector->connect_errno . ') ' . $mysqli_connector->connect_error);
        }
        return $mysqli_connector;
    }

}
