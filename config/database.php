<?php
// Database configuration
$host = 'localhost';
$db   = 'promptdb';
$user = 'promptuser';
$pass = 'promptpass';
$base_url = 'http://localhost'; // Change to your domain

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('DB Connection failed: ' . $e->getMessage());
}
?>
