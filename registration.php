<?require_once("templates/header.php")?>
<h1>Регистрация</h1>
<form class="flex-row login-form auction-box" action="index.php">
	<label class="login-label" for="registration-name">Введите имя: </label>
	<input class="input-box login-input" type="text" name="registration-name" id="registration-name" placeholder="Имя Фамилия">

	<label class="login-label" for="registration-email">Введите электронную почту: </label>
	<input class="input-box login-input" type="email" name="registration-email" id="registration-email" placeholder="user.2019@gmail.com">

	<label class="login-label" for="registration-password">Придумайте пароль: </label>
	<input class="input-box login-input" type="password" name="registration-password" id="registration-password" placeholder="Пароль">

	<label class="login-label" for="registration-password-again">Подтвердите пароль: </label>
	<input class="input-box login-input" type="password" name="registration-password-again" id="registration-password-again" placeholder="Пароль">

	<input class="button login-submit" type="submit" value="Зарегестрироваться">
	<a class="button login-submit" href="login.php">Войти</a>
</form>
<?require_once("templates/footer.php")?>