<?require_once("templates/header.php")?>
<h1 class="invisible">Просмотр аукциона</h1>
<section class="flex-row auction-box auction-product">
	<div class="flex-column product-image-box">
		<h2>Компьютерная мышь bloody A4Tech</h2>
		<img class="product-image" src="img/box.png" alt="product">
	</div>
	<section class="flex-column product-description">
		<p>
			Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
		</p>
		<p>
			It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
		</p>
		<div class="flex-row product-control">
			<p class="product-control__elem product-control__bet">Текущая ставка: <span>400</span>руб.</p>
			<a class="button product-control__elem" href="dialog.php">Написать организатору</a>
			<!--Если пользователь уже сделал ставку, то пусть топает домой-->
			<form class="flex-row product-control__cost-form" action="auction.php">
				<!--Добавить минимальное значение как $текущаяСтавка + $минимальныйШаг-->
				<input class="input-box product-control__elem" type="number" placeholder="Ваша ставка">
				<!--Это же значение подставить в значение поля-->
				<input class="button button__disabled product-control__elem" type="submit" value='Сделать ставку'>
			</form>
		</div>
	</section>
</section>
<?require_once("templates/footer.php")?>