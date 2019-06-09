<?extract($data)?>
<?$tab?>
<h1 class="invisible">Страница пользователя</h1>
<header class="flex-row">
	<nav class="flex-column auction-box personal-nav">
		<ul class="flex-row tabs">
			<li class="tab <?=$tab === 'active' ? "active" : ""?>"><a href="<?=$this->host?>/personal/active/page=1">Участие в аукционах</a></li>
			<li class="tab <?=$tab === 'created' ? "active" : ""?>"><a href="<?=$this->host?>/personal/created/page=1">Проведение аукционов</a></li>
			<li class="tab <?=$tab === 'dialogs' ? "active" : ""?>"><a href="<?=$this->host?>/personal/dialogs">Диалоги</a></li>
			<li class="tab"><a href="<?=$this->host?>/create">Организовать аукцион</a></li>
		</ul>
	</nav>
</header>
<?if("created"===$tab):?>
	<?if('empty' === $auctions_status):?>
		<p style="color: #09f">У вас пока нет ни одного созданного аукциона.</p>
	<?else:?>
	<ul class="flex-row auctions">
		<?foreach($aucs as $item):?>
			<?
				if(empty($item['photo']) || $item['photo'] == "NULL" || is_null($item['photo']))
					$item['photo'] = "photos/box.png";
				$item['date'] = strtotime($item['date']) - time();
			?>
			<li class="flex-column auction auction-box auction-timered">
				<a class="flex-column auction__link" href="<?=$this->host?>/auction/id=<?=$item['id']?>">
					<div class="flex-column auction__image-container"><img class="auction-image__listed" src="<?=$this->host?>/<?=$item['photo']?>" alt="auction_image" width="100%"></div>
					<div class="auction__name"><p><?=$item['name']?></p></div>
					<div class="auction__price">
						<?if(is_null($item['curRate'])):?>
							<p>Начальная ставка: <span style="color: #0d6"><?=$item['initRate']?>&#8381;</span></p>
						<?else:?>
							<p>Текущая ставка: <span style="color: #4af"><?=$item['curRate']?>&#8381;</span></p>
						<?endif?>
					</div>
					<p>Оставшееся время: <span class="auction-exp-time"><?=date("H:i:s", $item['date'])?></span></p>
					<p class="auction-exp-time__timestamp" hidden><?=$item['date']?></p>
				</a>
			</li>
		<?endforeach?>
	</ul>
	<?=makePaginator(PAGINATOR_ELEMENTS, $page, $maxPages)?>
	<?endif?>
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