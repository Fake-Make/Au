<?php
// Скрытие некритических сообщений об ошибках
ini_set('display_errors','On');
error_reporting('E_ERROR');

// Подключение библиотек
require_once 'core/config.php';
require_once 'core/validator.php';
require_once 'core/database.php';
require_once 'core/paginator.php';
require_once 'core/route.php';

// Подключение файлов ядра
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';

// Запуск маршрутизации
Route::start();