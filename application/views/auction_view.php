<?extract($data)?>
<?//print_r($auction)
	$ph = $auction['photo'];
	$alt = "Фотография товара";
	if(is_null($ph) || $ph === "NULL" || $ph === "") {
		$ph = "img/box.png";
		$alt = "Изображение отсутствует";
	}
	$auction['date'] = strtotime($auction['date']) - time();
?>
<h1 class="invisible">Просмотр аукциона</h1>
<section class="flex-row auction-box auction-product auction-timered">
	<div class="flex-column product-image-box">
		<h2><?=$auction['name']?></h2>
		<img class="product-image" src="<?=$this->host?>/<?=$ph?>" alt="<?=$alt?>">
		<p>Оставшееся время: <span class="auction-exp-time"><?=date("H:i:s", $auction['date'])?></span></p>
		<p>Организатор: <?=$auction['ownerName']?></p>
		<p class="auction-exp-time__timestamp" hidden><?=$item['date']?></p>
	</div>
	<section class="flex-column product-description">
		<p class="product-description__text">
			<?=$auction['description']?>
		</p>
		<div class="flex-row product-control">
			<p class="product-control__elem product-control__bet">
				<?if(is_null($auction['curRate'])):?>
					Начальная ставка: <span style="color: #0d6; font-size: 20px; font-weight: bold; line-height: 25px;"><?=$auction['initRate']?>&#8381;</span>
				<?else:?>
					Текущая ставка: <span style="color: #4af; font-size: 20px; font-weight: bold; line-height: 25px;"><?=$auction['curRate']?>&#8381;</span>
				<?endif?>	
			</p>
			
			<a class="button product-control__elem" href="<?=$this->host?>/dialog/<?=$auction['ownerId']?>/<?=$user?>">Написать организатору</a>
			<!--Если пользователь уже сделал ставку, то пусть топает домой-->
			<form class="flex-row product-control__cost-form" method="POST" action="<?=$_SERVER['REQUEST_URI']?>">
				<!--Добавить минимальное значение как $текущаяСтавка + $минимальныйШаг-->
				<input name="rise" class="input-box product-control__elem" type="number" min="<?=$minRate + $minStep?>" step="0.5" value="<?=$minRate + $minStep?>" placeholder="Ваша ставка">
				<!--Это же значение подставить в значение поля-->
				<input class="button product-control__elem" type="submit" value="Сделать ставку" <?=$auction['ownerId'] === $user || $auction['lastMember'] === $user || is_null($user) ? "disabled" : ""?>>
			</form>
		</div>
	</section>
</section>