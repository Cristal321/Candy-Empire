document.addEventListener("DOMContentLoaded", function () {
    const hand = document.getElementById("my_cards_in_hand"); // Контейнер карт в руке
    const imperia = document.getElementById("my_cards_imperia"); // Контейнер карт в империи
    const theft = document.querySelector(".zona_reset_theft"); // Элемент зоны кражи

    // Получаем roomId из URL
    const roomId = new URLSearchParams(window.location.search).get("room");
    if (!roomId) {
        console.error("Room ID not found");
        return;
    }

    console.log('Room ID:', roomId); // Логируем roomId для проверки

    // Делаем карты в руке перетаскиваемыми
    document.querySelectorAll("#my_cards_in_hand img").forEach(img => {
        img.draggable = true; // Разрешаем перетаскивание
        img.addEventListener("dragstart", dragStart); // Добавляем обработчик начала перетаскивания
        console.log('карты стали перетаскиваемыми');
    });

    // Разрешаем сброс карт в империю
    imperia.addEventListener("dragover", dragOver);
    imperia.addEventListener("drop", dropToImperia);

    // Функция начала перетаскивания
    function dragStart(event) {
        const cardHTML = event.target.outerHTML; // Получаем HTML карты
        event.dataTransfer.setData("text/html", cardHTML); // Сохраняем HTML карты
        console.log('Начало перетаскивания карты');

    }

    // Разрешаем перетаскивание (иначе `drop` не сработает)
    function dragOver(event) {
        event.preventDefault();
        console.log('Перетаскивание разрешено');
    }

    // Функция обработки сброса карты в империю
    async function dropToImperia(event) {
        event.preventDefault();
        const cardHTML = event.dataTransfer.getData("text/html"); // Получаем HTML карты
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = cardHTML;
        const cardId = tempDiv.querySelector('img').dataset.cardId; // Извлекаем ID карты
        console.log('Полученный ID карты:', cardId); // Логируем полученный ID
        const existingCard = document.querySelector(`#my_cards_in_hand img[data-card-id="${cardId}"]`); // Ищем карту в руке
        console.log('сброс в империю пытается с ID:', cardId);

        // Получаем текущее состояние игры
        const gameState = await window.fetchGameState();
        const currentPlayerId = gameState.current_player;

        // Получаем ID текущего игрока
        const myPlayer = gameState.players.find(player => player.player_login === window.myUsername);
        const myPlayerId = myPlayer ? myPlayer.id_player : null;

        // Проверяем, является ли текущий игрок ходящим
        if (currentPlayerId !== myPlayerId) {
            alert("Это не ваш ход!")
            console.error('Это не ваш ход!');
            return;
        }

        if (existingCard) {
            console.log('Карта найдена, начинаем перемещение');
        
            // Добавляем небольшую задержку перед анимацией
            setTimeout(() => {
                existingCard.style.transition = "transform 0.7s ease, opacity 0.7s ease";
                existingCard.style.transform = "scale(0)";
                existingCard.style.opacity = "0";
            }, 10); // Короткая задержка
        
            // Ждем завершения анимации и удаляем карту
            setTimeout(() => {
                if (existingCard.parentNode) {
                    existingCard.remove();
                    console.log('Карта удалена после анимации');
                }
            }, 600);
        
            imperia.insertAdjacentHTML("beforeend", cardHTML); // Добавляем карту в империю
        
            // Изменяем размер карты после добавления в империю
            const movedCard = imperia.querySelector(`img[data-card-id="${cardId}"]`);
            if (movedCard) {
                movedCard.style.width = "10%"; // Устанавливаем новый размер
            }
        
            updateCardMargins(); // Обновляем отступы
            console.log('Карта успешно перемещена');
        
            // Отправляем POST-запрос на сервер для обновления состояния игры
            await sendCardToEmpire(roomId, cardId);
        
            // Обновляем состояние игры после перетаскивания
            await window.fetchGameState();
        } else {
            console.log('Карта не найдена в руке');
        }
    }

    // Функция для отправки карты в империю
    async function sendCardToEmpire(roomId, cardId) {
        try {
            console.log('Отправляем запрос с roomId:', roomId, 'и cardId:', cardId); // Логируем отправляемые данные
            const params = new URLSearchParams();
            params.append('room_id', roomId);
            params.append('card_id', cardId);

            const response = await fetch("../api/put_card_in_empire.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: params,
                credentials: "include"
            });

            const data = await response.json();
            console.log('Ответ сервера:', data); // Логируем ответ сервера
            if (data.status !== "success") {
                console.error("Ошибка при отправке карты в империю:", data.message);
            } else {
                console.log("Карта успешно отправлена в империю");
            }
        } catch (error) {
            console.error("Ошибка при отправке запроса:", error);
        }
    }

    // Обновляем отступы карт в империи
    function updateCardMargins() {
        const cards = document.querySelectorAll("#my_cards_imperia img");
        cards.forEach((card, index) => {
            card.style.marginLeft = index === 0 ? "0px" : "4px";
        });
    }
});
