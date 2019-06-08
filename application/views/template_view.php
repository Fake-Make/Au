<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="<?=$this->host?>/css/stylesheet.css">
	<link rel="shortcut icon" href="<?=$this->host?>/img/favicon.png" type="image/png">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="<?=$this->host?>/js/script.js"></script>
	<title>Au - Площадка Интернет-Аукционов</title>
</head>
<body>
	<div class="height-wrapper">
		<div class="flex-column content-wrapper">
			<header class="flex-column page-header">
				<nav class="flex-column page-nav">
					<ul class="flex-row header-wrapper">
						<li class="page-nav__item"><a class="image-logo" href="<?=$this->host?>/"><img src="<?=$this->host?>/img/logo.png" alt="Аукционы" height="30px"></a></li>
						<li class="page-nav__item">
							<?if(!empty($_SESSION['user'])):?>
								<a class="flex-row" href="<?=$this->host?>/personal"><?=validator::validAnyString($_SESSION['user'])?><img class="user-image" src="<?=$this->host?>/img/box.png" alt="Фото пользователя"></a>
							<?else:?>
								<a href="<?=$this->host?>/login">Войти</a> или <a href="<?=$this->host?>/registration">зарегистрироваться</a>
							<?endif?>
						</li>
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
				<?php include 'application/views/'.$content_view; ?>
			</main>
		</div>
		<footer class="flex-column page-footer">
			<a class="image-logo" href="<?=$this->host?>/"><img src="<?=$this->host?>/img/logo.png" alt="logo" height="30px"></a>
			<div class="flex-column">
			<p>Используя сайт, вы принимаете соглашение</p>
				<p>Copyright © интернет-аукцион au.ru</p>
				<p>2019-2019 Все права защищены</p>
			</div>
		</footer>
	</div>
</body>
</html>