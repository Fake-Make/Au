<h1>Создание аукциона</h1>
<form action="<?=$this->host?>/create" method="POST" class="flex-row login-form auction-box">
	<label class="login-label" for="good-photo">Загрузите фотографию товара:</label>
	<input class="input-box login-input" type="file" name="good-photo" id="good-photo">
	<label class="login-label" for="good-name">Введите название товара:</label>
	<input class="input-box login-input" type="text" name="good-name" id="good-name" placeholder="Apple IPhone SE" required>
	<label class="login-label" for="good-description">Опишите товар:</label>
	<textarea class="input-box login-input" rows="10" name="good-description" id="good-description" placeholder="В идеальном состоянии."></textarea>
	<label class="login-label" for="good-initRate">Введите начальную ставку:</label>
	<input class="input-box login-input" type="number" name="good-initRate" min="0" step="0.01" id="good-initRate" placeholder="6000" required>
	<label class="login-label" for="good-date">Выберите срок проведения аукциона:</label>
	<select class="input-box login-input" name="good-date" id="good-date">
		<option value="12">12 часов</option>
		<option value="24">24 часа</option>
		<option value="72">3 дня</option>
		<option value="168">Неделя</option>
		<option value="336">2 недели</option>
	</select>
	<input class="button create__button" type="submit" value="Создать">
	<button class="button create__button" type="reset">Очистить поля</button>
</form>
<?extract($data)?>
<?if($creating_status=="success"):?>
<p style="color:green">Ваш лот был успешно размещён!</p>
<?elseif($creating_status=="empty"):?>
<p style="color:red">Поля "Название товара" и "Начальная ставка" должны быть заполнены!</p>
<?elseif($creating_status=="errors"):?>
<p style="color:red">Что-то пошло не так</p>
<?endif?>