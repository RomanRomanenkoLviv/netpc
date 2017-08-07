<?php

class Controller_Main extends Controller
{

	function action_index()
	{

		if(isset($_COOKIE['can_see']) && isset($_COOKIE['auth_code']) ){
			if(!get_db_data(false, 'users', 'id', "id = '{$_COOKIE['can_see']}'", false, false, false)){
				setcookie ("can_see", "", time() - 3600);
				setcookie ("auth_code", "", time() - 3600);
				$_SESSION['message']['text'] = "В доступі відмовлено!";
				$_SESSION['message']['type'] = 'warning';
			}else{
				$user = get_db_data(false, 'users', 'login, auth', "id = '{$_COOKIE['can_see']}'", false, false, false);
				if($_COOKIE['auth_code'] == encryptIt($user['login'], $user['auth'])){	
					if(!isset($data)) $data = null;		
					$this->view->generate('main_view.php', 'template_view.php', $data);
				}else{
					
					setcookie ("can_see", "", time() - 3600);
					setcookie ("auth_code", "", time() - 3600);
					$_SESSION['message']['text'] = "В доступі відмовлено!";
					$_SESSION['message']['type'] = 'warning';
				}	
			}		
		}else{
		if(isset($_POST['login']) && isset($_POST['pass']))
		{
			$login = $_POST['login'];
			$password =$_POST['pass'];
			if(!get_db_data(false, 'users', 'id', "login = '$login'", false, false, false)){
				$_SESSION['message']['text'] = "В доступі відмовлено!";
				$_SESSION['message']['type'] = 'warning';
			}else{
				/*
				Производим аутентификацию, сравнивая полученные значения со значениями прописанными в коде.
				Такое решение не верно с точки зрения безопсаности и сделано для упрощения примера.
				Логин и пароль должны храниться в БД, причем пароль должен быть захеширован.
				*/
				$user = get_db_data(false, 'users', 'id, login, password, crypt, auth', "login = '$login'", false, false, false);
				$get_pass = $user['password'];
				$crypt_pass = encryptIt($password, $user['crypt']);
				if($crypt_pass == $get_pass)
				{
					$_SESSION['message']['text'] = "Доступ дозволено.";
					$_SESSION['message']['type'] = 'success';
					SetCookie("can_see",$user['id'],time()+3600*24*30); // 30 днів
					SetCookie("auth_code",encryptIt($login, $user['auth']),time()+3600*24*30); // 30 днів
					if(!isset($data)) $data = null;
					$this->view->generate('main_view.php', 'template_view.php', $data);
				}
				else
				{
					$_SESSION['message']['text'] = "Дані не вірні. В доступі відмовлено!";
					$_SESSION['message']['type'] = 'warning';
				}
			}
		}
		else
		{
			unset($_SESSION['message']);
		}
			if(!isset($data)) $data = null;
			$this->view->generate(null, 'login_view.php', $data);			
		}
	}
}
?>