<?php
// Пользовательский класс с методами для валидации данных различного типа
class validator {
	// Возвращает XSS-безопасную входную строку, если она содержит хотя бы один непробельный символ
	// Иначе возвращает NULL
	static function validAnyString($str) {
		return strlen(trim($str)) ? htmlspecialchars($str) : NULL;
	}

	// Возвращает натуральное число, если его возможно получить из строки
	// Иначе возвращает 1
	static function validNaturalNumber($num) {
		return ($num = intval($num)) < 1 ? 1 : $num;
	}

	// Возвращает неотрицательное вещественное число в виде строки, если его возможно получить
	// Иначе возвращает 0
	static function validPositiveFloat($num) {
		return round(($num = floatval($num)) < 0 ? 0 : $num, 2);
	}

	// Возвращает валидный email, если возможно такое преобразование
	// Иначе возвращает NULL
	static function validEmail($str) {
		$str = trim($str);
		return preg_match("!^[A-Za-z0-9]+(\.[A-Za-z0-9]+)*@[A-Za-z0-9]+(\.[A-Za-z0-9]+)*$!", $str) ? $str : NULL;
	}
	
	// Возвращает валидный номер телефона, если возможно такое преобразование
	// Иначе возвращает NULL
	static function validPhone($str) {
		$symbols = ["+", "-", "(", ")"];
		$str = str_replace($symbols, "", trim($str));
		return preg_match("!^[0-9]{11,13}$!", $str) ? $str : NULL;
	}
}