document.addEventListener("DOMContentLoaded", function () {
    const authForm = document.querySelector("form"); // Находим форму
    const errorPopup = document.getElementById("ErrorPopup"); // Попап ошибки
    const errorMessage = errorPopup.querySelector("p"); // Сообщение ошибки
    const closeErrorPopup = document.getElementById("closeErrorPopup"); // Кнопка закрытия (исправлено!)


    authForm.addEventListener("submit", async function (event) {
        event.preventDefault(); // Отменяем стандартную отправку формы

        // Получаем значения логина и пароля
        const login = document.getElementById("login").value.trim();
        const password = document.getElementById("password").value.trim();

        // Проверяем, что поля не пустые
        if (!login || !password) {
            alert("Введите логин и пароль");
            return;
        }

        try {
            // Отправляем запрос на сервер
            const response = await fetch("../api/auth_user.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ login, password }),
            });

            // Проверяем, корректный ли JSON приходит
            const result = await response.json();
            console.log(result); // Логируем ответ сервера для отладки

            //alert(result.message); // Показываем сообщение пользователю

            if (result.status === "success") {
                // Если авторизация успешна, перенаправляем в комнату
                window.location.href = "../php/rooms.php";
            }
            if (result.status === "error") {
                console.log("увидел, что статус неправильный")
                //alert(result.message);
                // Отображаем попап и вставляем сообщение
                errorMessage.textContent = result.message;
                errorPopup.style.display = "flex";
            }

        } catch (error) {
            console.error("Ошибка при отправке данных:", error);
            alert(result.message);
        }
    });

    closeErrorPopup.addEventListener("click", function () {
        errorPopup.style.display = "none";
    });
    
    window.addEventListener("click", function (event) {
        if (event.target === errorPopup) {
            errorPopup.style.display = "none";
        }
    });
});
