<?php
session_start();  // Запускаем сессию для хранения токена пользователя

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

try {
    // Подготавливаем SQL-запрос к функции get_game_state()
    $stmt = $pdo->prepare('SELECT s335198.get_game_state(:user_token, :room_id) AS result');

    // Выполняем запрос, передавая токен и ID комнаты
    $stmt->execute(['user_token' => $userToken, 'room_id' => $roomId]);

    // Получаем результат выполнения SQL-функции
    $result = $stmt->fetchColumn();

    // Декодируем JSON, который вернула SQL-функция
    $response = json_decode($result, true);

    // Отправляем ответ в формате JSON
    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка базы данных: ' . $e->getMessage()
    ]);
}
?>
