<?php
/*
*   @param $main_img_obj – идентификатор изображения, на которое добавляется надпись
*   @param $watermark_img_obj – ид. изображения прозрачного png8
*   @param $alpha_level – прозрачность (0 – прозрачное, 100 – полностью непрозрачное)
*   @return $main_img_obj - указатель изображения
*/
class Controller_general extends Controller
{
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
	
	function action_index()
	{
		$this->view->generate('general_view.php', 'template_view.php');
	}
	function action_add(){
		if($_POST){
			$success = null;
			$rows = null;
			$values = null;
			$bindCode = null;
			$params = null;
			if(isset($_POST['surname']) && strlen($_POST['surname']) > 0){
				$rows .= ' surname,';
				$values .= '?,';
				$bindCode .= 's';
				$params[] = $_POST['surname'];
			} 
			if(isset($_POST['name']) && strlen($_POST['name']) > 0){
				$rows .= ' name,';
				$values .= '?,';
				$bindCode .= 's';
				$params[] = $_POST['name'];
			} 
			if(isset($_POST['patro']) && strlen($_POST['patro']) > 0){
				$rows .= ' patro,';
				$values .= '?,';
				$bindCode .= 's';
				$params[] = $_POST['patro'];
			} 
			if(isset($_POST['address_city']) && strlen($_POST['address_city']) > 0){
				$rows .= ' address_city,';
				$values .= '?,';
				$bindCode .= 's';
				$params[] = $_POST['address_city'];
			}
			if(isset($_POST['address_street']) && strlen($_POST['address_street']) > 0){
				$rows .= ' address_street,';
				$values .= '?,';
				$bindCode .= 's';
				$params[] = $_POST['address_street'];
			}
            if(isset($_POST['address_house']) && strlen($_POST['address_house']) > 0){
                $rows .= ' address_house,';
                $values .= '?,';
                $bindCode .= 's';
                $params[] = $_POST['address_house'];
            }
			if(isset($_POST['home_phone']) && strlen($_POST['home_phone']) > 0){
				$rows .= ' home_phone,';
				$values .= '?,';
				$bindCode .= 's';
				$params[] = $_POST['home_phone'];
			} 
			if(isset($_POST['phone']) && strlen($_POST['phone']) > 0){
				$rows .= ' phone,';
				$values .= '?,';
				$bindCode .= 's';
				$params[] = $_POST['phone'];
			} 
			if(isset($_POST['birthday_date']) && strlen($_POST['birthday_date'] > 0) ){
				$birthdayDate = explode('.', $_POST['birthday_date']);
                $rows .= " birthday_day, birthday_month, birthday_year,";
				$values .= '?,?,?,';
				$bindCode .= 'iii';
				$params[] = $birthdayDate[0];
                $params[] = $birthdayDate[1];
                $params[] = $birthdayDate[2];
			}
            if(isset($_POST['baptism_date']) && strlen($_POST['baptism_date'] > 0) ){
                $baptismDate = explode('.', $_POST['baptism_date']);
                $rows .= " baptism_day, baptism_month, baptism_year,";
                $values .= '?,?,?,';
                $bindCode .= 'iii';
                $params[] = $baptismDate[0];
                $params[] = $baptismDate[1];
                $params[] = $baptismDate[2];
            }
			if(isset($_POST['district_number']) && strlen($_POST['district_number']) > 0){
				$rows .= ' district_number,';
				$values .= '?,';
				$bindCode .= 'i';
				$params[] = $_POST['district_number'];
			} 
			if(isset($_POST['list_number']) && strlen($_POST['list_number']) > 0){
				$rows .= ' list_number,';
				$values .= '?,';
				$bindCode .= 's';
				$params[] = $_POST['list_number'];
			}
            if(isset($_POST['members_date']) && strlen($_POST['members_date'] > 0) ){
                $membersDate = explode('.', $_POST['members_date']);
                $rows .= " members_day, members_month, members_year,";
                $values .= '?,?,?,';
                $bindCode .= 'iii';
                $params[] = $membersDate[0];
                $params[] = $membersDate[1];
                $params[] = $membersDate[2];
            }
			if(isset($_POST['church_where']) && strlen($_POST['church_where']) > 0){
				$rows .= ' church_where,';
				$values .= '?,';
				$bindCode .= 's';
				$params[] = $_POST['church_where'];
			} 
			if(isset($_POST['isretirement'])){
				if(isset($_POST['retirement_date']) && strlen($_POST['retirement_date']) > 0){
					$retirementDate = date('Y-m-d', strtotime($_POST['retirement_date']));
					$rows .= ' retirement_date,';
					$values .= '?,';
					$bindCode .= 's';
					$params[] = $retirementDate;
				} 
				if(isset($_POST['retirement_city']) && strlen($_POST['retirement_city']) > 0){
					$rows .= ' retirement_city,';
					$values .= '?,';
					$bindCode .= 's';
					$params[] = $_POST['retirement_city'];
				} 
			}
			
			if(isset($_POST['isexclusion'])){
				if(isset($_POST['exclusion_date']) && strlen($_POST['exclusion_date']) > 0){
					$exclusionDate = date('Y-m-d', strtotime($_POST['exclusion_date']));
					$rows .= ' exclusion_date,';
					$values .= '?,';
					$bindCode .= 's';
					$params[] = $exclusionDate;
				} 
				if(isset($_POST['exclusion_reason']) && strlen($_POST['exclusion_reason']) > 0){
					$rows .= ' exclusion_reason,';
					$values .= '?,';
					$bindCode .= 's';
					$params[] = $_POST['exclusion_reason'];
				} 
			}
			
			if(isset($_POST['isremark'])){
				if(isset($_POST['remark_date']) && strlen($_POST['remark_date']) > 0){
					$remarkDate = date('Y-m-d', strtotime($_POST['remark_date']));
					$rows .= ' remark_date,';
					$values .= '?,';
					$bindCode .= 's';
					$params[] = $remarkDate;
				} 
				if(isset($_POST['remark_term']) && strlen($_POST['remark_term']) > 0) {
					$rows .= ' remark_term,';
					$values .= '?,';
					$bindCode .= 's';
					$params[] = $_POST['remark_term'];
				} 
				if(isset($_POST['remark_off_date']) && strlen($_POST['remark_off_date']) > 0){
					$remarkOffDate = date('Y-m-d', strtotime($_POST['remark_off_date']));
					$rows .= ' remark_off_date,';
					$values .= '?,';
					$bindCode .= 's';
					$params[] = $remarkOffDate;
				} 
			}
			
			if(isset($_POST['widow'])){
					$rows .= ' widow,';
					$values .= '?,';
					$bindCode .= 'i';
					$params[] = 1;
				} 
			if(isset($_POST['invalid'])){
					$rows .= ' invalid,';
					$values .= '?,';
					$bindCode .= 'i';
					$params[] = 1;
				} 
			if(isset($_POST['comment']) && strlen($_POST['comment']) > 0){
					$rows .= ' comment,';
					$values .= '?,';
					$bindCode .= 's';
					$params[] = $_POST['comment'];
				} 
			if(isset($_POST['isdeath'])){
				if(isset($_POST['death_date']) && strlen($_POST['death_date']) > 0){
					$deathDate = date('Y-m-d', strtotime($_POST['death_date']));
					$rows .= ' death_date,';
					$values .= '?,';
					$bindCode .= 's';
					$params[] = $deathDate;
				} 
			}

			$rows = mb_substr($rows, 0, -1);
			$values = mb_substr($values, 0, -1);
			array_unshift($params, $bindCode);
			
			$mysqli = connect_db();
			$res = $mysqli->prepare("INSERT INTO `members` ({$rows}) VALUES ({$values})");
			call_user_func_array(array($res, 'bind_param'), self::refValues($params));
			//$res->bind_param($params);
			$mysqli->error;
			$res->execute();
			$memberId = $res->insert_id;
			$success = true;
			if(!$res->affected_rows){
			  $_SESSION['message']['text'] = 'Невідома помилка.';
			  $_SESSION['message']['type'] = 'warning';
			  $success = null;
			}
			$res->close();

			if(!is_null($success) && isset($_FILES['photo']) && isset($memberId)){
				$photofile = $_FILES['photo'];
				$dir = 'images/members/'.$memberId;											
				if ($photofile['type'] != 'image/jpeg' && $photofile['type'] != 'image/gif' && $photofile['type'] != 'image/png' && $photofile['type'] != 'image/bmp'){
					$_SESSION['message']['text'] = 'Помилка! Формат фото не вірний!';
					$_SESSION['message']['type'] = 'warning';
				}else {	
					if ($photofile['type'] != 'image/jpeg') {
					if ($photofile['type'] == 'image/gif') $Image = imagecreatefromgif($photofile['tmp_name']); 
					if ($photofile['type'] == 'image/png') $Image = imagecreatefrompng($photofile['tmp_name']); 
					if ($photofile['type'] == 'image/bmp') $Image = imagecreatefromwbmp($photofile['tmp_name']); 
					} 
					else $Image = imagecreatefromjpeg($photofile['tmp_name']);
					$Size = getimagesize($photofile['tmp_name']);
					
					$Download = $dir.'.jpg';
					imagejpeg($Image, $Download, 100);
					imagedestroy($Image);								
				}
			}

			if(isset($_POST['send_save_preview'])){
				if(!is_null($success)){
					$_SESSION['message']['text'] = 'Об\'єкт успішно додано.';
					$_SESSION['message']['type'] = 'success';
					Route::Redirect('general/member/?memberId='.$memberId );
				}
			}else if(isset($_POST['send_only_save'])){
				if(!is_null($success)){
					$_SESSION['message']['text'] = 'Об\'єкт успішно додано.';
					$_SESSION['message']['type'] = 'success';
					$this->view->generate('general_view.php', 'template_view.php');
				}
			}
		}else {
			$this->view->generate('add_member_view.php', 'template_view.php');
		}
	}
	function action_edit(){
		if($_POST && isset($_GET['memberId'])){
			$memberId = $_GET['memberId'];
			$success = null;
			$values = null;
			$bindCode = null;
			$params = null;
			if(isset($_POST['surname']) && strlen($_POST['surname']) > 0){
				$values .= ' surname = ?,';
				$bindCode .= 's';
				$params[] = $_POST['surname'];
			} 
			if(isset($_POST['name']) && strlen($_POST['name']) > 0){
				$values .= ' name = ?,';
				$bindCode .= 's';
				$params[] = $_POST['name'];
			} 
			if(isset($_POST['patro']) && strlen($_POST['patro']) > 0){
				$values .= ' patro = ?,';
				$bindCode .= 's';
				$params[] = $_POST['patro'];
			} 
			if(isset($_POST['address_city']) && strlen($_POST['address_city']) > 0){
				$values .= ' address_city = ?,';
				$bindCode .= 's';
				$params[] = $_POST['address_city'];
			}
			if(isset($_POST['address_street']) && strlen($_POST['address_street']) > 0){
				$values .= ' address_street = ?,';
				$bindCode .= 's';
				$params[] = $_POST['address_street'];
			}
            if(isset($_POST['address_house']) && strlen($_POST['address_house']) > 0){
                $values .= ' address_house = ?,';
                $bindCode .= 's';
                $params[] = $_POST['address_house'];
            }
			if(isset($_POST['home_phone']) && strlen($_POST['home_phone']) > 0){
				$values .= ' home_phone = ?,';
				$bindCode .= 's';
				$params[] = $_POST['home_phone'];
			} 
			if(isset($_POST['phone']) && strlen($_POST['phone']) > 0){
				$values .= ' phone = ?,';
				$bindCode .= 's';
				$params[] = $_POST['phone'];
			} 
			if(isset($_POST['birthday_date']) && strlen($_POST['birthday_date'] > 0) ){
                $birthdayDate = explode('.', $_POST['birthday_date']);
                $values .= " birthday_day = ?, birthday_month = ?, birthday_year = ?,";
                $bindCode .= 'iii';
                $params[] = $birthdayDate[0];
                $params[] = $birthdayDate[1];
                $params[] = $birthdayDate[2];
            }
            if(isset($_POST['baptism_date']) && strlen($_POST['baptism_date'] > 0) ){
                $baptismDate = explode('.', $_POST['baptism_date']);
                $values .= " baptism_day = ?, baptism_month = ?, baptism_year = ?,";
                $bindCode .= 'iii';
                $params[] = $baptismDate[0];
                $params[] = $baptismDate[1];
                $params[] = $baptismDate[2];
            }
			if(isset($_POST['district_number']) && strlen($_POST['district_number']) > 0){
				$values .= ' district_number = ?,';
				$bindCode .= 'i';
				$params[] = $_POST['district_number'];
			} 
			if(isset($_POST['list_number']) && strlen($_POST['list_number']) > 0){
				$values .= ' list_number = ?,';
				$bindCode .= 's';
				$params[] = $_POST['list_number'];
			}
            if(isset($_POST['members_date']) && strlen($_POST['members_date'] > 0) ){
                $membersDate = explode('.', $_POST['members_date']);
                $values .= " members_day = ?, members_month = ?, members_year = ?,";
                $bindCode .= 'iii';
                $params[] = $membersDate[0];
                $params[] = $membersDate[1];
                $params[] = $membersDate[2];
            }
			if(isset($_POST['church_where']) && strlen($_POST['church_where']) > 0){
				$values .= ' church_where = ?,';
				$bindCode .= 's';
				$params[] = $_POST['church_where'];
			} 
			if(isset($_POST['isretirement'])){
				if(isset($_POST['retirement_date']) && strlen($_POST['retirement_date']) > 0){
					$retirementDate = date('Y-m-d', strtotime($_POST['retirement_date']));
					$values .= ' retirement_date = ?,';
					$bindCode .= 's';
					$params[] = $retirementDate;
				} 
				if(isset($_POST['retirement_city']) && strlen($_POST['retirement_city']) > 0){
					$values .= ' retirement_city = ?,';
					$bindCode .= 's';
					$params[] = $_POST['retirement_city'];
				} 
			}else{
				$values .= ' retirement_date = ?,';
				$bindCode .= 's';
				$params[] = null;
				$values .= ' retirement_city = ?,';
				$bindCode .= 's';
				$params[] = null;
			}
			
			if(isset($_POST['isexclusion'])){
				if(isset($_POST['exclusion_date']) && strlen($_POST['exclusion_date']) > 0){
					$exclusionDate = date('Y-m-d', strtotime($_POST['exclusion_date']));
					$values .= ' exclusion_date = ?,';
					$bindCode .= 's';
					$params[] = $exclusionDate;
				} 
				if(isset($_POST['exclusion_reason']) && strlen($_POST['exclusion_reason']) > 0){
					$values .= ' exclusion_reason = ?,';
					$bindCode .= 's';
					$params[] = $_POST['exclusion_reason'];
				} 
			}else{
				$values .= ' exclusion_date = ?,';
				$bindCode .= 's';
				$params[] = null;
				$values .= ' exclusion_reason = ?,';
				$bindCode .= 's';
				$params[] = null;
			}
			
			if(isset($_POST['isremark'])){
				if(isset($_POST['remark_date']) && strlen($_POST['remark_date']) > 0){
					$remarkDate = date('Y-m-d', strtotime($_POST['remark_date']));
					$values .= ' remark_date = ?,';
					$bindCode .= 's';
					$params[] = $remarkDate;
				} 
				if(isset($_POST['remark_term']) && strlen($_POST['remark_term']) > 0) {
					$values .= ' remark_term = ?,';
					$bindCode .= 's';
					$params[] = $_POST['remark_term'];
				} 
				if(isset($_POST['remark_off_date']) && strlen($_POST['remark_off_date']) > 0){
					$remarkOffDate = date('Y-m-d', strtotime($_POST['remark_off_date']));
					$values .= ' remark_off_date = ?,';
					$bindCode .= 's';
					$params[] = $remarkOffDate;
				} 
			}else{
				$values .= ' remark_date = ?,';
				$bindCode .= 's';
				$params[] = null;
				$values .= ' remark_term = ?,';
				$bindCode .= 's';
				$params[] = null;
				$values .= ' remark_off_date = ?,';
				$bindCode .= 's';
				$params[] = null;
			}
			
			if(isset($_POST['widow'])){
				$values .= ' widow = ?,';
				$bindCode .= 'i';
				$params[] = 1;
			}else{
				$values .= ' widow = ?,';
				$bindCode .= 'i';
				$params[] = null;
			}
			if(isset($_POST['invalid'])){
				$values .= ' invalid = ?,';
				$bindCode .= 'i';
				$params[] = 1;
			}else{
				$values .= ' invalid = ?,';
				$bindCode .= 'i';
				$params[] = null;
			}
			if(isset($_POST['comment']) && strlen($_POST['comment']) > 0){
				$values .= ' comment = ?,';
				$bindCode .= 's';
				$params[] = $_POST['comment'];
			} 
			if(isset($_POST['isdeath'])){
				if(isset($_POST['death_date']) && strlen($_POST['death_date']) > 0){
					$deathDate = date('Y-m-d', strtotime($_POST['death_date']));
					$values .= ' death_date = ?,';
					$bindCode .= 's';
					$params[] = $deathDate;
				} 
			}else{
				$values .= ' death_date = ?,';
				$bindCode .= 's';
				$params[] = null;
			}
			$bindCode .= 'i';
			$params[] = $memberId;

			$values = mb_substr($values, 0, -1);
			array_unshift($params, $bindCode);
			
			$mysqli = connect_db();
			$res = $mysqli->prepare("UPDATE `members` SET $values WHERE `id` = ?");
			call_user_func_array(array($res, 'bind_param'), self::refValues($params));
			//$res->bind_param($params);
			$mysqli->error;
			$res->execute();
			if(!$res->affected_rows){
			  $_SESSION['message']['text'] = 'Дані не були змінені, або в процесі збереження трапилась помилка.';
			  $_SESSION['message']['type'] = 'warning';
			}
			$res->close();

			if(isset($_FILES['photo']) && isset($memberId)){
				$photofile = $_FILES['photo'];
				$dir = 'images/members/'.$memberId;											
				if ($photofile['type'] != 'image/jpeg' && $photofile['type'] != 'image/gif' && $photofile['type'] != 'image/png' && $photofile['type'] != 'image/bmp'){
					$_SESSION['message']['text'] = 'Помилка! Формат фото не вірний!';
					$_SESSION['message']['type'] = 'warning';
				}else {	
					if ($photofile['type'] != 'image/jpeg') {
					if ($photofile['type'] == 'image/gif') $Image = imagecreatefromgif($photofile['tmp_name']); 
					if ($photofile['type'] == 'image/png') $Image = imagecreatefrompng($photofile['tmp_name']); 
					if ($photofile['type'] == 'image/bmp') $Image = imagecreatefromwbmp($photofile['tmp_name']); 
					} 
					else $Image = imagecreatefromjpeg($photofile['tmp_name']);
					$Size = getimagesize($photofile['tmp_name']);
					
					$Download = $dir.'.jpg';
					imagejpeg($Image, $Download, 100);
					imagedestroy($Image);								
				}
			}

			if(isset($_POST['send_save_preview'])){
				$_SESSION['message']['text'] = 'Об\'єкт успішно збережено.';
				$_SESSION['message']['type'] = 'success';
				Route::Redirect('general/member/?memberId='.$memberId );
			}else if(isset($_POST['send_only_save'])){
				$_SESSION['message']['text'] = 'Об\'єкт успішно збережено.';
				$_SESSION['message']['type'] = 'success';
				$this->view->generate('general_view.php', 'template_view.php');
			}else{
				$this->view->generate('general_view.php', 'template_view.php');
			}
		}else{
			$this->view->generate('edit_member_view.php', 'template_view.php');
		}
	}
	function action_member(){
		$this->view->generate('member_view.php', 'template_view.php');
	}
	function action_generator(){
		$this->view->generate('generator_view.php', 'template_view.php');
	}
}
?>