<?php
    $DB_HOST = 'localhost';
    $DB_USER = 'root';
    $DB_PASS = 'kali';
    $DB_NAME = 'socialapp';

    try{
        $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Could not connect to the database $DB_NAME :" . $e->getMessage());
    }
?>