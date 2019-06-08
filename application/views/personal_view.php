<?$tab=empty($_GET["tab"]) ? 1 : $_GET["tab"]?>
<h1 class="invisible">Страница пользователя</h1>
<header class="flex-row">
	<nav class="flex-column auction-box personal-nav">
		<ul class="flex-row tabs">
			<li class="tab"><a href="<?=$this->host?>/personal">Участие в аукционах</a></li>
			<li class="tab"><a href="<?=$this->host?>/personal/created">Проведение аукционов</a></li>
			<li class="tab"><a href="<?=$this->host?>/personal/dialogs">Диалоги</a></li>
			<li class="tab"><a href="<?=$this->host?>/create">Организовать аукцион</a></li>
		</ul>
	</nav>
</header>
<?if("created"===$tab):?>
	<ul class="flex-row auctions">
		<li class="flex-column auction auction-box">
			<a class="flex-column auction__link" href="<?=$this->host?>/auction">
				<img class="auction-image__listed" src="<?=$this->host?>/img/box.png" alt="auction" width="100px">
				<p>Клавиатура Logitech</p>
				<p>Текущая ставка: <span style="color: red">500</span>&#8381;</p>
				<p>Оставшееся время: <span>05:49:53</span></p>
			</a>
		</li>
		<li class="flex-column auction auction-box">
			<a class="flex-column auction__link" href="<?=$this->host?>/auction">
				<img class="auction-image__listed" src="img/box.png" alt="auction" width="100px">
				<p>Клавиатура Logitech</p>
				<p>Текущая ставка: <span>500</span>&#8381;</p>
				<p>Оставшееся время: <span>05:49:53</span></p>
			</a>
		</li>
		<li class="flex-column auction auction-box">
			<a class="flex-column auction__link" href="<?=$this->host?>/auction">
				<img class="auction-image__listed" src="img/box.png" alt="auction" width="100px">
				<p>Клавиатура Logitech</p>
				<p>Текущая ставка: <span>500</span>&#8381;</p>
				<p>Оставшееся время: <span>05:49:53</span></p>
			</a>
		</li>
		<li class="flex-column auction auction-box" style="background:#999">
			<a class="flex-column auction__link" href="<?=$this->host?>/auction">
				<img class="auction-image__listed" src="img/box.png" alt="auction" width="100px">
				<p>Клавиатура Logitech</p>
				<p>Текущая ставка: <span style="color: red">500</span>&#8381;</p>
				<p>Оставшееся время: <span>05:49:53</span></p>
			</a>
		</li>
		<li class="flex-column auction auction-box" style="background:red">
			<a class="flex-column auction__link" href="<?=$this->host?>/auction">
				<img class="auction-image__listed" src="img/box.png" alt="auction" width="100px">
				<p>Клавиатура Logitech</p>
				<p>Текущая ставка: <span>500</span>&#8381;</p>
				<p>Оставшееся время: <span>05:49:53</span></p>
			</a>
		</li>
		<li class="flex-column auction auction-box" style="background:green">
			<a class="flex-column auction__link" href="<?=$this->host?>/auction">
				<img class="auction-image__listed" src="img/box.png" alt="auction" width="100px">
				<p>Клавиатура Logitech</p>
				<p>Текущая ставка: <span style="color: red">500</span>&#8381;</p>
				<p>Оставшееся время: <span>05:49:53</span></p>
			</a>
		</li>
	</ul>
