````markdown
# API Documentation для игры "Конфетная империя"

## Описание

Это API предназначено для взаимодействия с сервером игры "Конфетная империя". Игроки могут разгрывать карты на поле или игроках. В этой документации представлены все основные методы для взаимодействия с игрой.

### Авторизация

Для работы с API необходимо использовать **токен пользователя**. Токен можно получить через эндпоинт авторизации и регистрации.

## Методы API

### 1. Авторизация

**POST** `/api/auth_user.php`

**Описание**: Авторизация уже существующего пользователя, получение токена.

**Тело запроса**:

```json
{
  "login": "player_name",
  "password": "player_password"
}
```
````

**Ответ**:

```json
{
  "status": "success",
  "token": "user_token",
  "message": "Вход выполнен"
}
```

Если произошла ошибка:

```json
{
  "status": "error",
  "message": "Пользователь не найден / Неверный пароль / Введите логин и пароль"  
}
```


### 2. Регистрация

**POST** `/api/register.php`

**Описание**: Регистрация нового пользователя, получение токена.

**Тело запроса**:

```json
{
  "login": "player_name",
  "password": "player_password"
}
```

**Ответ**:

```json
{
  "status": "success",
  "token": "user_token",
  "message": "Регистрация успешна"
}
```

Если произошла ошибка:

```json
{
  "status": "error",
  "message": "Логин уже занят"  
}
```



### 3. Смена пароля

**POST** `/api/change_parol.php`

**Описание**: Смена пароля зарегестрированного пользователя.

**Тело запроса**:

```json
{
  "login": "player_name",
  "old_password": "old_password",
  "new_password": "new_password",

}
```

**Ответ**:

```json
{
  "status": "success",
  "message": "Пароль успешно изменен"
}
```

Если произошла ошибка:

```json
{
  "status": "error",
  "message": "Логин не существует / Неверный старый пароль / Новый пароль должен содержать от 4 до 20 символов"
}
```



### 4. Создание комнаты

**POST** `/api/create_room.php`

**Описание**: Создание игровой комнаты с выводом доступных комнат.

**Тело запроса**:

```json
{
  "token": "token",
  "seats": "3",
  "time": "40",

}
```

**Ответ**:

```json
{
  "status": "success",
  {
    "id": 69,
    "time_move": 25,
    "free_slots": 2,
    "is_joined": false,
    "game_status": "Ожидание игроков"
  },
  {
    "id": 65,
    "time_move": 40,
    "free_slots": 2,
    "is_joined": false,
    "game_status": "Ожидание игроков"
  },
  {
    "id": 47,
    "time_move": 120,
    "free_slots": 3,
    "is_joined": false,
    "game_status": "Ожидание игроков"
  }
}
```

Если произошла ошибка:

```json
{
  "status": "error",
  "message": " Ошибка Количество мест должно быть от 2 до 4 / Ошибка Время на ход должно быть от 5 до 120 секунд   "
}
```



### 5. Получение списка доступных комнат

**POST** `/api/get_rooms.php`

**Описание**: Вывод доступных комнат для игрока

**Тело запроса**:

```json
{
  "token": "token"
}
```

**Ответ**:

```json
{
  "status": "success",
  {
    "id": 69,
    "time_move": 25,
    "free_slots": 2,
    "is_joined": false,
    "game_status": "Ожидание игроков"
  },
  {
    "id": 65,
    "time_move": 40,
    "free_slots": 2,
    "is_joined": false,
    "game_status": "Ожидание игроков"
  },
  {
    "id": 47,
    "time_move": 120,
    "free_slots": 3,
    "is_joined": false,
    "game_status": "Ожидание игроков"
  }
}
```

Если произошла ошибка:

```json
{
  "status": "error",
  "message": " Ошибка Неверный токен  "
}
```

### 6. Вход в комнату

**POST** `/api/join_game_room.php`

**Описание**: Вступление в игровую комнату.

**Тело запроса**:

```json
{
  "token": "token",
  "room_id": "28",
}
```

**Ответ**:

```json
{
  "status": "success",
  {
  "status": "success",
  "game_status": "Ожидание игроков",
  "players": [
    {
      "player_login": "Lime",
      "id_player": 159
    }
  ]
  }
}
```

### 7. Состояние игры

**POST** `/api/get_game_state.php`

**Описание**: Вывод состояния игры на текущий момент.

**Тело запроса**:

```json
{
  "token": "token",
  "room_id": "28",
}
```

**Ответ**:

