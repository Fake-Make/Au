<?require_once("templates/header.php")?>
<h1>Вход</h1>
<form class="flex-row login-form auction-box" action="index.php">
	<label class="login-label" for="login-name">Логин: </label>
	<input class="input-box login-input" type="text" name="login-name" id="login-name" placeholder="Логин">
	<label class="login-label" for="login-password">Пароль: </label>
	<input class="input-box login-input" type="password" name="login-password" id="login-password" placeholder="Пароль">
	<input class="button login-submit" type="submit" value="Войти">
	<a class="button login-submit" href="registration.php">Зарегестрироваться</a>
</form>
<?require_once("templates/footer.php")?>