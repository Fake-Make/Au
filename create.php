<?require_once("templates/header.php")?>
<h1>Создание аукциона</h1>
<form action="create.php" class="flex-row login-form auction-box">
	<label class="login-label" for="">Загрузите фотографию товара:</label>
	<input class="input-box login-input" type="file">
	<label class="login-label" for="">Введите название товара:</label>
	<input class="input-box login-input" type="text" name="" id="">
	<label class="login-label" for="">Опишите товар:</label>
	<textarea class="input-box login-input" name="" id=""></textarea>
	<label class="login-label" for="">Введите начальную ставку:</label>
	<input class="input-box login-input" type="number">
	<label class="login-label" for="">Выберите срок проведения аукциона:</label>
	<select class="input-box login-input" name="" id="">
		<option value="6">6 часов</option>
		<option value="12">12 часов</option>
		<option value="24">24 часов</option>
		<option value="48">48 часов</option>
	</select>
	<input class="button" type="submit" value="Создать">
	<button class="button" type="reset">Очистить поля</button>
</form>
<?require_once("templates/footer.php")?>