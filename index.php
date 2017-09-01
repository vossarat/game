<?php

/**
* файл точка входа на сервер http://game.tarassov.pro
* запускает загрузчик классов Autoload.php
* и маршрутизатор
* затем дейставие передается на соответвующий контроллер
* возможные варианты POST запросов :
* http://game.tarassov.pro/create - cоздает запись в таблице 
* http://game.tarassov.pro/show - показывает запись в таблице
* http://game.tarassov.pro/destroy - удаляет запись в таблице
* http://game.tarassov.pro/update - изменяет запись в таблице
* каждый запрос должен ОБЯЗАТЕЛЬНО содержать json с параметром id {"id":26}
* другие данные передаются по мере необходимости, например вот так
* {"id":26, "gamer1":"NickNamePlayer1"} - при отсылке такого запроса на маршрут http://game.tarassov.pro/update измениться имя игрока1 в таблице
* 
* доступ к phpmyadmin http://game.tarassov.pro/phpmyadmin логин и пароль game
* при ошибках приходит json ответ с индексом error и содержащим саму ошибку 
* 
*/

ini_set('display_errors', 1);
//error_reporting(E_ALL);
require_once 'Autoload.php';
Route::start();
?>