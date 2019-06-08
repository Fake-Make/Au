<?php
ini_set('display_errors','On');
error_reporting('E_ERROR');

// подключаем файлы ядра
require_once 'core/config.php';
require_once 'core/validator.php';
require_once 'core/database.php';
require_once 'core/paginator.php';
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';


/*
Здесь обычно подключаются дополнительные модули, реализующие различный функционал:
	> аутентификацию
	> кеширование
	> работу с формами
	> абстракции для доступа к данным
	> ORM
	> Unit тестирование
	> Benchmarking
	> Работу с изображениями
	> Backup
	> и др.
*/

require_once 'core/route.php';
Route::start(); // запускаем маршрутизатор
