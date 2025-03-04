<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="../css/register.css">
    <link rel="icon" href="../images/icon.webp">

</head>
<body>
    <div class="parent-container">
        <div class="cat">
            <img src="../images/cat.png">
        </div>
        <div class="child-container">
            <h2>Вход</h2>
            <form action="#" method="POST">
                <!-- Поле логин с placeholder -->
                <input type="text" id="login" name="login" placeholder="логин" required><br><br>
                
                <!-- Поле пароль с placeholder -->
                <input type="password" id="password" name="password" placeholder="пароль" required>
                <a style="margin-left: 0; text-decoration: none;color:rgba(116, 139, 67, 0.68);font-family: 'Tilda', sans-serif;font-size: 1em; text-align: left;" href="changePassword.php">cменить пароль?</a>
                
                <!-- Кнопка продолжить -->
                <button style="margin-top: 50px;" type="submit">Продолжить</button>

                <p> У вас ещё нет аккаунта? <br><a style= " text-decoration: none; color: #748B43;" href="register.php"><b>Присоединяйтесь </b></a> к нам!</p>
            </form>
        </div>

        
    </div>

    <!-- Сообщение для маленьких экранов -->
    <div class="message-small-screen">
        Ваш экран слишком маленький
    </div>

    <script src="../scripts/auth.js"></script>

    <div class="error-popup" id="ErrorPopup">
    <div class="error-content">
        <span class="error-close" id="closeErrorPopup">&times;</span> <!-- Исправлен id -->
        <p></p>
    </div>
</div>

    
   
    
   
</body>
</html>