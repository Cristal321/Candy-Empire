async function loadRooms() {
    const roomsList = document.getElementById("dynamicRooms");

    await loadPlayerName();

    try {
        const response = await fetch("../api/get_rooms.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            credentials: "include"
        });

        const result = await response.json();
        console.log(result);

        if (result.status === "error") {
            if (result.message === 'Токен не передан') {
                window.location.href = "../php/authorization.php";
            } else {
                alert(result.message);
            }
            return;
        }

        roomsList.innerHTML = "";

        if (result.rooms.length === 0) {
            roomsList.innerHTML = "<p>Нет доступных комнат.</p>";
            return;
        }

        result.rooms.forEach(room => {
            const roomDiv = document.createElement("div");
            roomDiv.classList.add("room");

            roomDiv.innerHTML = `
                <div class="room-info">
                    <span class="numderRooms">№${room.id}</span>
                    <span class="numderPlayers">${room.game_status} </span>
                    <span class="numderTime">${room.time_move} секунд</span>
                    <button class="${room.is_joined ? "join-button-CONTINUE" : "join-button-START"}">
                        ${room.is_joined ? "продолжить" : "Войти"}
                    </button>
                </div>
            `;

            const button = roomDiv.querySelector("button");
            button.addEventListener("click", () => joinRoom(room.id));
            roomsList.appendChild(roomDiv);
        });
    } catch (error) {
        window.location.href = "../php/authorization.php";
        console.error("Ошибка при загрузке комнат:", error);
    }
}

// Запускаем при загрузке страницы и обновляем каждые 5 секунд
document.addEventListener("DOMContentLoaded", function () {
    loadRooms();
    setInterval(loadRooms, 5000);
});


// Функция для загрузки имени игрока
async function loadPlayerName() {
    try {
        const response = await fetch("../api/get_username.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            credentials: "include",
        });

        const result = await response.json();
        console.log(result);

        if (result.status === "success") {
            const playerNameElement = document.querySelector(".header h2");
            playerNameElement.textContent = result.login; // Вставляем логин в h2
        } else {
            console.error("Ошибка получения имени игрока:", result.message);
        }
    } catch (error) {
        console.error("Ошибка при запросе имени игрока:", error);
    }
}

async function joinRoom(roomId) {
    try {
        const response = await fetch("../api/join_game_room.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            credentials: "include",
            body: JSON.stringify({ room_id: roomId }),
        });

        const data = await response.json();
        console.log(data);

        if (data.status === "success" || data.message === "You are already in this room") {
            window.location.href = data.redirect_url; // Перенаправляем в комнату
        } else {
            alert(data.message); // Показываем ошибку, если что-то не так
        }
    } catch (error) {
        console.error("Ошибка при входе в комнату:", error);
        alert("Ошибка при входе в комнату. Попробуйте снова.");
    }
}


