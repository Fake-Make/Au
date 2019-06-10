// Функция для вычитания секунды из строки
// со временем формата HH:mm:ii
function decTime(time) {
  //Разбиение строки на составляющие
  var h = time.split(":")[0];
  var m = time.split(":")[1];
  var i = time.split(":")[2];
  
  // Функция для вычета секунды из одного поля
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
	
	// Функция для вычета часа (их может быть больше 60)
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

// Функция для добавления псевдоэлементов в списки
// Необходимо для сеточного отображения списков аукционов
function flexFix() {
	var w = $(window).width(), n;
	// В зависимости от ширины окна на нём может отображаться 
	// до трёх элементов списка
	switch(true) {
		case 800 < w:
			n = 3; break;
		case 480 < w:
			n = 2; break;
		case 480 > w:
			n = 1; break;
	}

	// Перед запуском удаляются существующие псевдо-элементы
	$('.auction.hidden').remove();
	// Если количество элементов не кратно n, то дополняется до кратности n
	while ($('ul.auctions').children().length % n)
		$('ul.auctions').append('<li class="flex-column auction auction-box hidden"></li>');
}

// Функция для изменения времени на табличках с таймерами
function timers() {
	$('.auction-timered').each(function(){
		var t = $(this).find('.auction-exp-time').text();
		$(this).find('.auction-exp-time').text(decTime(t));
	});
}

// Функция для смены надписей у пагинатора на стрелки
// При переходе в мобильный режим просмотра
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

// Установка таймера для динамического отображения
// убывания срока действия аукционов
setInterval(timers, 1000);

// Действия скрипта после загрузки документа
$(function () {
	// Исправление некорректного отображения при загруке документа
	paginatorFix();
	flexFix();

	// Исправление некорректного отображения при изменении размеров окна
	$(window).resize(function () {
		paginatorFix();
		flexFix();
	});
});