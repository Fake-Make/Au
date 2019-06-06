<h1>Регистрация</h1>
<form class="flex-row login-form auction-box" action="" method="POST">
	<label class="login-label" for="registration-name">Введите имя и фамилию: </label>
	<input class="input-box login-input" type="text" name="registration-name" id="registration-name" placeholder="Иван Петров" required pattern="[a-zA-Zа-яА-Я]{2,} [a-zA-Zа-яА-Я]{2,}">

	<label class="login-label" for="registration-nick">Придумайте уникальный ник: </label>
	<input class="input-box login-input" type="text" name="registration-nick" id="registration-nick" placeholder="Nickname" required pattern="[a-zA-Zа-яА-Я0-9]{2,64}">

	<label class="login-label" for="registration-email">Введите электронную почту: </label>
	<input class="input-box login-input" type="email" name="registration-email" id="registration-email" placeholder="user.2019@gmail.com" required>

	<label class="login-label" for="registration-password">Придумайте пароль: </label>
	<input class="input-box login-input" type="password" name="registration-password" id="registration-password" placeholder="Пароль" required pattern="[a-zA-Z0-9 ]{6,24}">

	<label class="login-label" for="registration-password-again">Подтвердите пароль: </label>
	<input class="input-box login-input" type="password" name="registration-password-again" id="registration-password-again" placeholder="Пароль" required pattern="[a-zA-Z0-9 ]{6,24}">

	<input class="button login-submit" type="submit" value="Регистрация">
	<a class="button login-submit" href="<?=$this->host?>/login">Войти</a>
</form>
<?extract($data); ?>
<?if($registration_status=="success"):?>
<p style="color:green">Регистрация прошла успешно!</p>
<?elseif($registration_status=="errors"):?>
<p style="color:red">Пароли должны совпадать!</p>
<?elseif($registration_status=="empty"):?>
<p style="color:red">Все поля должны быть заполнены!</p>
<?endif?>