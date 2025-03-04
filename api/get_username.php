<?php
session_start();  // Начинаем сессию

header('Content-Type: application/json'); // Указываем, что ответ в JSON

include 'db_connect.php';  // Подключаем БД

// Проверяем, есть ли токен в сессии
if (!isset($_SESSION['token'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Вы уже вышли или не авторизованы'
    ]);
    exit;
}

$token = $_SESSION['token']; // Получаем токен из сессии

// Подготовка SQL-запроса для получения логина по токену
$stmt = $pdo->prepare('SELECT login_user FROM Tokens WHERE token = :token');
$stmt->execute(['token' => $token]);

// Получаем результат
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    // Если токен найден, возвращаем логин
    echo json_encode([
        'status' => 'success',
        'login' => $result['login_user']
    ]);
} else {
    // Если токен не найден, возвращаем ошибку
    echo json_encode([
        'status' => 'error',
        'message' => 'Токен не найден или недействителен'
    ]);
}
?>
