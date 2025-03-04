document.addEventListener("DOMContentLoaded", function () {
    const registerForm = document.getElementById("registerForm");
    const errorPopup = document.getElementById("ErrorPopup"); // Попап ошибки
    const errorMessage = errorPopup.querySelector("p"); // Сообщение ошибки
    const closeErrorPopup = document.getElementById("closeErrorPopup"); // Кнопка закрытия (исправлено!)



    registerForm.addEventListener("submit", async function (event) {
        event.preventDefault(); // Отменяем стандартную отправку формы

        // Получаем значения логина и пароля
        const login = document.getElementById("login").value;
        const password = document.getElementById("password").value;

        // Отправляем данные на сервер в формате JSON
        try {
            const response = await fetch("../api/register.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ login, password }),
            });

            const result = await response.json(); // Разбираем ответ в JSON
            console.log(result);

            //alert(result.message); // Показываем сообщение пользователю

            if (result.status === "success") {
                // Если регистрация успешна, перенаправляем на страницу профиля
                window.location.href = "../php/rooms.php";
            }
            if (result.status === "error") {
                errorMessage.textContent = result.message;
                errorPopup.style.display = "flex";
                //alert(result.message);
            }
            
        } catch (error) {
            console.error("Ошибка при отправке данных:", error);
            //alert("Произошла ошибка, попробуйте снова.");
            //alert(result.message);
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
