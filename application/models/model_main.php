<?php

class Model_main extends Model
{
	public static function getMembers($data = null){
		$result = null;
		$getdata = get_db_data(false, 'members', false, false, '`id` ASC', false, true);
		foreach ($getdata as $member){
			$result .= "<tr class=\"line member_{$member['id']}\" onclick=\"getMemberInfo({$member['id']})\">
				<td class=\"cell id\">{$member['id']}</td>
				<td class=\"cell\">{$member['name']} {$member['surname']}</td>
				<td class=\"cell\">{$member['phone']}</td>
				<td class=\"cell\">{$member['email']}</td>
				<td class=\"cell\">".date('d.m.Y', strtotime($member['birthday_date']))."</td>
			</tr>";
		}
		return $result;
	}

	private static function refValues($arr){
        if (strnatcmp(phpversion(),'5.3') >= 0) { //Если версия PHP >=5.3 (в младших версиях все проще)
                $refs = array();
                foreach($arr as $key => $value) {
                        $refs[$key] = &$arr[$key]; //Массиву $refs присваиваются ссылки на значения массива $arr
                }
                return $refs; //Массиву $arr присваиваются значения массива $refs
        }
        return $arr; //Возвращается массив $arr
	}

	public static function deleteMember($data = null){
		$mysqli = connect_db();
		$res = $mysqli->prepare("DELETE FROM `members` WHERE id=?");
		$res->bind_param('i'					                 
		                 ,$_GET['memberId']
		                );
		$mysqli->error;
		$res->execute();
		$res->close();
		return 'success';
	}

	public static function addUser($request = null){
		if(!is_null($request)){
			$success = null;
			$rows = null;
			$values = null;
			$bindCode = null;
			$params = null;
			$data = json_decode($request, true);
			foreach ($data as $key => $value) {
				if($key == 'password'){
					$secretData = json_decode(self::getnerateText($value), true);
					foreach ($secretData as $name => $skey) {
						$rows .= " {$name},";
						$values .= '?,';
						$bindCode .= 's';
						$params[] = $skey;
					}
				}else{
					$rows .= " {$key},";
					$values .= '?,';
					$bindCode .= 's';
					$params[] = $value;
				}
			}
			$rows = mb_substr($rows, 0, -1);
			$values = mb_substr($values, 0, -1);
			array_unshift($params, $bindCode);
			
			$mysqli = connect_db();
			$res = $mysqli->prepare("INSERT INTO `users` ({$rows}) VALUES ({$values})");
			call_user_func_array(array($res, 'bind_param'), self::refValues($params));
			$mysqli->error;
			$res->execute();
			$success = true;
			if(!$res->affected_rows){
			  $_SESSION['message']['text'] = 'Невідома помилка.';
			  $_SESSION['message']['type'] = 'warning';
			  $success = null;
			}
			$res->close();
		}
	}

	public static function addMember($request = null){
		if(!is_null($request)){
			$success = null;
			$rows = null;
			$values = null;
			$bindCode = null;
			$params = null;
			$data = json_decode($request, true);
			foreach ($data as $key => $value) {
				if($key == 'birthday_date'){
					$rows .= " {$key},";
					$values .= '?,';
					$bindCode .= 's';
					$params[] = date('Y-m-d', strtotime($value));
				}else{
					$rows .= " {$key},";
					$values .= '?,';
					$bindCode .= 's';
					$params[] = $value;
				}
			}
			$rows = mb_substr($rows, 0, -1);
			$values = mb_substr($values, 0, -1);
			array_unshift($params, $bindCode);
			
			$mysqli = connect_db();
			$res = $mysqli->prepare("INSERT INTO `members` ({$rows}) VALUES ({$values})");
			call_user_func_array(array($res, 'bind_param'), self::refValues($params));
			$mysqli->error;
			$res->execute();
			$success = true;
			if(!$res->affected_rows){
			  $_SESSION['message']['text'] = 'Невідома помилка.';
			  $_SESSION['message']['type'] = 'warning';
			  $success = null;
			}
			$res->close();
		}
	}
	public static function editMember($request = null, $memberId = null){
		if(!is_null($request) && !is_null($memberId)){
			$success = null;
			$values = null;
			$bindCode = null;
			$params = null;
			echo $request;
			$data = json_decode($request, true);
			foreach ($data as $key => $value) {
				if($key == 'birthday_date'){
					$values .= " {$key} = ?,";
					$bindCode .= 's';
					$params[] = date('Y-m-d', strtotime($value));
				}else{
					$values .= " {$key} = ?,";
					$bindCode .= 's';
					$params[] = $value;
				}
			}
			$bindCode .= 'i';
			$params[] = $memberId;

			$values = mb_substr($values, 0, -1);
			array_unshift($params, $bindCode);
			echo $values;
			echo $bindCode;
			$mysqli = connect_db();
			$res = $mysqli->prepare("UPDATE `members` SET $values WHERE `id` = ?");
			call_user_func_array(array($res, 'bind_param'), self::refValues($params));
			$mysqli->error;
			$res->execute();
			$success = true;
			if(!$res->affected_rows){
			  $_SESSION['message']['text'] = 'Невідома помилка.';
			  $_SESSION['message']['type'] = 'warning';
			  $success = null;
			}
			$res->close();
		}
	}
	public static function getnerateText($text){
		$cryptKey = null;
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
		for($i = 0; $i < 20; $i++)  
		{  
			// Вычисляем случайный индекс массива  
			$index = rand(0, count($arr) - 1);  
			$cryptKey .= $arr[$index];  
		} 
		if(isset($text)){
			$qEncoded = base64_encode( md5( md5( $cryptKey ) . md5( $text ) ) );
    		return "{\"password\":\"{$qEncoded}\", \"crypt\":\"{$cryptKey}\"}";
		}
	}
	
	public static function getMemberInfo($id = FALSE)
	{	
		if(isset($id)){
			$userdata = get_db_data(false, 'members', '*', "id = '{$id}'", false, false, false);
			return $userdata;
		}else{
			return null;
		}
	}

	public static function getMemberEmail($email = null){
		if(get_db_data(false, 'members', '*', "email = '{$email}'", false, false, false)){
			return 'find';
		}
	}
}
?>