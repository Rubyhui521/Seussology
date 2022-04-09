<?php
    // make the connection to the database
    $dsn = 'mysql:host=localhost;dbname=seussology';
    $user = 'root';
    $pass = 'root';

    // try-catch block
    try {
        // PDO instence
        $db = new PDO($dsn, $user, $pass);
    } catch (PDOException $e) {
        // $e stands for error
        echo 'Database connection unsuccessful';
        die();
    }



