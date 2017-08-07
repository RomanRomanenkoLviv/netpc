<?php
/*
Конгурационный файл с всеми глобальными функциями
*/
defined('DATABASE') or die('Access denied');

/* =============================
Підключення до бази данних
================================ */
function connect_db(){
    $mysqli = new mysqli(HOST,USER,PASS,DB);
    
    if($mysqli->connect_error)
        die("Виникла помилка з базою данних!".$mysqli->connect_error); //Більш точний опис помилки die("Виникла помилка з базою данних! ".$mysqli->connect_error);
    $mysqli->set_charset("utf8");
    
    return $mysqli;
}
/* =============================
  Вивід банних з бази данних
================================ */
function get_db_data($sql = false, $bd_name = false, $value = false, $where = false, $order_by = false, $limit = false, $foreach = false) {
    $mysqli = connect_db();
    
    if(!$sql and !$bd_name){
        echo 'База данних вказана!';
        exit();
    }
    
    if(!$sql) {
        if($value){
            $sql = 'SELECT '.$value.' FROM '.$bd_name;
        } else {
            $sql = 'SELECT * FROM '.$bd_name;
        }
        
        if($where){
            $sql .= ' WHERE '.$where;
        }
        
        if($order_by){
            $sql .= ' ORDER BY '.$order_by;
        }
        
        if($limit){
            $sql .= ' LIMIT '.$limit;
        }
    }
    
    $res = $mysqli->query($sql) or die ($mysqli->error);
    
    if($res->num_rows == 1 and !$foreach) {
        $result = $res->fetch_assoc();
    } elseif($res->num_rows > 1 || $foreach) {
        $result = array();
        while($row = $res->fetch_assoc()){
            $result[] = $row;
        }
    } else {
        return $mysqli->error;
    }
    
    return $result;
}
/* =============================
  Вивід банних з бази данних
================================ */
function get_db_query($query) {
    $mysqli = connect_db();
    $res = $mysqli->query($query) or die ($mysqli->error);

    if($res->num_rows == 1 ) {
        $result = $res->fetch_assoc();
    } elseif($res->num_rows > 1) {
        $result = array();
        while($row = $res->fetch_assoc()){
            $result[] = $row;
        }
    } else {
        return $mysqli->error;
    }
    
    return $result;
}

/* =============================
    Реструктуризація масиву
================================ */
function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

/* =============================
	Валідація посилання. Чи є там http://
================================ */
function validateLink($link){
	if (!strstr($link,"://")){
	 return "http://".$link;
	}else{
		return $link;
	}
}

/* =============================
	Виводимо потрібний валюту
================================ */
function get_currency($price, $currency, $kurs_dollara){
	if($currency == 'usd'){
		$new_price = $price * $kurs_dollara;
		return round($new_price);
	} else {
		return $price;
	}
}

/* =============================
	Кодування і декодування паролю
================================ */
function encryptIt($q, $cryptKey) {
    $qEncoded      = base64_encode( md5( md5( $cryptKey ) . md5( $q ) ) );
    return( $qEncoded );
}

function decryptIt($q, $cryptKey) {
    $qDecoded      = rtrim( md5( md5( $cryptKey ) . md5( $q ) ), "\0");
    return( $qDecoded );
}

/* =============================
	Генератор паролей
================================ */
function generate_password($number)  {  
  $arr = array('a','b','c','d','e','f',  
               'g','h','i','j','k','l',  
               'm','n','o','p','r','s',  
               't','u','v','x','y','z',  
               'A','B','C','D','E','F',  
               'G','H','I','J','K','L',  
               'M','N','O','P','R','S',  
               'T','U','V','X','Y','Z',  
               '1','2','3','4','5','6',  
               '7','8','9','0','.',',',  
               '(',')','[',']','!','?',  
               '&','^','%','@','*','~',  
               '<','>','/','|','+','-',  
               '{','}','`');  
  // Генерируем пароль  
  $pass = "";  
  for($i = 0; $i < $number; $i++)  
  {  
    // Вычисляем случайный индекс массива  
    $index = rand(0, count($arr) - 1);  
    $pass .= $arr[$index];  
  }  
  return $pass;  
}  


/* =============================
 Генератор випадкових чисел і букв
================================ */
function generate_text($number)  {  
  $arr = array('a','b','c','d','e','f',  
               'g','h','i','j','k','l',  
               'm','n','o','p','r','s',  
               't','u','v','x','y','z',  
               'A','B','C','D','E','F',  
               'G','H','I','J','K','L',  
               'M','N','O','P','R','S',  
               'T','U','V','X','Y','Z',  
               '1','2','3','4','5','6',  
               '7','8','9','0');  
  // Генерируем пароль  
  $pass = "";  
  for($i = 0; $i < $number; $i++)  
  {  
    // Вычисляем случайный индекс массива  
    $index = rand(0, count($arr) - 1);  
    $pass .= $arr[$index];  
  }  
  return $pass;  
}

