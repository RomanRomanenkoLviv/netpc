<?php
/*
Класс-маршрутизатор для определения запрашиваемой страницы.
> цепляет классы контроллеров и моделей;
> создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
*/
class Route
{

	static function start()
	{

		// контроллер и действие по умолчанию
		$controller_name = 'Main';
		$action_name = 'index';
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		// получаем имя контроллера
		if ( !empty($routes[1]) )
		{	
			$controller_name = $routes[1];
		}
		
		// получаем имя экшена
		if ( !empty($routes[2]) )
		{
			$action_name = $routes[2];
		}

		if(isset($_COOKIE['can_see']) && isset($_COOKIE['auth_code'])){
			if(!get_db_data(false, 'users', 'id', "id = '{$_COOKIE['can_see']}'", false, false, false)){
				setcookie ("can_see", "", time() - 3600);
				setcookie ("auth_code", "", time() - 3600);
				$_SESSION['message'] = "В доступі відмовлено!";
				Route::Redirect();
			}else{				
				$user = get_db_data(false, 'users', 'id, login, password, crypt, auth, name', "id = '{$_COOKIE['can_see']}'", false, false, false);

				if( $_COOKIE['auth_code'] == encryptIt($user['login'], $user['auth']) ){		
					if(strripos($_SERVER['REQUEST_URI'], 'ajax')){
						header("Content-type: text/txt; charset=UTF-8");
						include "application/core/ajax.php";
					}else{								
						// добавляем префиксы
						$model_name = 'Model_'.$controller_name;
						$controller_name = 'Controller_'.$controller_name;
						$action_name = 'action_'.$action_name;

						// подцепляем файл с классом модели (файла модели может и не быть)

						$model_file = strtolower($model_name).'.php';
						$model_path = "application/models/".$model_file;
						if(file_exists($model_path))
						{
							include "application/models/".$model_file;
						}

						// подцепляем файл с классом контроллера
						$controller_file = strtolower($controller_name).'.php';
						$controller_path = "application/controllers/".$controller_file;
						if(file_exists($controller_path))
						{
							include "application/controllers/".$controller_file;
						}
						else
						{
							/*
							правильно было бы кинуть здесь исключение,
							но для упрощения сразу сделаем редирект на страницу 404
							*/
							Route::ErrorPage404();
						}
						
						// создаем контроллер
						$controller = new $controller_name;
						$action = $action_name;
						
						if(method_exists($controller, $action))
						{
							// вызываем действие контроллера
							$controller->$action();
						}
						else
						{
							// здесь также разумнее было бы кинуть исключение
							Route::ErrorPage404();
						}
					}
				}else{
					setcookie ("can_see", "", time() - 3600);
					setcookie ("auth_code", "", time() - 3600);
					$_SESSION['message'] = "В доступі відмовлено!";
					Route::Redirect();
				}
			}	
		}elseif ($controller_name == 'Main'){
			include "application/controllers/controller_main.php";

			// создаем контроллер
			$controller = new Controller_Main;
			$action = 'action_index';
			
			if(method_exists($controller, $action))
			{
				// вызываем действие контроллера
				$controller->$action();
			}
		}else{
			$_SESSION['message'] = "В доступі відмовлено!";
			Route::Redirect();
		}	
	}

	public static function ErrorPage404()
	{
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404');
    }

    public static function Redirect($url = NULL){
    	($url ? header('Location:'.PATH.$url) : header('Location:'.PATH));
    }
    
}
?>