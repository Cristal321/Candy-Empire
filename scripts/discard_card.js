document.addEventListener("DOMContentLoaded", function () {
    const reset = document.getElementById("reset"); // Контейнер для сброса карт
    const roomId = new URLSearchParams(window.location.search).get("room");
    if (!roomId) {
        console.error("Room ID not found");
        return;
    }

    reset.addEventListener("dragover", dragOver);
    reset.addEventListener("drop", dropToReset);

    function dragOver(event) {
        event.preventDefault();
    }

    async function dropToReset(event) {
        event.preventDefault();
        const cardHTML = event.dataTransfer.getData("text/html");
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = cardHTML;
        const cardId = tempDiv.querySelector('img').dataset.cardId; // Извлекаем ID карты
        console.log('Полученный ID карты:', cardId);
        const existingCard = document.querySelector(`#my_cards_in_hand img[data-card-id="${cardId}"]`);
        console.log('Сброс карты с ID:', cardId);

        if (!existingCard) {
            console.error("Карта не найдена в руке");
            return;
        }

        const gameState = await window.fetchGameState();
        const currentPlayerId = gameState.current_player;
        const myPlayer = gameState.players.find(player => player.player_login === window.myUsername);
        const myPlayerId = myPlayer ? myPlayer.id_player : null;

        if (currentPlayerId !== myPlayerId) {
            alert("Это не ваш ход!")
            console.error("Это не ваш ход!");
            return;
        }

        existingCard.classList.add("fade-out");
        setTimeout(() => existingCard.remove(), 500);

        await sendCardToReset(roomId, cardId);
        await window.fetchGameState();
    }

    async function sendCardToReset(roomId, cardId) {
        try {
            const params = new URLSearchParams();
            params.append("room_id", roomId);
            params.append("card_id", cardId);

            const response = await fetch("../api/discard_card.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: params,
                credentials: "include"
            });

            const data = await response.json();
            if (data.status !== "success") {
                console.error("Ошибка при сбросе карты:", data.message);
            } else {
                console.log("Карта успешно сброшена");
            }
        } catch (error) {
            console.error("Ошибка при отправке запроса:", error);
        }
    }
});
