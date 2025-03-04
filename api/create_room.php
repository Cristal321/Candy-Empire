<?php
session_start(); // Запускаем сессию
header('Content-Type: application/json'); // Указываем формат JSON

include 'db_connect.php'; // Подключаем БД

// Получаем данные из запроса
$input = file_get_contents("php://input");
$data = json_decode($input, true);

$token = $data['token'] ?? $_SESSION['token'] ?? null;
$seats = $data['seats'] ?? null;
$time = $data['time'] ?? null;

// Проверяем, переданы ли все параметры
if (empty($token) || empty($seats) || empty($time)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Не все данные переданы'
    ]);
    exit;
}

try {
    // Подготавливаем SQL-запрос к нашей функции create_game_room()
    $stmt = $pdo->prepare("SELECT create_game_room(:token, :seats, :time)");

    // Выполняем запрос с параметрами
    $stmt->execute([
        'token' => $token,
        'seats' => (int) $seats,
        'time' => (int) $time
    ]);

    // Получаем JSON-результат из SQL-функции
    $result = $stmt->fetchColumn();

    // Преобразуем строку в JSON
    $roomData = json_decode($result, true);

    if ($roomData === null) {
        $roomData = [];
    }

    // Отправляем ответ клиенту
    echo json_encode([
        'status' => 'success',
        'room' => $roomData
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка ' . $e->getMessage()
    ]);
}
?>
