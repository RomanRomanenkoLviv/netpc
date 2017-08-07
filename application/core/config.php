<?php
/*
Глобальные конфигурации
*/

session_start();
// error_reporting(E_ALL); //0, E_ALL
date_default_timezone_set("Europe/Kiev");

//сайт
// define("PATH", 'http://'.$_SERVER['SERVER_NAME'].'/');
define("PATH", 'http://localhost:8888/');

//Виход
if(isset($_GET["do"]) && $_GET["do"] == "logout"){
	setcookie ("can_see", "", time() - 3600);
	setcookie ("auth_code", "", time() - 3600);
	$_SESSION['message'] = "Сесію завершено!";
    header("Location: ".PATH);
    exit();
}
	
//База данных
define("HOST", "localhost");
define("USER", "root");
define("PASS", "root");
define("DB", "netpc");

// Дефолтный ключ
$cryptKey  = "O!)an6aK9lO3nL}Ypy<("; // 20 символів

//Пагінація
define("PAGINATION_COUNT", "200");

// Язык по умолчанию
$default_lang = "uk";
$siteLang["uk"] = "uk";
$siteLang["ru"] = "ru";

//Бан при подборе пароля
define("NUMBER_AUTH", 5); // к-во ошибок
$time = 60*60*24;   // день = 60*60*24  година = 60*60,  хвилина = 60;
define("NUMBER_TIME", $time);

//Размер картинок
define("SIZE_UPLOAD_IMG", 3145728); //Один мегабайт 1024*1024 (Задаємо в байтах))

// Сторінка оновлення (Може бути декілька сторінок)
$page_lang = "main";

/* ===== Мультиязичність ===== */
$data = null;
if(isset($_GET["lang"])){
	$data = $_GET["lang"];
}
if(isset($_COOKIE["lang"]) and is_null($data) )
	$data = $_COOKIE["lang"];
$time_end_cookie = time() +30*24*60*60;

switch($data){
	case "uk":
		$need_lang = $data;
		setcookie("lang",$need_lang, $time_end_cookie);
		break;
	case "ru":
		$need_lang = $data;
		setcookie("lang",$need_lang, $time_end_cookie);
		break;

	default:
		$need_lang = $default_lang;
}

//Система редагування тексту. Заглушки:
//Система редагування тексту. Заглушки:
define("TEST_T", "Текст");
define("TEST_N", 1);
?>