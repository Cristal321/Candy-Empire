<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Игра</title>
    <link rel="stylesheet" href="../css/game.css">
    <link rel="icon" href="../images/icon.webp">
    
</head>
<body>



    <div class="parent-container">
        <div class="zona_players">
            <!-- Тут динамически появляются игроки-->
            
        </div>
        <div class="zona_reset_theft" id="reset_theft">
            <img id="reset" src="../images/reset.png">
            <img id="theft" src="../images/theft.png" style="margin-top: 100px;">
        </div> 
        <div class="zona_statys_game">
            <div class="status_game" id='status_game'>
                <h1 id='status'><!--Статус игры--></h1>
                <button class="buttonRoom" id="myAccount" title="Доступные комнаты"></button> 
                <button class="buttonRoom" id="exit_game" title="Выход из игры"></button> 
                <button class="buttonRoom" id="rules" title="Правила игры"></button>   
                <p id='p_time'>Время до конца хода: <span id="timer" style="font-family: 'Courier', monospace;"></span></p>
            </div>
            <div class="my_all_cards" id="my_cards">
                <div style="margin-bottom: 30px;" id="my_cards_in_hand">
                    
                </div>
                <div  id="my_cards_imperia">
                    <h3 id='myname'></h3>
                    
                </div>
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

    <div class="exit-confirmation-popup" id="exitPopup">
        <div class="exit-confirmation-content">
            <span class="exit-confirmation-close" id="closeExitPopup">&times;</span>
            <p>Вы уверены, что хотите поикнуть игру? <br></p><p style = 'margin-bottom:50px;'>Возможности вернуться уже не будет.</p>
            <button id="confirmExit">ухожу</button>
            <button id="cancelExit">остаюсь</button>
        </div>
    </div>


    


       <!-- Сообщение для маленьких экранов -->
    <div class="message-small-screen">
        Ваш экран слишком маленький
    </div>

    <div class="popup2">

        <div class="popup-content2">
          
          <!-- Верхняя картинка -->
          <div class="header-image-container">
            <img src="../images/vinyetka.png" alt="Верхняя картинка" class="header-image">
          </div>
          
          <!-- Контейнеры -->
          <div class="content-container">
            
            <div class="container0 container3">
                <img src="../images/catOnMeshok.svg" alt="Фоновая картинка" class="background-image" style='transform: scaleX(-1)'>
              </div>
    
            <!-- Контейнер 2 -->
            <div class="container0 container2">
                <h2 class="title2" style="color: #748B43;">Победитель</h2>
              <h2 class="player-name">_</h2>
              <div class="candy-info">
                <h2 class="candy-count">_</h2>
                <img src="../images/miniKonfeta.png" alt="Конфетка" class="candy-image">
              </div>
              <button class="games-button" id='final-button'>К играм</button>
            </div>
            
            <!-- Контейнер 3 -->
            <div class="container0 container3">
              <img src="../images/catOnMeshok.svg" alt="Фоновая картинка" class="background-image">
            </div>
            
          </div>
        </div>
      </div>

    


   
   <script>
    document.getElementById("myAccount").addEventListener("click", function() {
        window.location.href = "rooms.php";
    });
    </script>

    <script>
    document.getElementById("final-button").addEventListener("click", function() {
        window.location.href = "rooms.php";
    });
    </script>


    <script src="../scripts/exitGame.js"></script>
    <script src="../scripts/get_game_state.js"></script>
    <script src="../scripts/popupRooms.js"></script>

    <script src="../scripts/drag_to_imperia.js"></script>
    <script src="../scripts/discard_card.js"></script>
    <script src="../scripts/candy_thief.js"></script>


    
   
</body>
</html>