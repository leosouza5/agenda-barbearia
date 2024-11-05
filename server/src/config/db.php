<?php
$host = '192.168.0.202';
$port = '5434';
$db = 'agenda';
$user = 'agenda';
$pass = '123';


try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
