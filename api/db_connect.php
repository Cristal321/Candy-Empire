<?php

$host = 'pg';  // Или 'localhost', если база работает локально
$db = 'studs';
$db_user = 's335198';  // Новый пользователь
$db_password = 'cHEGiA2OlOuGbqBo';  // Новый пароль

$dsn = "pgsql:host=$host;port=5432;dbname=$db;";

try {
    $pdo = new PDO($dsn, $db_user, $db_password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
    // УДАЛЯЕМ: echo "Подключение успешно!";
} catch (PDOException $e) {
    die(json_encode(["status" => "error", "message" => "Ошибка подключения к базе данных: " . $e->getMessage()]));
}

?>
