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

// Проверяем, пришли ли room_id и card_id в POST-запросе
if (!isset($_POST['room_id']) || !isset($_POST['card_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Отсутствуют обязательные параметры'
    ]);
    exit;
}

$room_id = (int)$_POST['room_id'];
$card_id = (int)$_POST['card_id'];

// Вызываем SQL-функцию discard_card
$stmt = $pdo->prepare('SELECT s335198.discard_card(:token, :room_id, :card_id)');
$stmt->execute([
    'token' => $token,
    'room_id' => $room_id,
    'card_id' => $card_id
]);

// Получаем результат из SQL-функции
$result = $stmt->fetchColumn();
$response = json_decode($result, true);

// Отправляем JSON-ответ
echo json_encode($response);
?>
