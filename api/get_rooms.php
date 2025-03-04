<?php
session_start();  // Запускаем сессию
//print_r($_SESSION);

header('Content-Type: application/json');  // Указываем, что ответ будет в формате JSON

include 'db_connect.php';  // Подключаем БД

// Получаем токен из запроса (из заголовков или тела)
$input = file_get_contents("php://input");
$data = json_decode($input, true);
$token = $data['token'] ?? $_SESSION['token'] ?? null; // Берем из запроса или из сессии

// Проверяем, передан ли токен
if (empty($token)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Токен не передан'
    ]);
    exit;
}

try {
    // Подготавливаем SQL-запрос к нашей функции get_available_rooms()
    $stmt = $pdo->prepare("SELECT get_available_rooms(:token)");

    // Выполняем запрос, передавая токен
    $stmt->execute(['token' => $token]);

    // Получаем JSON-результат из SQL-функции
    $result = $stmt->fetchColumn();

    // Преобразуем строку в JSON
    $rooms = json_decode($result, true);

    // Если вдруг ошибка в JSON, возвращаем пустой массив
    if ($rooms === null) {
        $rooms = [];
    }

    // Отправляем ответ клиенту
    echo json_encode([
        'status' => 'success',
        'rooms' => $rooms
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка ' . $e->getMessage()
    ]);
}
?>
