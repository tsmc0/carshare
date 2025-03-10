<p align="center">
    <img src="https://webkit.darknext.net/screen/c0.png" width="100%" style = 'border-radius: 2%;'>
    <h1 align="center">CARSHARE</h1>
    <br>
</p>

Описание
------------
CarShare – это платформа для совместного использования
автомобилей, позволяющая пользователям арендовать и сдавать в аренду
личные автомобили.<br>

Сложности разработки: Создание парсера для получения информации об авто


Требования
------------

1) Apache WebServer<br>
2) PHP 8.3+ (Yii 2.0.52)<br>
3) MySQL 8.0+ / MariaDB 10.8+


Развёртывание
------------

Заполните данные для подключения к бд в `config/db.php`:

```php
...
'dsn' => 'mysql:host=localhost;dbname=<ИМЯ_БД>',
    'username' => '<ИМЯ_ПОЛЬЗОВАТЕЛЯ>',
    'password' => '<ПАРОЛЬ_ПОЛЬЗОВТЕЛЯ>',
...
```

Затем, выполните миграции:

~~~
yii migrate
~~~

<p align="center">
    <h1 align="center">Проектирование</h1>
    <br>
    <img src="https://webkit.darknext.net/screen/c1.png" width="100%" style = 'border-radius: 2%;'>
</p>
