<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="css/stylesheet.css">
	<link rel="shortcut icon" href="img/favicon.png" type="image/png">
	<title>Au - Площадка Интернет-Аукционов</title>
</head>
<body>
	<div class="height-wrapper">
		<div class="flex-column content-wrapper">
			<header class="flex-column page-header">
				<nav class="flex-column page-nav">
					<ul class="flex-row header-wrapper">
						<li class="page-nav__item"><a class="image-logo" href="index.php"><img src="img/logo.png" alt="Аукционы" height="30px"></a></li>
						<li class="page-nav__item"><a href="login.php">Войти</a> или <a href="registration.php">зарегистрироваться</a> | <a class="flex-row" href="personal.php">User Name<img class="user-image" src="img/box.png" alt="Фото пользователя"></a></li>
					</ul>
				</nav>
				<?if(false !== strpos($_SERVER["REQUEST_URI"], "index")):?>
					<form action="index.php" class="flex-row header-wrapper">
						<input class="input-box search-input" type="text" placeholder="Название лота">
						<input class="button search-submit" type="submit" value="Поиск">
					</form>
				<?endif?>
			</header>
			<main class="flex-column wrapper main-content">