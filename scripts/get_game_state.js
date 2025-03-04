document.addEventListener("DOMContentLoaded", async () => {
    const roomId = new URLSearchParams(window.location.search).get("room");
    let timerInterval = null; // Глобальная переменная для хранения таймера
    let lastTimeLeft = null; // Для отслеживания изменения времени
    const pTime = document.getElementById("p_time");


    if (!roomId) {
        console.error("Room ID not found");
        return;
    }


    // Получение логина игрока с сервера
    async function fetchUsername() {
        try {
            const response = await fetch("../api/get_username.php", {
                method: "GET",
                credentials: "include"
            });
            const data = await response.json();
            if (data.status === "success") {
                window.myUsername = data.login; // Сохраняем логин в глобальной переменной
                updatePlayerName(data.login); // Обновляем имя игрока в интерфейсе
            } else {
                console.error("Ошибка при получении логина:", data.message);
            }
        } catch (error) {
            console.error("Ошибка при получении логина:", error);
        }
    }


    await fetchUsername();


    // Функция для обновления имени игрока
    function updatePlayerName(username, isCurrentPlayer = false) {
        const playerNameElement = document.getElementById("myname");
        if (playerNameElement) {
            playerNameElement.textContent = username;  // Обновляем текст в h3
            playerNameElement.style.color = isCurrentPlayer ? "#DF5910" : "#EFE096"; // Устанавливаем цвет
        } else {
            console.error("Ошибка: элемент #myname не найден в HTML");
        }
    }


    // Функция для обновления списка игроков, исключая текущего
    function updatePlayers(players, currentPlayerId) {
        const playersContainer = document.querySelector('.zona_players');  // Находим контейнер для игроков
        playersContainer.innerHTML = '';  // Очищаем контейнер


        // Фильтруем список игроков, исключая текущего
        const filteredPlayers = players.filter(player => player.player_login !== window.myUsername);


        filteredPlayers.forEach(player => {
            // Создаем новый элемент для игрока
            const playerDiv = document.createElement('div');
            playerDiv.classList.add('player', `player-${player.id_player}`); // Добавляем класс с id игрока


            // Создаем элемент h3 и вставляем login игрока
            const playerName = document.createElement('h3');
            playerName.textContent = player.player_login;


            // Устанавливаем начальный цвет
            playerName.style.color = "#EFE096";  // Базовый цвет


            // Если игрок это текущий, меняем цвет на #DF5910
            if (player.id_player === currentPlayerId) {
                playerName.style.color = "#DF5910";
            }


            // Вставляем имя игрока в div
            playerDiv.appendChild(playerName);


            // Добавляем div с игроком в контейнер
            playersContainer.appendChild(playerDiv);
        });
    }


   


function startTimer(timeLeft) {
    // Если time_left не изменился, не перезапускаем таймер
    if (lastTimeLeft === timeLeft) return;


    clearInterval(timerInterval); // Очищаем предыдущий таймер


    // Сохраняем текущее значение времени
    lastTimeLeft = timeLeft;


    // Убираем миллисекунды, если они есть
    timeLeft = timeLeft.split('.')[0];  // Берем только часть до точки (если она есть)


    // Разбираем строку "HH:MM:SS"
    let [hours, minutes, seconds] = timeLeft.split(":").map(Number);


    // Преобразуем всё в секунды для удобства
    let totalSeconds = hours * 3600 + minutes * 60 + seconds;


    const timerElement = document.getElementById("timer");
    if (!timerElement) {
        console.error("Ошибка: элемент #timer не найден");
        return;
    }


    function updateTimerDisplay() {
        let displayMinutes = Math.floor(totalSeconds / 60);
        let displaySeconds = totalSeconds % 60;


        // Форматируем вывод без миллисекунд
        timerElement.textContent = `${String(displayMinutes).padStart(2, "0")}:${String(displaySeconds).padStart(2, "0")}`;
    }


    updateTimerDisplay(); // Обновляем отображение перед запуском таймера


    timerInterval = setInterval(() => {
        if (totalSeconds <= 0) {
            clearInterval(timerInterval);
            return;
        }


        totalSeconds--; // Уменьшаем время на 1 секунду
        updateTimerDisplay(); // Обновляем отображение времени каждую секунду
    }, 1000);
}

function updateTimerVisibility(game_status) {
    if (game_status === "Игра идёт") {
        pTime.style.display = "block"; 
    } else {
        pTime.style.display = "none"; 
    }
}

async function fetchGameState() {
    try {
        const response = await fetch("../api/get_game_state.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ room_id: roomId }),
            credentials: "include"
        });

        const data = await response.json();
        if (data.status !== "success") {
            console.error("Ошибка:", data.message);
            return;
        }

        if (data.game_status === "Игра окончена") {
            handleGameEnd(data);
            return;
        }

       
        updateTimerVisibility(data.game_status);

        
        updateGameStatus(data.game_status);
        updatePlayers(data.players, data.current_player);

        if (data.time_left) {
            startTimer(data.time_left);
        }

        const myPlayer = data.players.find(player => player.player_login === window.myUsername);
        const myPlayerId = myPlayer ? myPlayer.id_player : null;

        updatePlayerName(window.myUsername, myPlayerId === data.current_player);
        updatePlayerCards(myPlayerId, data.game_state);
        updateAllPlayersCards(data.players, myPlayerId, data.game_state);

        return data;
    } catch (error) {
        console.error("Ошибка при получении данных:", error);
    }
}

// Функция обработки завершения игры
function handleGameEnd(data) {
    console.log("Отследили конец");
    document.querySelector(".popup2").style.display = "flex";
    document.querySelector(".popup-content2").style.display = "flex";

    const winner = data.game_results.find(player => player.is_winner);
    if (winner) {
        console.log("Отследили победителя", winner);
        const winnerInfo = data.players.find(player => player.id_player === winner.id_player);
        if (winnerInfo) {
            document.querySelector(".player-name").textContent = winnerInfo.player_login;
        }
        document.querySelector(".candy-count").textContent = winner.total_points;
    }
}

// Функция обновления статуса игры
function updateGameStatus(status) {
    const statusElement = document.getElementById("status");
    if (statusElement) {
        statusElement.textContent = status;
    }
}

// Функция обновления карт в руке и в империи у текущего игрока
function updatePlayerCards(myPlayerId, gameState) {
    updateCardContainer(
        "my_cards_in_hand",
        gameState.filter(card => card.id_player === myPlayerId && card.status === "на руках"),
        false // Это не империя, поэтому false
    );

    updateCardContainer(
        "my_cards_imperia",
        gameState.filter(card => card.id_player === myPlayerId && card.status === "в империи"),
        true // Это империя, поэтому true
    );
}

// Функция обновления карт в империях у всех игроков (кроме текущего)
function updateAllPlayersCards(players, myPlayerId, gameState) {
    players.forEach(player => {
        if (player.id_player !== myPlayerId) {
            updateCardContainer(
                `.player-${player.id_player}`,
                gameState.filter(card => card.id_player === player.id_player && card.status === "в империи"),
                true // Карты в империи
            );
        }
    });
}


// Функция обновления контейнера карт с разными стилями для руки и империи
function updateCardContainer(containerId, newCards, isImperia = false) {
    const container = document.getElementById(containerId) || document.querySelector(containerId);
    if (!container) return;

    // Создаём Map для быстрого поиска существующих карт
    const existingCards = new Map();
    container.querySelectorAll("img").forEach(img => {
        existingCards.set(img.dataset.cardId, img);
    });

    newCards.forEach(card => {
        if (!existingCards.has(card.id_cards.toString())) {
            // Если карты нет в контейнере — добавляем
            const cardImg = document.createElement("img");
            cardImg.src = `../images/cards/${card.id_cards}.png`;
            cardImg.dataset.cardId = card.id_cards;

            // Устанавливаем стили в зависимости от типа контейнера
            if (isImperia) {
                cardImg.style.width = "10%"; // Размер для карт в империи
                cardImg.style.marginRight = "10px";
            } else {
                cardImg.style.width = "17%"; // Размер для карт в руке
                cardImg.style.marginRight = "10px";
            }

            container.appendChild(cardImg);
        } else {
            // Если карта уже есть, удаляем её из Map (чтобы понять, какие карты нужно удалить)
            existingCards.delete(card.id_cards.toString());
        }
    });

    // Удаляем лишние карты, которые больше не актуальны
    existingCards.forEach((img, cardId) => {
        img.remove();
    });
}


// Запускаем получение данных и обновляем каждые 5 секунд
window.fetchGameState = fetchGameState;
await fetchGameState();
setInterval(fetchGameState, 5000);



   
});


