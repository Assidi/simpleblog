<?php

/**
 * @author Assidi
 * @copyright 2017
 */

class Helper {
    /**
	 * Заменяет переводы строки на <br> 
	 * @param текст
	 * @return текст с переводами строк для вывода на экран
	 */
	static function insertBreakes($text) {
		$newtext = preg_replace('/[\r\n]+/', "<br />", $text);
		return $newtext;
	} 
        
	/**
	 * форматирует дату из системной 
	 * @param $date системная дата
	 * @return нормальная дата и время для вывода на экран
	 */
    static function dateFormat($date) {
        $datetime = date("d.m.Y H:i", $date);
        return $datetime;
    }
}

?>