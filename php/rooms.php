<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доступные комнаты</title>
    <link rel="stylesheet" href="../css/rooms.css">
    <link rel="icon" href="../images/icon.webp">
</head>
<body>
<div class="main-container">
  <div class="rooms-container">
    <div class="header">
      <h1 class="title">Доступные комнаты</h1>
      <h2 ><!-- Имя игрока --></h2>
      <button class="buttonRoom" id="logoutButton" title="Выход из аккаунта"></button>
      <button class="buttonRoom" id="rules" title="Правила игры"></button>      
    </div>

    <div class="rooms-list" id="roomsList">
      <!-- Форма создания комнаты теперь ВНЕ списка -->
      <div class="room new-room-container" style="background-image: none;">
        <div class="room-info" id="newRoom">
          <form action="#" method="POST" id="createRoom">
            <input type="number" id="colvo" name="players" placeholder="Введите количество игроков (от 2 до 5)" required>
            <input type="number" id="time" name="time" placeholder="Введите время для хода (в секундах)" required>
            <button type="submit" id="buttonCreate">Создать комнату</button>
          </form>
        </div>
      </div>              

      <!-- Тут динамически будут добавляться комнаты -->
      <div id="dynamicRooms"></div>
    </div>
  </div>
</div>
    
<div class="popup" id="popup">
        <div class="popup-content">
            <span class="close-btn" id="closePopup">&times;</span>
            <h2 >Описание и цель игры</h2>
            <p >Действие игры происходит во вселенной «Конфетные истории». В этом мире конфеты больше не производятся, они очень ценные, и осталось их немного, а заполучить себе несколько - мечта каждого.

              В игре побеждает тот, кто заработает больше всех конфет. Конфеты зарабатываются в результате выкладывания на стол карточек персонажей.</p>
            
            <h2 style="margin-top: 40px;">Игровое поле</h2>
            <img  style="border-radius: 0; width: 45vw;" class="gifka" src="../images/gameDesk.svg" alt="игровое поле" />
            
            <h2 style="margin-top: 40px;">Ход игры</h2>
            <p>Текущий игрок подсвечивается карсным цветом. В свой ход, он должен сделать одно из следующих действий:

             <br> - разыграть карточку в империю ( перетащить карту из руки под своё имя)
             <br> - разыграть карточку в сброс ( перетащить карту в центр стола на надпись «сброс»)
             <br> - разыграть карту Конфетный вор ( перетащить карту в центр стола на надпись «украсть») 
            </p>

            <h2 style="margin-top: 40px;">Карты в империи</h2>
            <p>Крайне важно прятать все свои конфеты в империи, ведь чем больше их там будет, 
              тем выше шанс стать владыкой этого мира! Карты вашей империи располагаются под вашим именем. Но помните, если вы спрятали свои конфеты в империи достать обратно вы их уже не сможете. 
              Для того чтобы преместить какую-либо карту из руки в империю, просто перетащите её туда в свой ход.</p>
            <img class="gifka" src="../images/impire.gif" alt="видео демонстрация перетаскивания карты в империю" />

            <h2 style="margin-top: 40px;">Сброс карты</h2>
            <p>Некоторые конфеты очень кислые, поэтому могут не давать вам очки, а наоборот их отнимать или вообще ничего не давать. Такие конфеты приятны только когда вы нашли им комбинацию, но если нет скорее избавляйтесь от них. Для этого перетащите карту из руки в зону сброса в центре игрового поля.</p>
            <img class="gifka" src="../images/sbros.gif" alt="видео демонстрация перетаскивания карты в сброс" />

            <h2 style="margin-top: 40px;">Конфетный вор</h2>
            <p>Конфеты в чужой империи выглядят так привлекательно, аж слюнки текут... Если вдруг очень хочеться и в руке у вас завалялся конфетный вор можно украсть карточку из чужой империи. Чтобы разыграть карту конфетного вора просто перетащите карту вора из руки в зону «украсть» в центре игрового поля и перетащите карту из чужой империи в свою.
            <br>НО помните, воришек никто не любит, сделайте это очень быстро иначе кража неудасться!</p>
            <img class="gifka" src="../images/vor.gif" alt="видео демонстрация разыгрыш конфетного вора" />
            
            <h2 style="margin-top: 40px;">Конец игры</h2>
            <p>Игра заканчивается в тот момент, когда у игроков не остаётся на руках ни одной карточки. После этого начинается подсчёт гарантированных конфет и бонусных.</p>
            
            <h2 style="margin-top: 40px;">Какие ещё конфеты?</h2>
            <p>В игре существуют гарантированные конфеты  и бонусные. Количество гаратированных конфет указано на каждой из карточек большой цифрой. Бонусные же конфеты выглядят, как половинки. Они начисляются вам только при условии, что вы собрали пару карт одинакового цвета, но разного номинала.</p>
            

            <img src="../images/Group 316.svg" style="width: 40vh;">
            <br>
            <img src="../images/noncombination.svg" style="width: 40vh; margin-top: 50px;">
            <img src="../images/combination.svg" style="width: 40vh; margin-left: 20%;">
        </div>
    </div>
       <!-- Сообщение для маленьких экранов -->
    <div class="message-small-screen">
        Ваш экран слишком маленький
    </div>
    <div id="popup-room" class="popup-room">
      <div class="popup-room-content">
        <p>id вашей комнаты: <span id="roomId"></span></p>
      </div>
    </div>



    <div class="exit-confirmation-popup" id="exitPopup">
        <div class="exit-confirmation-content">
            <span class="exit-confirmation-close" id="closeExitPopup">&times;</span>
            <p>Вы хотите выйти из всех аккаунтов или только из текущего? <br></p>
            <button id="Exit_vsex">из всех</button>
            <button id="exit_etot">из этого</button>
        </div>
    </div>

   <script src="../scripts/create_room.js"></script>
    <script src="../scripts/popupRooms.js"></script>
    <script src="../scripts/logout.js"></script>
    <script src="../scripts/get_rooms.js"></script>
   



      
      
</body>
</html>
