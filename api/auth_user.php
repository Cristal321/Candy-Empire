<?php
session_start();  // Запускаем сессию для хранения данных пользователя

header('Content-Type: application/json'); // Указываем, что ответ будет в формате JSON

include 'db_connect.php';  // Подключаем файл с настройками БД

// Читаем JSON-запрос из тела
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Проверяем, корректно ли разобран JSON
if (!is_array($data)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка обработки данных'
    ]);
    exit;
}

// Получаем логин и пароль
$login = $data['login'] ?? null;
$password = $data['password'] ?? null;

// Проверяем, переданы ли логин и пароль
if (empty($login) || empty($password)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Введите логин и пароль'
    ]);
    exit;
}

// Подготавливаем SQL-запрос к функции auth_user(), которая проверяет пользователя и выдаёт токен
$stmt = $pdo->prepare('SELECT auth_user(:login, :password)');

// Выполняем запрос с переданными данными
$stmt->execute(['login' => $login, 'password' => $password]);

// Получаем результат из SQL-функции
$result = $stmt->fetchColumn();

// Декодируем JSON, который вернула наша SQL-функция
$response = json_decode($result, true);

// Проверяем, успешен ли вход
if ($response && $response['status'] === 'success') {
    $_SESSION['token'] = $response['token'];  // Сохраняем токен в сессии
    $_SESSION['user'] = ['login' => $login];  // Запоминаем логин пользователя в сессии

    // Отправляем JSON-ответ с токеном
    echo json_encode([
        'status' => 'success',
        'token' => $response['token'],
        'message' => 'Вход выполнен'
    ]);
} else {
    // Если ошибка, отправляем её в JSON
    echo json_encode([
        'status' => 'error',
        'message' => $response['message'] ?? 'Ошибка авторизации'
    ]);=
}
?>
