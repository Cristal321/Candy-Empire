<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Смена пароля</title>
    <link rel="stylesheet" href="../css/register.css">
    <link rel="icon" href="../images/icon.webp">

</head>
<body>
    <div class="parent-container">
        <div class="cat">
            <img src="../images/cat.png">
        </div>
        <div class="child-container">
            <h2>Смена пароля</h2>
            <form action="#" method="POST" id="change-password-form">
                <!-- Поле логин с placeholder -->
                <input type="text" id="login" name="login" placeholder="логин" required><br><br>
                
                <!-- Поле пароль с placeholder -->
                <input type="password" id="password" name="password" placeholder="старый пароль" required><br><br>
                <!-- Поле пароль с placeholder -->
                <input type="password" id="newpassword" name="password" placeholder="новый пароль" required><br><br>
                
                <!-- Кнопка продолжить -->
                <button type="submit">Сменить</button>

                <p style ="margin-top:20px;"> Передумали? <br><a style= " text-decoration: none; color: #748B43;" href="authorization.php"><b>Возвращайтесь </b></a> на страницу входа!</p>
            </form>
        </div>

        
    </div>

    <!-- Сообщение для маленьких экранов -->
    <div class="message-small-screen">
        Ваш экран слишком маленький
    </div>

    <div class="error-popup" id="ErrorPopup">
    <div class="error-content">
        <span class="error-close" id="closeErrorPopup">&times;</span> <!-- Исправлен id -->
        <p></p>
    </div>
    </div>

    <script src="../scripts/change_password.js"></script>
</body>
</html>