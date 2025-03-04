document.addEventListener("DOMContentLoaded", function () {
    const theft = document.getElementById("theft"); // Элемент зоны "украсть"
    const imperia = document.getElementById("my_cards_imperia"); // Контейнер моей империи
    const roomId = new URLSearchParams(window.location.search).get("room"); // Получаем номер комнаты из URL

    if (!roomId) {
        console.error("Номер комнаты не найден");
        return;
    }


    // Устанавливаем обработчики событий для всех карт в руке
    document.querySelectorAll("#my_cards_in_hand img").forEach(img => {
        img.draggable = true; // Делаем карту перетаскиваемой
        img.addEventListener("dragstart", handleDragStart); // Начало перетаскивания
        img.addEventListener("dragend", handleDragEnd); // Конец перетаскивания
    });

    // Разрешаем сброс карт в зону "украсть"
    theft.addEventListener("dragover", dragOver);
    theft.addEventListener("drop", dropToTheft);

    // Разрешаем перетаскивание карт из чужих империй в свою
    document.querySelectorAll(".zona_players img").forEach(img => {
        img.draggable = true;
        img.addEventListener("dragstart", handleDragStart);
    });

    imperia.addEventListener("dragover", dragOver);
    imperia.addEventListener("drop", dropFromPlayers);

    let candyThiefActivated = false; // Флаг для отслеживания активации конфетного вора
    let thiefCardId = null; // ID карты вора

    // Функция обработки начала перетаскивания
    function handleDragStart(event) {
        console.log("Начало перетаскивания карты.");
        theft.style.opacity = "1"; // Подсвечиваем зону "украсть"
    }

    // Функция обработки завершения перетаскивания
    function handleDragEnd() {
        console.log("Перетаскивание карты завершено.");
        theft.style.opacity = "0.3"; // Возвращаем прозрачность после окончания перетаскивания
    }

    // Функция разрешает сброс карты в контейнер
    function dragOver(event) {
        event.preventDefault();
        console.log("Перетаскивание разрешено.");
    }


    // Функция обработки сброса карты в зону "украсть"
    function dropToTheft(event) {
        event.preventDefault();
        console.log("Карта сброшена в зону 'украсть'.");

        const cardHTML = event.dataTransfer.getData("text/html"); // Получаем HTML карты
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = cardHTML;
        const cardId = tempDiv.querySelector('img').dataset.cardId; // Извлекаем ID карты
        console.log("Полученный ID карты:", cardId);

        const existingCard = document.querySelector(`#my_cards_in_hand img[data-card-id="${cardId}"]`);
        console.log("Карта найдена:", !!existingCard);

        if (existingCard && isCandyThief(cardId)) {
            console.log("Конфетный вор активирован.");
            existingCard.classList.add("fade-out"); // Анимация исчезновения
            setTimeout(() => existingCard.remove(), 500); // Удаляем карту через 0.5 секунды

            // Сохраняем ID карты вора
            thiefCardId = cardId;

            // Активируем выбор карты из чужой империи
            candyThiefActivated = true;
            promptSelectCardFromOthers();
        } else {
            console.error("Карта не является конфетным вором или не найдена.");
        }
    }

    // Функция обработки кражи карты из чужой империи
    async function dropFromPlayers(event) {

              
        event.preventDefault();

        if (!candyThiefActivated) {
            console.error("Сначала нужно активировать конфетного вора!");
            return;
        }

        const cardId = event.dataTransfer.getData("text/plain"); // Получаем ID карты
        const selectedCard = document.querySelector(`.zona_players img[data-card-id="${cardId}"]`); // Ищем карту в чужой империи

        if (selectedCard) {
            imperia.insertAdjacentHTML("beforeend", selectedCard.outerHTML); // Добавляем карту в свою империю
            selectedCard.remove(); // Удаляем карту из чужой империи
            updateCardMargins(); // Обновляем отступы карт в империи

            // Отправляем POST-запрос на сервер
            await sendCandyThiefRequest(roomId, thiefCardId, cardId);
            await window.fetchGameState();

            // Сбрасываем состояние активации конфетного вора
            candyThiefActivated = false;
        }
    }

    // Проверка, является ли карта конфетным вором
    function isCandyThief(cardId) {
        return ['6', '7', '8', '9', '10'].includes(cardId);
    }

    // Функция выбора карты из чужой империи
    function promptSelectCardFromOthers() {
        const players = document.querySelectorAll(".zona_players .player img");

        players.forEach(player => {
            player.addEventListener("dragstart", (event) => {
                const cardHTML = event.target.outerHTML;
                event.dataTransfer.setData("text/html", cardHTML);
                event.dataTransfer.setData("text/plain", event.target.dataset.cardId);
            });

            player.addEventListener("dragover", dragOver);
            player.addEventListener("drop", handleCardSelection);
        });
    }

    // Функция обработки выбора карты из чужой империи
    function handleCardSelection(event) {
        event.preventDefault();

        const cardId = event.dataTransfer.getData("text/plain");
        const selectedCard = document.querySelector(`.zona_players img[data-card-id="${cardId}"]`);

        if (selectedCard) {
            imperia.insertAdjacentHTML("beforeend", selectedCard.outerHTML);
            selectedCard.remove();
            updateCardMargins();
        }
    }

    // Функция обновления отступов у карт в империи
    function updateCardMargins() {
        document.querySelectorAll("#my_cards_imperia img").forEach((card, index) => {
            card.style.marginLeft = index === 0 ? "0px" : "4px";
        });
    }

    // Функция для отправки POST-запроса на сервер
    async function sendCandyThiefRequest(roomId, thiefCardId, targetCardId) {
        try {
            const params = new URLSearchParams();
            //console.log('номер комнаты', roomId);
            //console.log('карта вора', thiefCardId);
            //console.log('карта, которую хотим украсть', targetCardId);
            params.append('room_id', roomId);
            params.append('thief_card_id', thiefCardId);
            params.append('target_card_id', targetCardId);

            const response = await fetch("../api/candy_thief.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: params,
                credentials: "include"
            });

            const data = await response.json();
            console.log("Ответ сервера:", data); // Логируем полный ответ сервера

            if (data.status !== "success") {
                console.error("Ошибка при отправке запроса конфетного вора:", data.message);
            } else {
                console.log("Запрос конфетного вора отправлен успешно");
            }
        } catch (error) {
            console.error("Ошибка при отправке запроса:", error);
        }
    }
});
