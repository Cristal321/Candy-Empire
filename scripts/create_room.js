document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("createRoom").addEventListener("submit", async function (event) {
        event.preventDefault(); // Останавливаем стандартную отправку формы

        const seats = document.getElementById("colvo").value;
        const time = document.getElementById("time").value;

        try {
            // Отправляем запрос на создание комнаты, токен берётся из сессии (credentials: "include")
            const response = await fetch("../api/create_room.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                credentials: "include", // Передаем куки сессии
                body: JSON.stringify({
                    seats: seats,
                    time: time
                })
            });

            const result = await response.json();

            if (result.status === "success") {
                window.location.reload(); // Перезагружаем страницу для обновления списка комнат
            } else {
                alert("Ошибка: " + result.message);
            }
        } catch (error) {
            console.error("Ошибка запроса:", error);
            alert("Произошла ошибка при создании комнаты.");
        }
    });
});
