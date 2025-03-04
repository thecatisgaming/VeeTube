<?php
$host = 'localhost';
$dbname = 'nloaxapx_veetube2';
$db_username = 'nloaxapx_nload';
$password = 'nload.rf.gd1';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
