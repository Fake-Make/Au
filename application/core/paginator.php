<?php
	// Конструктор пагинатора
	function makePaginator($show, $cur, $max) {
		$thisScript = $_SERVER['REQUEST_URI'];
		if(0 === preg_match("!/page=!", $thisScript))
			$thisScript .= "/page=1";
		// Количество отображаемых элементов в пагинаторе
		$shift = ($show - 1) / 2;
		$paginatorHtml = "";
		$paginatorHtml .=
			'<ul class="flex-row paginator catalog-page__paginator">' .
				'<li class="paginator__elem paginator__elem_prev">'
					. ($cur != 1 ? '<a href="' . preg_replace("!page=(\d+)!", "page=" . ($cur - 1), $thisScript) .
					'" class="paginator__link">Предыдущая страница</a>' : '') .
				'</li>';
		
		// Мы слишком слева
		if ($cur - $shift < 1) {
			if ($show > $max)
				$show = $max;
			for ($i = 1; $i <= $show; $i++) {
				if ($i === $cur)
					$paginatorHtml .= '<li class="paginator__elem paginator__elem_current"><span class="paginator__link">' . $i . '</span></li>';
				else
					$paginatorHtml .= '<li class="paginator__elem"><a href="' . preg_replace("!page=(\d+)!", "page=$i", $thisScript) . '" class="paginator__link">' . $i . '</a></li>';
			}
		}	
		// Мы слишком справа
		elseif ($cur + $shift > $max) {
			$left = $max - $show + 1;
			if ($left < 1)
				$left = 1;
			for ($i = $left; $i <= $max; $i++) {
				if ($i === $cur)
					$paginatorHtml .= '<li class="paginator__elem paginator__elem_current"><span class="paginator__link">' . $i . '</span></li>';
				else
					$paginatorHtml .= '<li class="paginator__elem"><a href="' . preg_replace("!page=(\d+)!", "page=$i", $thisScript) . '" class="paginator__link">' . $i . '</a></li>';
			}
		} 
		// Мы где-то в центре
		else {
			if ($show > $max)
				$show = $max;
			$left = $cur - $shift;
			$right = $left + $show;
			for ($i = $left; $i < $right; $i++) {
				if ($i === $cur)
					$paginatorHtml .= '<li class="paginator__elem paginator__elem_current"><span class="paginator__link">' . $i . '</span></li>';
				else
					$paginatorHtml .= '<li class="paginator__elem"><a href="' . preg_replace("!page=(\d+)!", "page=$i", $thisScript) . '" class="paginator__link">' . $i . '</a></li>';
			}
		}
		$paginatorHtml .=
				'<li class="paginator__elem paginator__elem_next">' .
					($cur != $max ? '<a href="' . preg_replace("!page=(\d+)!", "page=" . ($cur + 1), $thisScript) . '" class="paginator__link">Следующая страница</a>' : '') .
				'</li>
			</ul>';
		return $paginatorHtml;
	}