<h1>Вход</h1>
<form class="flex-row login-form auction-box" action="" method="POST">
	<label class="login-label" for="login-name">Логин: </label>
	<input class="input-box login-input" type="text" name="login-name" id="login-name" placeholder="Логин" required pattern="[a-zA-Zа-яА-Я0-9]{2,64}">
	<label class="login-label" for="login-password">Пароль: </label>
	<input class="input-box login-input" type="password" name="login-password" id="login-password" placeholder="Пароль" required pattern="[a-zA-Z0-9 ]{6,24}">
	<input class="button login-submit" type="submit" value="Войти">
	<a class="button login-submit" href="/~administrator/Au/registration">Регистрация</a>
</form>
<?extract($data); ?>
<?if($login_status=="access_granted"):?>
<p style="color:green">Авторизация прошла успешно.</p>
<?elseif($login_status=="access_denied"):?>
<p style="color:red">Логин и/или пароль введены неверно.</p>
<?endif?>