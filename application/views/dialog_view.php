<!--Если не залогинен, отправляем на вход-->
<h1>Диалог с пользователем <a href="/~administrator/Au/personal">Антон Иванович</a></h1>
<section class="flex-column auction-box dialog-window">
	<ul class="dialog-messages">
		<li class="message message__sent">
			Привет. Я хотел бы спросить, как долго работала ваша мышь?
		</li>
		<li class="message message__recieved">
			Привет. Не очень долго. А что?
		</li>
		<li class="message message__sent">
			А вот ничего. Не хочу теперь вашу мышь покупать.
		</li>
	</ul>
	<form class="flex-row dialog-control" action="/~administrator/Au/dialog">
		<textarea class="input-box dialog-input" name="dialog-message" placeholder="Написать сообщение"></textarea>
		<input class="button dialog-send" type="submit" value="Отправить">
	</form>
</section>