/* =============================
    Функція перевірки 
    правильності пароля
================================ */

function check_user_pass($email, $pass){
    $user_data = get_db_data(false, 'users', 'user_password, user_cryptKey', "user_email = '$email'", false, false, false);
    $cryptKey = $user_data['user_cryptKey'];
    if($user_data['user_password'] == encryptIt($pass, $cryptKey)){
        return true;
    } else {
        return false;
    }
}

/* =============================
	Функція очистки данних
================================ */
function cleardata($data){
	$mysqli = connect_db();
	$res =  $mysqli->real_escape_string(htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8'));
	return $res;
}

/* =============================
	Функція очистки данних, яка не потребує підключення до бд
================================ */
function clean($data){
	return htmlspecialchars(strip_tags(addslashes(trim($data))));
}

/* =============================
	Функція очистки назви файлу
================================ */
function cleardata_to_file($data){
	$res =  htmlspecialchars(strip_tags(trim($data)));
	return $res;
}


/* =============================
  Видаляємо папку з всім вмістимим (Для Install)
================================ */
function removeDirectory($dir) {
  if ($objs = glob($dir."/*")) {
     foreach($objs as $obj) {
       is_dir($obj) ? removeDirectory($obj) : unlink($obj);
     }
  }
  if(rmdir($dir)) return true;
  else return false;
}

/* =============================
  Виводимо потрібне значення з масиву
================================ */
function get_array_value($array = false, $need_data = false, $need_return = false){
    if(!$array || !$need_data)
        echo 'Не вказаний масив або потрібне значення';
    
    if($need_return) {
        foreach($array as $key => $value){
            if($key == $need_data)
                $result = $need_return;
        }   
    } else {
        foreach($array as $key => $value){
            if($key == $need_data)
                $result = $value;
        }   
    }
    
    if($result)
        return $result;
    else
        return 'Значення не знайдено';
    
}

function redirect($http = false){
    if($http) $redirect = $http;
        else $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    header("Location: $redirect");
    exit;
}


/* =============================
    Виводимо назву місяця
================================ */
function get_month_name($number){
$num = (int)$number;

	switch($num){
		case 1:  return 'Січня'; break;
		case 2:  return 'Лютого'; break;
		case 3:  return 'Березня'; break;
		case 4:  return 'Квітня'; break;
		case 5:  return 'Травня'; break;
		case 6:  return 'Червня'; break;
		case 7:  return 'Липня'; break;
		case 8:  return 'Серпня'; break;
		case 9:  return 'Вересня'; break;
		case 10: return 'Жовтня'; break;
		case 11: return 'Листопада'; break;
		case 12: return 'Грудня'; break;
	}
}


/* =============================
    Форматуємо вивід масива
================================ */
function print_arr($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

/* =============================
Скачування файлу через php
================================ */
function download_file($file = false, $dir = 'uploads/'){
	//Провірємо чи є в методі GET параметр file
    if (isset($file)) {
        $fdir = $dir.$file;
        $fsize = @filesize($fdir); //Розмір файлу

        //Провіряємо чи є файл з таким ім'ям
        if(!file_exists($fdir)){
            return "ПОМИЛКА: файл не існує.";
            exit;
        }

        //Витягуємо розширення з назви файлу
        $file_extension = strtolower(substr(strrchr($file,"."),1));
        switch( $file_extension )
        {
            case "pdf": $ctype="application/pdf"; break;
            case "exe": $ctype="application/octet-stream"; break;
            case "zip": $ctype="application/zip"; break;
            case "docx":
            case "doc": $ctype="application/msword"; break;
            case "xls": $ctype="application/vnd.ms-excel"; break;
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
            case "mp3": $ctype="audio/mp3"; break;
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;  
            case "jpeg":
            case "jpg": $ctype="image/jpg"; break;
            default:    $ctype="application/force-download";
        }
        header("Content-Type: $ctype");
        header("Content-Length: $fsize"); //Передаємо розмір файлу
        header("Content-Disposition: attachment; filename=\"$file\"");
        readfile($fdir);
        exit;
    } else {
        return 'Ви не вказали файл скачування.';
    }
    return false;
}

/* =============================
	Конвектор байтів в кб, мб і тд
================================ */
function convert_size($bytes, $need_units = true, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes?log($bytes):0)/log(1024));
    $pow = min($pow, count($units)-1);
    $bytes /= pow(1024, $pow);
    if($need_units)
        return round($bytes, $precision).' '.$units[$pow];
    else
        return round($bytes, $precision);
}