```json
{
  {
  "status": "success",
  "game_status": "Игра идёт",
  "current_player": 97,
  "time_left": "00:00:40",
  "game_state": [
    {
      "id_cards": 31,
      "id_player": 97,
      "status": "в империи"
    },
    {
      "id_cards": 28,
      "id_player": 97,
      "status": "на руках"
    },
    {
      "id_cards": 2,
      "id_player": 94,
      "status": "в империи"
    },
    {
      "id_cards": 4,
      "id_player": 95,
      "status": "в империи"
    },
    {
      "id_cards": 15,
      "id_player": 96,
      "status": "в империи"
    },
    {
      "id_cards": 24,
      "id_player": 96,
      "status": "в империи"
    },
    {
      "id_cards": 32,
      "id_player": 97,
      "status": "в империи"
    },
    {
      "id_cards": 30,
      "id_player": 97,
      "status": "на руках"
    },
    {
      "id_cards": 16,
      "id_player": 96,
      "status": "в империи"
    },
    {
      "id_cards": 25,
      "id_player": 96,
      "status": "в империи"
    },
    {
      "id_cards": 1,
      "id_player": 96,
      "status": "в империи"
    },
    {
      "id_cards": 27,
      "id_player": 97,
      "status": "в империи"
    },
    {
      "id_cards": 23,
      "id_player": 97,
      "status": "на руках"
    },
    {
      "id_cards": 13,
      "id_player": 96,
      "status": "в империи"
    },
    {
      "id_cards": 22,
      "id_player": 96,
      "status": "в империи"
    }
  ],
  "players": [
    {
      "player_login": "Semen",
      "id_player": 97
    },
    {
      "player_login": "Lime",
      "id_player": 96
    },
    {
      "player_login": "testtt",
      "id_player": 95
    },
    {
      "player_login": "Lavrov",
      "id_player": 94
    }
  ]
}
}
```

Если произошла ошибка:

```json
{
  "status": "error",
  "message": " Отсутствует токен пользователя или ID комнаты"
}
```

### 8. Имя игрока

**POST** `/api/get_username.php`

**Описание**: Получаем имя игрока, который вызывает данную функцию

**Тело запроса**:

```json
{
  "token": "token"
}
```

**Ответ**:

```json
{
  "status": "success",
  "login": "Nika"
}
```

Если произошла ошибка:

```json
{
  "status": "error",
  "message": "Токен не найден или недействителен"
}
```

### 9. Выход из аккаунта

**POST** `/api/logout.php`

**Описание**: Выходим из аккаунта и попадаемна страницу авторизации

**Тело запроса**:

```json
{
  "token": "token"
}
```

**Ответ**:

```json
{
  "status": "success",
  "login": "Вы успешно вышли"
}
```

Если произошла ошибка:

```json
{
  "status": "error",
  "message": "Вы уже вышли или не авторизованы"
}
```


### 10. Покинуть игру

**POST** `/api/player_exit_game.php`

**Описание**: Выходим из игры

**Тело запроса**:

```json
{
  "token": "token",
  "room_id": "45"
}
```

**Ответ**:

```json
{
  "status": "success",
  "login": "Игрок успешно покинул игру"
}
```

Если произошла ошибка:

```json
{
  "status": "error",
  "message": "Неверный токен / Игрок не находится в данной комнате"
}
```

### 11. Карта в империю

**POST** `/api/put_card_in_empire.php`

**Описание**: Действие в игре положить карту в империю

**Тело запроса**:

```json
{
  "token": "token",
  "room_id": "45",
  "card_id": "28",
}
```

**Ответ**:

```json
{
  "status": "success",
  "message": "Карта добавлена в империю",
  "id_cards": 28,
  "id_player": 97,
  "game_state": {
    "status": "success",
    "game_status": "Игра идёт",
    "current_player": 94,
    "time_left": "00:00:40",
    "game_state": [
      {
        "id_cards": 31,
        "id_player": 97,
        "status": "в империи"
      },
      {
        "id_cards": 2,
        "id_player": 94,
        "status": "в империи"
      },
      {
        "id_cards": 4,
        "id_player": 95,
        "status": "в империи"
      },
      {
        "id_cards": 15,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 24,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 32,
        "id_player": 97,
        "status": "в империи"
      },
      {
        "id_cards": 30,
        "id_player": 97,
        "status": "на руках"
      },
      {
        "id_cards": 16,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 25,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 1,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 27,
        "id_player": 97,
        "status": "в империи"
      },
      {
        "id_cards": 23,
        "id_player": 97,
        "status": "на руках"
      },
      {
        "id_cards": 13,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 22,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 28,
        "id_player": 97,
        "status": "в империи"
      },
      {
        "id_cards": 9,
        "id_player": 97,
        "status": "на руках"
      }
    ],
    "players": [
      {
        "player_login": "Semen",
        "id_player": 97
      },
      {
        "player_login": "Lime",
        "id_player": 96
      },
      {
        "player_login": "testtt",
        "id_player": 95
      },
      {
        "player_login": "Lavrov",
        "id_player": 94
      }
    ]
  }
}
```

