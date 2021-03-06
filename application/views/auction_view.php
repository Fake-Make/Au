<?extract($data)?>
<?
	$ph = $auction['photo'];
	$alt = "Фотография товара";
	if(is_null($ph) || $ph === "NULL" || $ph === "") {
		$ph = "img/box.png";
		$alt = "Изображение отсутствует";
	}
	$t = strtotime($auction['date']) - time();
	if($t >= 0) {
		$H = intdiv($t, 3600);
		$t = "$H:" . date("i:s", $t);
	} else {
		$t = "00:00:00";
	}

?>
<h1 class="invisible">Просмотр аукциона</h1>
<section class="flex-row auction-box auction-product auction-timered">
	<?if($auction['ownerId'] === $user && !is_null($user)):?>
		<a href="<?=$this->host?>/delete/id=<?=$id?>" class="delete-button" title="Удалить аукцион">&#10006;</a>
	<?endif?>
	<div class="flex-column product-image-box">
		<h2><?=$auction['name']?></h2>
		<img class="product-image" src="<?=$this->host?>/<?=$ph?>" alt="<?=$alt?>">
		<p>Оставшееся время: <span class="auction-exp-time"><?=$t?></span></p>
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
			
			<?if($auction['ownerId'] === $user || is_null($user)):?>
				<span class="button product-control__elem disabled">Написать организатору</span>
			<?else:?>
				<a class="button product-control__elem" href="<?=$this->host?>/dialog/person=<?=$auction['ownerId']?>/user=<?=$user?>">Написать организатору</a>
			<?endif?>
			<form class="flex-row product-control__cost-form" method="POST" action="<?=$_SERVER['REQUEST_URI']?>">
				<input name="rise" class="input-box product-control__elem" type="number" min="<?=$minRate + $minStep?>" step="0.5" value="<?=$minRate + $minStep?>" placeholder="Ваша ставка">
				<input class="button product-control__elem" type="submit" value="Сделать ставку" <?=$auction['ownerId'] === $user || $auction['lastMember'] === $user || is_null($user) ? "disabled" : ""?>>
				<?if('Error' === $riseStatus):?>
					<p style="color:red">Ошибка при повышении ставки!</p>
				<?endif?>
			</form>
		</div>
	</section>
</section>
