<?php
session_start();  // Запускаем сессию для хранения данных пользователя

header('Content-Type: application/json'); // Указываем, что ответ JSON

include 'db_connect.php';  // Подключаем файл с настройками подключения к БД

// Проверяем, есть ли токен в сессии
$userToken = $_SESSION['token'] ?? null;

// Читаем JSON-запрос из тела
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Получаем ID комнаты
$roomId = $data['room_id'] ?? null;

// Проверяем, что токен и ID комнаты не пустые
if (empty($userToken) || empty($roomId)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Отсутствует токен пользователя или ID комнаты'
    ]);
    exit;
}

// Подготавливаем SQL-запрос к функции join_game_room()
$stmt = $pdo->prepare('SELECT join_game_room(:user_token, :room_id) AS result');

// Выполняем запрос, передавая токен и ID комнаты
$stmt->execute(['user_token' => $userToken, 'room_id' => $roomId]);

// Получаем результат выполнения SQL-функции
$result = $stmt->fetchColumn();

// Декодируем JSON, который вернула SQL-функция
$response = json_decode($result, true);

// Если успешно или уже в комнате, добавляем URL для редиректа
if ($response['status'] === 'success' || $response['message'] === 'You are already in this room') {
    $response['redirect_url'] = "./game.php?room=" . urlencode($roomId);
}

// Отправляем ответ в формате JSON
echo json_encode($response);
?>
