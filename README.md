Инструкция для API

## Регистрация

127.0.0.1:8000/api/login?email=**{email}**&password=**{paassword}**

## Авторизация

    position_id - число от 1 до 5

127.0.0.1:8000/api/login?name=**{name}**&email=**{email}**&password=**{paassword}**&position_id=**{position_id}**

## Поиск автомобилей

    model_id - число от 1 до 11
<a>

    comfort_level - число от 1 до 4

<a>

    datetime_start - timestamp

    Время начала планируемой поездки
<a>

    datetime_end - timestamp

    Время окончания планируемой поездки

 127.0.0.1:8000/api/cars/vacant?model=**{model_id}**&comfort_level=**{comfort_level}**&datetime_start=**{datetime_start}**&datetime_end=**{datetime_end}**

    Требуется авторизация. Авто недоступные пользователю по должности скрываются автоматически