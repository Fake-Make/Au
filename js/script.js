function decTime(time) {
  //Разбиение
  var h = time.split(":")[0];
  var m = time.split(":")[1];
  var i = time.split(":")[2];
  
  // Функция для вычета одного поля
  function dec (str) {
    a = str[0];
    b = str[1];
    if(0 == b) {
      if (a == 0)
        return "59";
      a--;
      b = "9";
    } else {
      b--;
    }
    return a + b;
  }
  
  function decH (str) {
    if (+str > 10)
      return str - 1;
    else
      return dec (str);
  }
  
  // Логика вычитания
  i = dec(i);
  if(i === "59") {
    m = dec(m);
    if(m === "59") {
      h = decH(h);
      if(h === "59")
        return "00:00:00"
    }
  }
        
  return h + ":" + m + ":" + i;
}
console.log(decTime("13:59:10"));

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
	$('.auction-timered').each(function(){
		var t = $(this).find('.auction-exp-time').text();
		$(this).find('.auction-exp-time').text(decTime(t));
	});
}

// Функция для смены надписей у пагинатора на стрелки
function paginatorFix() {
	if($(window).width() > 700) {
		// Появление текста у пагинатора
		$('.paginator__elem_prev a').text('Предыдущая страница').removeClass('paginator__arrow paginator__arrow_left');
		$('.paginator__elem_next a').text('Следующая страница').removeClass('paginator__arrow paginator__arrow_right');
	} else {
		// Скрытие лишнего текста у пагинатора
		$('.paginator__elem_prev a').html('&#9668;').addClass('paginator__arrow paginator__arrow_left');
		$('.paginator__elem_next a').html('&#9658;').addClass('paginator__arrow paginator__arrow_right');
	}	
}

// Установка таймера для вычисления срока окончания аукционов
setInterval(timers, 1000);

// Назначение элементам событий после загрузки документа
$(function () {
	// Починка флекс-отображения пагинатора и аукционов при загрузке страницы
	paginatorFix();
	flexFix();

	// Настройка отображения при изменении размеров экрана
	$(window).resize(function () {
		paginatorFix();
		flexFix();
	});
});