/* ================================
    Провірка на існування сесії і її повернення, якщо є (Для форм добавлення данних)
================================ */
function emptySession($value){
    return ($value) ? $value : false;
}

/* ================================
    Валідація форми
================================ */
// Правильність Email
function isEmail($value) {
    return (filter_var($value, FILTER_VALIDATE_EMAIL)) ? true : false;
}

// Мінімальне значення
function check_min($value, $min = 2) {
    return ($value and strlen($value) >= $min) ? true : false;
}

// Максимальне значення
function check_max($value, $max = 200) {
    return ($value and strlen($value) <= $max) ? true : false;
}

// Провірка select
function check_select($value = false, $array = array()) {
    if(!$value || empty($array) || !is_array($array))
        return false;
    
    return (in_array($value, $array)) ? true : false;
}
// Виводимо потрібне значення select, radio, check
function need_value($value = false, $set_data = false, $need_return = false){
    if(!$value || !$set_data || !$need_return)
        return 'Не вказаний масив або потрібне значення';
    
    return ($value == $set_data) ? $need_return : false;
}

// Перевіряємо картинку
function check_file($file = false){
    if(!$file) return false; // || is_file($file)
    $error = '';
    
    //Заносимо значення файлу в змінні
    $imageType = $file['type']; // Тип картинки
    $imageSize = $file['size']; //Розмір картинки
    $imageError = $file['error']; //0 - ok, 1 - завеликий розмір файлу

    $types = array('image/png','image/jpeg','image/jpg','image/x-png');
    $types_error = '.png, .jpeg, .jpg';
    
    if($imageError)
        $error = "Помилка при завантаженні файлу. Можливо картинка занадто велика";
    else
        if($imageSize > SIZE_UPLOAD_IMG)
            $error .= "Максимальний розмір файлу ".convert_size(SIZE_UPLOAD_IMG);
        else
            if(!in_array($imageType, $types))
                $error .= "Доступні розширення - ".$types_error;
        
    return (empty($error)) ? false : $error;
}

// Перевіряємо значень в mail.php
function checkStr($value, $empty_e, $min_e, $max_e){ // $empty_e - якщо значення пусте, $min_e - мінімально, $max_e - максимально символів
    if(!$value)
        return $empty_e; 
    else
        if(!check_min($value)) // Мінімальне значення min = 2 символа
            return $min_e;
        else    
            if(!check_max($value, 50)) // Максимальне значення max 50 символів
                return $max_e;
    return false;
}

function checkEmail($email, $empty_e, $valid_e, $require_Email = false){
    if($require_Email)
        if(!$email) 
            return $empty_e; //Значення пусте?
        else
            if(!isEmail($email))
                return $valid_e;
    elseif(!$require_Email)
        if($email)
            if(!isEmail($email))
                return $valid_e;
    else
        return false;
}


/* ================================
    Робота за файлами
================================ */
// Створюємо папку
function createFolder($folder){
    
    if(!file_exists($folder)){
        //Провіряємо чи закінчується слешом /
        $folder_symbol = substr($folder, 0, 1);
        if($folder_symbol !== '/')
            $folder = $folder.'/';
        
        if(@mkdir($folder, 0755)){
            
            //Формуємо файл заглугшку index.html
            $preset = '<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error access</title>
</head>
<body>
    <p style="color: #e74c3c;">Error</p>
</body>
</html>';
        
            @file_put_contents($folder.'index.html', $preset);
            return true;   
        }
        else return false;
    } 
    else return false;
}

// Заносимо всі файли, папки в масив
function dirToArray($dir, $skip_add = array()) {
    //Якщо назва папки (core/modal) без слеша то добавляємо його (core/modal/)
    $dir_end = substr($dir, -1);
    if($dir_end !== '/')
        $dir .= '/';
    
    //Скануємо вказану папку
    $files = scandir($dir);
    
    //Забираємо непотрібні значення
    $skip = array('.', '..', 'index.html');
    if(!empty($skip_add))
        if(!is_array($skip_add) and count($skip_add) == 1)
            array_push($skip, $skip_add);
        else
            foreach($skip_add as $add_skip){
                $skip[] = $add_skip;
            }
    
    //Провіряємо чи це папка і заносимо в масив + забираємо непотрібні значення
    foreach($files as $file) {
        if(is_dir($dir.$file)){
            if(!in_array($file, $skip))
                    $dir_array[$file] = $file;
        } else {
            continue;
        }
    }
    
    return $dir_array;
}

?>