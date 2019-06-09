<?extract($data)?>
<h1>Диалог с пользователем <a href="<?=$this->host?>/personal/id=<?=$person?>"><?=$personName?></a></h1>
<section class="flex-column auction-box dialog-window">
	<?if("Not exists" === $dialog_status):?>
		<p style="color: #09f">В диалоге ещё нет сообщений.</p>
	<?else:?>
		<ul class="dialog-messages">
			<?foreach($chat as $item):?>
				<?if($item['reciever'] === $user):?>
					<li class="message message__recieved">
				<?else:?>
					<li class="message message__sent">
				<?endif?>
				<?=$item['text']?>
				</li>
			<?endforeach?>
		</ul>
	<?endif?>	
	<form class="flex-row dialog-control" method="POST" action="<?=$this->host?>/dialog/send<?=$id ? "=$id" : ""?>/person=<?=$person?>">
		<textarea class="input-box dialog-input" name="dialog-message" placeholder="Написать сообщение" required></textarea>
		<input class="button dialog-send" type="submit" value="Отправить">
	</form>
</section>