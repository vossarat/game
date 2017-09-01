<?php

class Route extends Controller
{
	/**
	* запускаем роутер, делаем проверки, выбираем действия (контроллеры) 
	* 
	* @return
	*/
	static function start()
	{
		// проверка на тип запроса
		// если не POST, то error
		if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
			parent::error('Type request only POST');
			return ;
		}
		
		$postContent = trim(file_get_contents("php://input")); // получаем данные запроса		
		
		//$postContent = '{"id":26, "gamer2":"GamerName2"}';
		$jsonData = json_decode($postContent, true);
				
		if(!is_array($jsonData)){
			parent::error('JSON not valid');
			return ;
		}
				
		$routes = $_SERVER['REQUEST_URI']; // Запускаем ассоциативный массив параметров, переданных скрипту через URL
		
		$routes         = ltrim($routes, '/'); //убрать первый слэш
		$routes         = explode('/', $routes); // разобрать URL на массив
	
		$classController = ucfirst(array_shift($routes)); // Ищем контроллер, которому будут передаваться параметры запроса
			       
		$file =  $classController.'.php';        
		if(file_exists($file)) //Проверяем существование файла, чтобы создать экземпляр
		{		
			$controller = new $classController; // создаем экземпляр класса контроллера
			$controller->index( $jsonData );  // передаем действие методу index созданного экземпляра класса
		}
		else // некорректный адрес, возвращает json ошибки
		{ 
			parent::error('Controller not found');
		}
	}
}
?>