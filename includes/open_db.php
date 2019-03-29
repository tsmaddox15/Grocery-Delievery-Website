<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'maddox';
    
    try {
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo $error_message;
        exit();
    }
?>