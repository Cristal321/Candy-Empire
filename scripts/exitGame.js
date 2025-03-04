document.addEventListener("DOMContentLoaded", () => {
    const exitGameButton = document.getElementById("exit_game");
    const exitPopup = document.getElementById("exitPopup");
    const closeExitPopup = document.getElementById("closeExitPopup");
    const confirmExit = document.getElementById("confirmExit");
    const cancelExit = document.getElementById("cancelExit");

    // Получаем roomId из URL
    const roomId = new URLSearchParams(window.location.search).get("room");
    if (!roomId) {
        console.error("Room ID not found");
        return;
    }

    // Открыть поп-ап при нажатии на кнопку выхода
    exitGameButton.addEventListener("click", () => {
        exitPopup.style.display = "flex";
    });

    // Закрыть поп-ап при нажатии на крестик или кнопку "Нет"
    closeExitPopup.addEventListener("click", () => {
        exitPopup.style.display = "none";
    });

    cancelExit.addEventListener("click", () => {
        exitPopup.style.display = "none";
    });

    // Вызвать API и выйти из игры при нажатии на кнопку "Да"
    confirmExit.addEventListener("click", async () => {
        try {
            const response = await fetch("../api/player_exit_game.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `room_id=${encodeURIComponent(roomId)}`,
                credentials: "include"
            });

            const data = await response.json();
            if (data.status === "success") {
                alert("Вы успешно покинули игру");
                window.location.href = "../php/rooms.php";
            } else {
                console.error("Ошибка при выходе из игры:", data.message);
            }
        } catch (error) {
            console.error("Ошибка при выполнении запроса:", error);
        }
    });
});
