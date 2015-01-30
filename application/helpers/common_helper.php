<?php
/**
* Copyright (c) 2014 P. Antoha (p.antoha88@gmail.com || r.linker88@gmail.com)
* 
* @license MIT
* @license GNU GENERAL PUBLIC LICENSE
* 
* @author Park Anton Chun Kvanovich
* 
* 
* 
* If you did not receive a copy of the 
* PHP license, or have any questions about PHP licensing, 
* please contact license@php.net.
* 
* 
* 
* All rights reserved.
*/

// Жесткая фильтрация входных данных
function filter_varible($varible){
	$varible=html_escape($varible);
	$varible=htmlspecialchars($varible);
	$varible=strip_slashes($varible);
	$varible=strip_tags($varible);
	$varible=trim($varible);
	return $varible;
}
// Жестка фильтрация масивоа данных
function filter_varible_array($array){
	$return_array=array();
	foreach($array as $key=>$row){
		$return_array[$key]=filter_varible($row);
	};
	return $return_array;
}
// Функция асинхронного выполнения задачи
function exec_script($url, $params = array()){
	$parts = parse_url($url);
	if (!$fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80)){
		return false;
	}
	$data = http_build_query($params, '', '&');
	fwrite($fp, "POST " . (!empty($parts['path']) ? $parts['path'] : '/') . " HTTP/1.1\r\n");
	fwrite($fp, "Host: " . $parts['host'] . "\r\n");
	fwrite($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
	fwrite($fp, "Content-Length: " . strlen($data) . "\r\n");
	fwrite($fp, "Connection: Close\r\n\r\n");
	fwrite($fp, $data);
	fclose($fp);
	return true;
}
// Отческа стилей в входящей почте
function ClearStyle($string){
	return preg_replace("#<style>.*</style>#Us", "", $string);
}
// Транслит курилици и обратно
function GetInTranslit($string){
	$translit = array(
		'а' => 'a',   'б' => 'b',   'в' => 'v',
		'г' => 'g',   'д' => 'd',   'е' => 'e',
		'ё' => 'yo',  'ж' => 'zh',  'з' => 'z',
		'и' => 'i',   'й' => 'j',   'к' => 'k',
		'л' => 'l',   'м' => 'm',   'н' => 'n',
		'о' => 'o',   'п' => 'p',   'р' => 'r',
		'с' => 's',   'т' => 't',   'у' => 'u',
		'ф' => 'f',   'х' => 'x',   'ц' => 'c',
		'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh',
		'ь' => "'",   'ы' => 'y',   'ъ' => "''",
		'э' => "e'",  'ю' => 'yu',  'я' => 'ya',
		'А' => 'A',   'Б' => 'B',   'В' => 'V',
		'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
		'Ё' => 'YO',  'Ж' => 'Zh',  'З' => 'Z',
		'И' => 'I',   'Й' => 'J',   'К' => 'K',
		'Л' => 'L',   'М' => 'M',   'Н' => 'N',
		'О' => 'O',   'П' => 'P',   'Р' => 'R',
		'С' => 'S',   'Т' => 'T',   'У' => 'U',
		'Ф' => 'F',   'Х' => 'X',   'Ц' => 'C',
		'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SHH',
		'Ь' => "'",   'Ы' => "Y'",  'Ъ' => "''",
		'Э' => "E'",  'Ю' => 'YU',  'Я' => 'YA'
	);
	//$word = strtr('prochee', array_flip($translit));
	return $word = strtr($string, $translit); 
}
?>