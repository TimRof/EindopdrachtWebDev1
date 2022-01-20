<?php

require __DIR__ . '/../dbconfig.php';

try {
    $connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

try {
    $sql = file_get_contents(__DIR__ . '/../../appointment_manager.sql');
    $qr = $connection->exec($sql);
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}
