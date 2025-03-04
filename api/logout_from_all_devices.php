<?php
session_start();  // Начинаем сессию

header('Content-Type: application/json'); // Ответ в формате JSON

include 'db_connect.php';  // Подключаем базу данных

// Проверяем, есть ли токен в сессии
if (!isset($_SESSION['token'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Вы уже вышли или не авторизованы'
    ]);
    exit;
}

$token = $_SESSION['token']; // Получаем токен из сессии

try {
    // Вызываем SQL-функцию для выхода со всех устройств
    $stmt = $pdo->prepare('SELECT logout_from_all_devices(:token)');
    $stmt->execute(['token' => $token]);

    // Получаем результат из SQL-функции
    $result = $stmt->fetchColumn();
    $response = json_decode($result, true);

    // Если выход успешен, очищаем сессию
    if ($response['status'] === 'success') {
        session_unset(); // Очищаем сессию
        session_destroy(); // Уничтожаем сессию
    }

    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка сервера: ' . $e->getMessage()
    ]);
}
?>
