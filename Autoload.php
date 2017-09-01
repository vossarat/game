<?php
/**
* Автозагрузчик классов
* 
* @function($className) передается из вызываемого класса
* в случае нахождения файла, создается его экземпляр
* 
*/
spl_autoload_register(
	function($className)
	{
		if (file_exists($className. '.php' ))
		{
			require $className. '.php' ;
		}
	});

?>