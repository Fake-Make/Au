<h1>Создание аукциона</h1>
<form action="<?=$this->host?>/create" method="POST" enctype="multipart/form-data" class="flex-row login-form auction-box">
	<label class="login-label" for="file">Загрузите фотографию товара:</label>
	<input class="input-box login-input" type="file" name="file" id="file" <?=isset($_POST['file']) ? 'value="' . $_POST['file'] . '"' : ""?>>
	<label class="login-label" for="good-name">Введите название товара:</label>
	<input class="input-box login-input" type="text" name="good-name" id="good-name" placeholder="Apple IPhone SE" required <?=isset($_POST['good-name']) ? 'value="' . $_POST['good-name'] . '"' : ""?>>
	<label class="login-label" for="good-description">Опишите товар:</label>
	<textarea class="input-box login-input" rows="10" name="good-description" id="good-description" placeholder="В идеальном состоянии."><?=isset($_POST['good-description']) ? $_POST['good-description'] : ""?></textarea>
	<label class="login-label" for="good-initRate">Введите начальную ставку:</label>
	<input class="input-box login-input" type="number" name="good-initRate" min="0" step="0.01" id="good-initRate" placeholder="6000" required <?=isset($_POST['good-initRate']) ? 'value="' . $_POST['good-initRate'] . '"' : ""?>>
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
<?elseif($creating_status=="photoError"):?>
<p style="color:red">Ошибка загрузки фотографии!</p>
<?endif?>