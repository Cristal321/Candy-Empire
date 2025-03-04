<?php
session_start();  // Запускаем сессию для хранения данных пользователя

header('Content-Type: application/json'); // Указываем, что ответ JSON

include 'db_connect.php';  // Подключаем файл с настройками подключения к БД

// Читаем JSON-запрос из тела
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Дебаг: посмотреть, что приходит в $data
//file_put_contents("debug_log.txt", print_r($data, true)); // Отключено после отладки

// Получаем логин и пароль
$login = $data['login'] ?? null;
$password = $data['password'] ?? null;

// Проверяем, что логин и пароль не пустые
if (empty($login) || empty($password)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Введите логин и пароль'
    ]);
    exit;
}

// Подготавливаем SQL-запрос к функции register_user(), которая создаёт пользователя и выдаёт токен
$stmt = $pdo->prepare('SELECT register_user(:login, :password)');

// Выполняем запрос, передавая логин и пароль
$stmt->execute(['login' => $login, 'password' => $password]);

// Получаем результат выполнения SQL-функции
$result = $stmt->fetchColumn();

// Декодируем JSON, который вернула наша SQL-функция
$response = json_decode($result, true);

// Проверяем статус ответа от БД
if ($response['status'] === 'success') {
    $_SESSION['token'] = $response['token'];  // Сохраняем токен в сессии
    $_SESSION['user'] = ['login' => $login];  // Запоминаем логин пользователя в сессии

    // Отправляем успешный ответ в формате JSON
    echo json_encode([
        'status' => 'success',
        'token' => $response['token'],
        'message' => 'Регистрация успешна'
    ]);
} else {
    // Если ошибка, возвращаем её в JSON
    echo json_encode([
        'status' => 'error',
        'message' => $response['message']
    ]);
}
?>
