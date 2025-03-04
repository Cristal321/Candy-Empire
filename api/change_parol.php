<?php
header('Content-Type: application/json'); // Указываем, что ответ будет в формате JSON

include 'db_connect.php';  // Подключаемся к базе данных

// Получаем данные из запроса
$login = $_POST['login'] ?? '';
$old_password = $_POST['old_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';

// Проверяем, что все поля заполнены
if (empty($login) || empty($old_password) || empty($new_password)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Необходимо указать логин, старый пароль и новый пароль'
    ]);
    exit;
}

try {
    // Вызываем SQL-функцию change_password
    $stmt = $pdo->prepare('SELECT change_password(:login, :old_password, :new_password)');
    $stmt->execute([
        'login' => $login,
        'old_password' => $old_password,
        'new_password' => $new_password
    ]);

    // Получаем результат функции
    $result = $stmt->fetchColumn();
    $response = json_decode($result, true);

    // Возвращаем ответ в формате JSON
    echo json_encode($response);

} catch (PDOException $e) {
    // В случае ошибки возвращаем сообщение
    echo json_encode([
        'status' => 'error',
        'message' => 'Произошла ошибка при смене пароля'
    ]);
}
?>
