<h1 class="invisible">Просмотр всех аукционов</h1>
<?extract($data)?>
<?if($auctions_status === "empty"):?>
	<p style="color: #09f">Список аукционов пока пуст :(<br>
	Но вы можете это <a style="text-decoration: underline" href="<?=$this->host?>/create">исправить</a>...</p>
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
