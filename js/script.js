// Функция для исправления отображения флекс-бокса
function flexFix() {
	var w = $(window).width(), n;
	switch(true) {
		case 800 < w:
			n = 3; break;
		case 480 < w:
			n = 2; break;
		case 480 > w:
			n = 1; break;
	}

	// Перед запуском удаляются лишние фикс-элементы
	$('.auction.hidden').remove();
	// Если количество элементов не кратно n, то дополняется до кратности n
	while ($('ul.auctions').children().length % n)
		$('ul.auctions').append('<li class="auction hidden"></li>');
}

// Функция для изменения времени на табличках с таймерами
function timers() {
	$('.auction').each(function(){
		var t = $(this).find('.auction-exp-time__timestamp')[0].textContent;
		t--;
		var date = new Date(t * 1000);
		var hours = date.getHours() - 7;
		var minutes = "00" + date.getMinutes();
		var seconds = "00" + date.getSeconds();
		var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
		$(this).find('.auction-exp-time').text(formattedTime);
		$(this).find('.auction-exp-time__timestamp').text(t);
	});
}

// Функция для смены надписей у пагинатора на стрелки
function paginatorFix() {
	if($(window).width() > phoneSize) {
		// Появление текста у пагинатора
		$('.paginator__elem_prev a').text('Предыдущая страница').removeClass('paginator__arrow paginator__arrow_left');
		$('.paginator__elem_next a').text('Следующая страница').removeClass('paginator__arrow paginator__arrow_right');
	} else {
		// Скрытие лишнего текста у пагинатора
		$('.paginator__elem_prev a').text('  ').addClass('paginator__arrow paginator__arrow_left');
		$('.paginator__elem_next a').text('  ').addClass('paginator__arrow paginator__arrow_right');
	}	
}
setInterval(timers, 1000);
// Назначение элементам событий после загрузки документа
$(function () {
	// Починка флекс-отображения пагинатора и аукционов при загрузке страницы
	//paginatorFix();
	flexFix();

	// Настройка отображения при изменении размеров экрана
	$(window).resize(function () {
		//paginatorFix();
		flexFix();
	});
});