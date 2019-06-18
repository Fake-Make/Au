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
<?if("created"===$tab || "active" === $tab):?>
	<?if('empty' === $auctions_status):?>
		<?if("created"===$tab):?>
			<p style="color: #09f">У вас пока нет ни одного созданного аукциона.</p>
		<?elseif("active" === $tab):?>
			<p style="color: #09f">Вы пока не участвуете ни в одном аукционе.</p>
		<?endif?>
	<?else:?>
	<ul class="flex-row auctions">
		<?foreach($aucs as $item):?>
			<?
				if(empty($item['photo']) || $item['photo'] == "NULL" || is_null($item['photo']))
					$item['photo'] = "photos/box.png";
				$t = strtotime($item['date']) - time();
				if($t >= 0) {
					$H = intdiv($t, 3600);
					$t = "$H:" . date("i:s", $t);
				} else {
					$t = "00:00:00";
				}
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
					<p>Оставшееся время: <span class="auction-exp-time"><?=$t?></span></p>
				</a>
			</li>
		<?endforeach?>
	</ul>
	<?=makePaginator(PAGINATOR_ELEMENTS, $page, $maxPages)?>
	<?endif?>
<?elseif("dialogs"===$tab):?>
	<?if("empty" === $dialogs_status):?>
		<p style="color: #09f">У вас пока нет ни одного диалога.</p>
	<?else:?>
		<ul class="auction-box dialog-list">
			<?foreach($dials as $item):?>
				<?$photo = empty($item['photo']) || $item['photo'] == "NULL" || is_null($item['photo']) ? "photos/box.png" : $item['photo']?>
				<li class="dialog-list__item">
					<a class="flex-row dialog-list__link" href="<?=$this->host?>/dialog/id=<?=$item['id']?>">
						<img class="user-image dialog__user-image" src="<?=$this->host?>/<?=$photo?>" alt="Фото пользователя">
						<div class="flex-row dialog-preview">
							<span class="dialog-preview__name"><?=$item['name']?></span>
							<span class="dialog-preview__time"><?=date("H:m", $item['lastUpdate'])?></span>
							<p class="dialog-preview__message"><?=$item['lastMessage']?></p>
						</div>
					</a>
				</li>
			<?endforeach?>
		</ul>
	<?endif?>
<?endif?>
