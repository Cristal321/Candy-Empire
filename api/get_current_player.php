<?php
session_start();  // Начинаем сессию

header('Content-Type: application/json'); // Указываем, что ответ будет в JSON

include 'db_connect.php';  // Подключаем БД

// Проверяем, передан ли room_id через GET или POST
if (!isset($_GET['room_id']) && !isset($_POST['room_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Не указан ID комнаты'
    ]);
    exit;
}

$room_id = $_GET['room_id'] ?? $_POST['room_id']; // Получаем room_id

try {
    // Вызываем SQL-функцию для получения текущего игрока
    $stmt = $pdo->prepare('SELECT get_current_player(:room_id)');
    $stmt->execute(['room_id' => $room_id]);

    // Получаем JSON-ответ из SQL-функции
    $result = $stmt->fetchColumn();
    $response = json_decode($result, true);

    // Отправляем JSON-ответ клиенту
    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка запроса к БД: ' . $e->getMessage()
    ]);
}
?>
