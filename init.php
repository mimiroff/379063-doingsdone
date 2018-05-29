<?php
/**
 * Сценарий устанавливающий соединение с БД
 */

require_once 'functions.php';
require_once 'vendor/autoload.php';

$link = mysqli_connect('localhost', 'root', '', 'doingsdone-379063');

if(!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
}

mysqli_set_charset($link, 'utf8');
