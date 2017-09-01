<?php

class Controller
{
	/**
	* Конструктор для контроллера
	* 
	* @return
	*/
    function __construct()
    {
        $this->db = new Database(); // экземпляр класса подключения к БД
    }
    
    /**
	* 
	* @param undefined $message текстовое сообщение которое добавляется в json ответ
	* 
	* @return json object
	*/
    static function error($message)
	{		
        Header('HTTP/1.1 404 Not Found'); //заголовок необязателен
        Header("Status: 404 Not Found"); //заголовок необязателен
        Header("Content-Type: text/html;charset=UTF-8"); //заголовок необязателен
        Header("Content-Type: application/json"); //заголовок обязателен
        die( json_encode( array('error' => $message) ) ); //json ответ и stop script
	}
	
	
	/**
	* 
	* @param undefined $json массив для формирования ответа
	* 
	* @return json object
	*/
	static function response($json)
	{		
        Header("HTTP/1.1 200 OK"); //заголовок необязателен
        Header("Content-Type: text/html;charset=UTF-8"); //заголовок необязателен
        Header("Content-Type: application/json"); //заголовок обязателен
        die( json_encode( $json ) ); //json ответ и stop script
	}
}

?>
