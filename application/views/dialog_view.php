<?extract($data)?>
<h1>Диалог с пользователем <a href="<?=$this->host?>/personal/id=<?=$person?>"><?=$personName?></a></h1>
<section class="flex-column auction-box dialog-window">
	<?if("Not exists" === $dialog_status):?>
		<p style="color: #09f">В диалоге ещё нет сообщений.</p>
	<?else:?>
		<ul class="dialog-messages">
			<!--Как только появится хотя бы один диалог, прикрутить его просмотр-->
			<?foreach($chat as $item):?>
				<?if($item['author'] === $user):?>
					<li class="message message__sent">
				<?else:?>
					<li class="message message__recieved">
				<?endif?>
				<?=$item['text']?>
				</li>
			<?endforeach?>
		</ul>
	<?endif?>	
	<form class="flex-row dialog-control" action="<?=$this->host?>/dialog/send">
		<textarea class="input-box dialog-input" name="dialog-message" placeholder="Написать сообщение"></textarea>
		<input class="button dialog-send" type="submit" value="Отправить">
		<!--Продумать-->
		<input hidden name="person" value="<?=$person?>">
	</form>
</section>