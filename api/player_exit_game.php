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

if (!isset($_POST['room_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Не указан ID комнаты'
    ]);
    exit;
}

$token = $_SESSION['token']; // Получаем токен из сессии
$room_id = (int) $_POST['room_id']; // Получаем ID комнаты и приводим к целому числу

try {
    // Вызываем SQL-функцию для выхода из игры
    $stmt = $pdo->prepare('SELECT player_exit_game(:token, :room_id)');
    $stmt->execute([
        'token' => $token,
        'room_id' => $room_id
    ]);

    // Получаем результат из SQL-функции
    $result = $stmt->fetchColumn();
    $response = json_decode($result, true);

    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка сервера: ' . $e->getMessage()
    ]);
}
?>