<?elseif("dialogs"===$tab):?>
	<ul class="auction-box dialog-list">
		<li class="dialog-list__item">
			<a class="flex-row dialog-list__link" href="<?=$this->host?>/dialog">
				<img class="user-image dialog__user-image" src="<?=$this->host?>/img/box.png" alt="Фото пользователя">
				<div class="flex-row dialog-preview">
					<span class="dialog-preview__name">Another User</span>
					<span class="dialog-preview__time">22:41</span>
					<p class="dialog-preview__message">Слушай, хлопец, ты покупать собираешься или нет?</p>
				</div>
			</a>
		</li>
		<li class="dialog-list__item">
			<a class="flex-row dialog-list__link" href="<?=$this->host?>/dialog">
				<img class="user-image dialog__user-image" src="img/box.png" alt="Фото пользователя">
				<div class="flex-row dialog-preview">
					<span class="dialog-preview__name">Вася Петров</span>
					<span class="dialog-preview__time">23:41</span>
					<p class="dialog-preview__message">Я передумал.</p>
				</div>
			</a>
		</li>
		<li class="dialog-list__item">
			<a class="flex-row dialog-list__link" href="<?=$this->host?>/dialog">
				<img class="user-image dialog__user-image" src="img/box.png" alt="Фото пользователя">
				<div class="flex-row dialog-preview">
					<span class="dialog-preview__name">Петя Васильевич</span>
					<span class="dialog-preview__time">12:41</span>
					<p class="dialog-preview__message">Нашёл дешевле, до свидания.</p>
				</div>
			</a>
		</li>
		<li class="dialog-list__item">
			<a class="flex-row dialog-list__link" href="<?=$this->host?>/dialog">
				<img class="user-image dialog__user-image" src="img/box.png" alt="Фото пользователя">
				<div class="flex-row dialog-preview">
					<span class="dialog-preview__name">Дмитрий Топотухин</span>
					<span class="dialog-preview__time">21:21</span>
					<p class="dialog-preview__message">Скинете ещё 2 тысячи?</p>
				</div>
			</a>
		</li>
		<li class="dialog-list__item">
			<a class="flex-row dialog-list__link" href="<?=$this->host?>/dialog">
				<img class="user-image dialog__user-image" src="img/box.png" alt="Фото пользователя">
				<div class="flex-row dialog-preview">
					<span class="dialog-preview__name">Пользователь</span>
					<span class="dialog-preview__time">10:13</span>
					<p class="dialog-preview__message">Слушай, хлопец, ты покупать собираешься или нет? Я вообще как считаю? А я никак не считаю, мне надоело ждать, пока ты ответишь, уууухххх.</p>
				</div>
			</a>
		</li>
		<li class="dialog-list__item">
			<a class="flex-row dialog-list__link" href="<?=$this->host?>/dialog">
				<img class="user-image dialog__user-image" src="img/box.png" alt="Фото пользователя">
				<div class="flex-row dialog-preview">
					<span class="dialog-preview__name">Dmitry Nevada</span>
					<span class="dialog-preview__time">11:11</span>
					<p class="dialog-preview__message">Слушай, хлопец, ты покупать собираешься или нет?</p>
				</div>
			</a>
		</li>
		<li class="dialog-list__item">
			<a class="flex-row dialog-list__link" href="<?=$this->host?>/dialog">
				<img class="user-image dialog__user-image" src="img/box.png" alt="Фото пользователя">
				<div class="flex-row dialog-preview">
					<span class="dialog-preview__name">Another User</span>
					<span class="dialog-preview__time">22:41</span>
					<p class="dialog-preview__message">Слушай, хлопец, ты покупать собираешься или нет?</p>
				</div>
			</a>
		</li>
		<li class="dialog-list__item">
			<a class="flex-row dialog-list__link" href="<?=$this->host?>/dialog">
				<img class="user-image dialog__user-image" src="img/box.png" alt="Фото пользователя">
				<div class="flex-row dialog-preview">
					<span class="dialog-preview__name">Вася Петров</span>
					<span class="dialog-preview__time">23:41</span>
					<p class="dialog-preview__message">Я передумал.</p>
				</div>
			</a>
		</li>
		<li class="dialog-list__item">
			<a class="flex-row dialog-list__link" href="<?=$this->host?>/dialog">
				<img class="user-image dialog__user-image" src="img/box.png" alt="Фото пользователя">
				<div class="flex-row dialog-preview">
					<span class="dialog-preview__name">Петя Васильевич</span>
					<span class="dialog-preview__time">12:41</span>
					<p class="dialog-preview__message">Нашёл дешевле, до свидания.</p>
				</div>
			</a>
		</li>
		<li class="dialog-list__item">
			<a class="flex-row dialog-list__link" href="<?=$this->host?>/dialog">
				<img class="user-image dialog__user-image" src="img/box.png" alt="Фото пользователя">
				<div class="flex-row dialog-preview">
					<span class="dialog-preview__name">Дмитрий Топотухин</span>
					<span class="dialog-preview__time">21:21</span>
					<p class="dialog-preview__message">Скинете ещё 2 тысячи?</p>
				</div>
			</a>
		</li>
		<li class="dialog-list__item">
			<a class="flex-row dialog-list__link" href="<?=$this->host?>/dialog">
				<img class="user-image dialog__user-image" src="img/box.png" alt="Фото пользователя">
				<div class="flex-row dialog-preview">
					<span class="dialog-preview__name">Пользователь</span>
					<span class="dialog-preview__time">10:13</span>
					<p class="dialog-preview__message">Слушай, хлопец, ты покупать собираешься или нет? Я вообще как считаю? А я никак не считаю, мне надоело ждать, пока ты ответишь, уууухххх.</p>
				</div>
			</a>
		</li>
		<li class="dialog-list__item">
			<a class="flex-row dialog-list__link" href="<?=$this->host?>/dialog">
				<img class="user-image dialog__user-image" src="img/box.png" alt="Фото пользователя">
				<div class="flex-row dialog-preview">
					<span class="dialog-preview__name">Dmitry Nevada</span>
					<span class="dialog-preview__time">11:11</span>
					<p class="dialog-preview__message">Слушай, хлопец, ты покупать собираешься или нет?</p>
				</div>
			</a>
		</li>
	</ul>
