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
		/*if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
			parent::error('Type request only POST');
			return ;
		}*/
		
		//$postContent = trim(file_get_contents("php://input")); // получаем данные запроса		
		
		//$postContent = '{"id":47}'; //пример post для create
		//$postContent = '{"id":47, "gamer":"test"}'; // пример post для connect
		//$postContent = '{"token":"69805458a8fc7e4f36e84d64484c613f", "data":"toend", "rewrite":""}'; // пример post для update
		//$postContent = '{"token":"098f6bcd4621d373cade4e832627b4f7", "clear":""}'; // пример post для show
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