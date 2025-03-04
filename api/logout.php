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

// Вызываем SQL-функцию для удаления токена
$stmt = $pdo->prepare('SELECT logout_user(:token)');
$stmt->execute(['token' => $token]);

// Получаем результат из SQL-функции
$result = $stmt->fetchColumn();
$response = json_decode($result, true);

// Если выход успешен, удаляем данные сессии
if ($response['status'] === 'success') {
    session_unset(); // Очищаем сессию
    session_destroy(); // Уничтожаем сессию
}

// Отправляем JSON-ответ
echo json_encode($response);
?>