Если произошла ошибка:

```json
{
  "status": "error",
  "message": "Неверный токен / Игровая комната не найдена / Игрок не находится в данной комнате /Сейчас не ваш ход / Карта не принадлежит вам или она не находится на руках "
}
```

### 12. Карта в сброс

**POST** `/api/discard_card.php`

**Описание**: Действие в игре положить карту в сброос

**Тело запроса**:

```json
{
  "token": "token",
  "room_id": "45",
  "card_id": "28",
}
```

**Ответ**:

```json
{
  "status": "success",
  "message": "Карта сброшена",
  "id_cards": 28,
  "id_player": 97,
  "game_state": {
    "status": "success",
    "game_status": "Игра идёт",
    "current_player": 94,
    "time_left": "00:00:40",
    "game_state": [
      {
        "id_cards": 31,
        "id_player": 97,
        "status": "в империи"
      },
      {
        "id_cards": 2,
        "id_player": 94,
        "status": "в империи"
      },
      {
        "id_cards": 4,
        "id_player": 95,
        "status": "в империи"
      },
      {
        "id_cards": 15,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 24,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 32,
        "id_player": 97,
        "status": "в империи"
      },
      {
        "id_cards": 30,
        "id_player": 97,
        "status": "на руках"
      },
      {
        "id_cards": 16,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 25,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 1,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 27,
        "id_player": 97,
        "status": "в империи"
      },
      {
        "id_cards": 23,
        "id_player": 97,
        "status": "на руках"
      },
      {
        "id_cards": 13,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 22,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 28,
        "id_player": 97,
        "status": "в империи"
      },
      {
        "id_cards": 9,
        "id_player": 97,
        "status": "на руках"
      }
    ],
    "players": [
      {
        "player_login": "Semen",
        "id_player": 97
      },
      {
        "player_login": "Lime",
        "id_player": 96
      },
      {
        "player_login": "testtt",
        "id_player": 95
      },
      {
        "player_login": "Lavrov",
        "id_player": 94
      }
    ]
  }
}
```

Если произошла ошибка:

```json
{
  "status": "error",
  "message": "Неверный токен / Игровая комната не найдена / Игрок не находится в данной комнате /Сейчас не ваш ход / Карта не принадлежит вам или она не находится на руках "
}
```

### 13. Карта конфетный вор

**POST** `/api/candy_thief.php.php`

**Описание**: Действие в игре разыграть конфетного вора

**Тело запроса**:

```json
{
  "token": "token",
  "room_id": "45",
  "thief_card_id": "28",
  "target_card_id": "29"
}
```

**Ответ**:

```json
{
  "status": "success",
  "message": "Карта успешно украдена",
  "id_cards": 28,
  "thief_card_id": "28",
  "target_card_id": "29",
  "id_player": 97,
  "game_state": {
    "status": "success",
    "game_status": "Игра идёт",
    "current_player": 94,
    "time_left": "00:00:40",
    "game_state": [
      {
        "id_cards": 31,
        "id_player": 97,
        "status": "в империи"
      },
      {
        "id_cards": 2,
        "id_player": 94,
        "status": "в империи"
      },
      {
        "id_cards": 4,
        "id_player": 95,
        "status": "в империи"
      },
      {
        "id_cards": 15,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 24,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 32,
        "id_player": 97,
        "status": "в империи"
      },
      {
        "id_cards": 30,
        "id_player": 97,
        "status": "на руках"
      },
      {
        "id_cards": 16,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 25,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 1,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 27,
        "id_player": 97,
        "status": "в империи"
      },
      {
        "id_cards": 23,
        "id_player": 97,
        "status": "на руках"
      },
      {
        "id_cards": 13,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 22,
        "id_player": 96,
        "status": "в империи"
      },
      {
        "id_cards": 28,
        "id_player": 97,
        "status": "в империи"
      },
      {
        "id_cards": 9,
        "id_player": 97,
        "status": "на руках"
      }
    ],
    "players": [
      {
        "player_login": "Semen",
        "id_player": 97
      },
      {
        "player_login": "Lime",
        "id_player": 96
      },
      {
        "player_login": "testtt",
        "id_player": 95
      },
      {
        "player_login": "Lavrov",
        "id_player": 94
      }
    ]
  }
}
```

Если произошла ошибка:

```json
{
  "status": "error",
  "message": "Неверный токен / Игровая комната не найдена / Игрок не находится в данной комнате /Сейчас не ваш ход / Карта не принадлежит вам или она не находится на руках / Карта не является вором, не принадлежит вам или она не находится на руках "
}
```



























