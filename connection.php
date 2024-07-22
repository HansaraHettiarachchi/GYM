<?php

class Database
{
    public static $connection;

    static function setUpConnection()
    {
        if (!isset(Database::$connection)) {
            Database::$connection = new mysqli("localhost", "root", "Hansara@2003", "gym", "3306");
            // Check connection
            if (Database::$connection->connect_error) {
                die("Connection failed: " . Database::$connection->connect_error);
            }
        }
    }

    public static function iudPrepared($query, $types, ...$params)
    {
        Database::setUpConnection();
        $stmt = Database::$connection->prepare($query);
        if ($stmt === false) {
            die("Prepare failed: " . Database::$connection->error);
        }
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute() === false) {
            die("Execute failed: " . $stmt->error);
        }
        
        $stmt->close();
    }
    public static function iudPreparedArray($query, $types, $params)
    {
        Database::setUpConnection();
        $stmt = Database::$connection->prepare($query);
        if ($stmt === false) {
            die("Prepare failed: " . Database::$connection->error);
        }
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute() === false) {
            die("Execute failed: " . $stmt->error);
        }
        
        $stmt->close();
    }

    public static function searchPrepared($query, $types, ...$params)
    {
        Database::setUpConnection();
        $stmt = Database::$connection->prepare($query);
        if ($stmt === false) {
            die("Prepare failed: " . Database::$connection->error);
        }
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute() === false) {
            die("Execute failed: " . $stmt->error);
        }
        $resultset = $stmt->get_result();
        $stmt->close();
        return $resultset;
    }

    public static function search($q)
    {
        Database::setUpConnection();
        $resultset = Database::$connection->query($q);
        return $resultset;
    }
}
?>