<?else:?>
	<ul class="flex-row auctions">
		<li class="flex-column auction auction-box">
			<a class="flex-column auction__link" href="<?=$this->host?>/auction">
				<img class="auction-image__listed" src="<?=$this->host?>/img/box.png" alt="auction" width="100px">
				<p>Клавиатура Logitech</p>
				<p>Текущая ставка: <span style="color: red">500</span>&#8381;</p>
				<p>Оставшееся время: <span>05:49:53</span></p>
			</a>
		</li>
		<li class="flex-column auction auction-box">
			<a class="flex-column auction__link" href="<?=$this->host?>/auction">
				<img class="auction-image__listed" src="img/box.png" alt="auction" width="100px">
				<p>Клавиатура Logitech</p>
				<p>Текущая ставка: <span>500</span>&#8381;</p>
				<p>Оставшееся время: <span>05:49:53</span></p>
			</a>
		</li>
		<li class="flex-column auction auction-box">
			<a class="flex-column auction__link" href="<?=$this->host?>/auction">
				<img class="auction-image__listed" src="img/box.png" alt="auction" width="100px">
				<p>Клавиатура Logitech</p>
				<p>Текущая ставка: <span>500</span>&#8381;</p>
				<p>Оставшееся время: <span>05:49:53</span></p>
			</a>
		</li>
		<li class="flex-column auction auction-box" style="background:#999">
			<a class="flex-column auction__link" href="<?=$this->host?>/auction">
				<img class="auction-image__listed" src="img/box.png" alt="auction" width="100px">
				<p>Клавиатура Logitech</p>
				<p>Текущая ставка: <span style="color: red">500</span>&#8381;</p>
				<p>Оставшееся время: <span>05:49:53</span></p>
			</a>
		</li>
		<li class="flex-column auction auction-box" style="background:red">
			<a class="flex-column auction__link" href="<?=$this->host?>/auction">
				<img class="auction-image__listed" src="img/box.png" alt="auction" width="100px">
				<p>Клавиатура Logitech</p>
				<p>Текущая ставка: <span>500</span>&#8381;</p>
				<p>Оставшееся время: <span>05:49:53</span></p>
			</a>
		</li>
		<li class="flex-column auction auction-box" style="background:green">
			<a class="flex-column auction__link" href="<?=$this->host?>/auction">
				<img class="auction-image__listed" src="img/box.png" alt="auction" width="100px">
				<p>Клавиатура Logitech</p>
				<p>Текущая ставка: <span style="color: red">500</span>&#8381;</p>
				<p>Оставшееся время: <span>05:49:53</span></p>
			</a>
		</li>
	</ul>
<?endif?>