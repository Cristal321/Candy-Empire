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

// Проверяем, пришли ли room_id, thief_card_id и target_card_id в POST-запросе
if (!isset($_POST['room_id']) || !isset($_POST['thief_card_id']) || !isset($_POST['target_card_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Отсутствуют обязательные параметры'
    ]);
    exit;
}

$room_id = (int)$_POST['room_id'];
$thief_card_id = (int)$_POST['thief_card_id'];
$target_card_id = (int)$_POST['target_card_id'];

try {
    // Вызываем SQL-функцию candy_thief
    $stmt = $pdo->prepare('SELECT * FROM candy_thief(:token, :room_id, :thief_card_id, :target_card_id)');
    $stmt->execute([
        'token' => $token,
        'room_id' => $room_id,
        'thief_card_id' => $thief_card_id,
        'target_card_id' => $target_card_id
    ]);

    // Получаем результат из SQL-функции
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Отправляем JSON-ответ
    echo json_encode($result);

} catch (Exception $e) {
    // Обработка ошибок выполнения запроса
    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка выполнения запроса: ' . $e->getMessage()
    ]);
}
?>
