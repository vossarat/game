<?php

/**
* class для отображения данных данных по token  
* 
*/
class Show extends Controller
{
	public function index( $jsonData )
	{
		$this->chkToken($jsonData['token']); // проверяем token на существование
		
		// проверяем на совпадение по токену1
		$stmt = $this->db->prepare('SELECT array1 FROM thegame WHERE token1=:token LIMIT 1'); 
		$stmt->execute( array(
						':token'=>$jsonData['token'],
						) );
		$json = $stmt->fetchcolumn(); //получение данных
		
		//если данные есть 
		if($json){
			// и есть ключ очистки
			if( array_key_exists('clear', $jsonData) ) {
				$this->clear($jsonData['token']); //то чистим
			} 
			parent::response($json); //возврат чтения
		}
		
		// тоже самое проверяем на совпадение по токену2
		$stmt = $this->db->prepare('SELECT array2 FROM thegame WHERE token2=:token LIMIT 1'); 
		$stmt->execute( array(
						':token'=>$jsonData['token'],
						) );
		$json = $stmt->fetchcolumn();
		
		if( array_key_exists('clear', $jsonData) ) $this->clear($jsonData['token']);
		parent::response($json);
		
	}
	
	
	/**
	* 
	* @param undefined $token проверяем на существование 
	* 
	* @return bool 0-если нет записей, >=1 если есть  
	*/
	public function chkToken($token){
		$stmt = $this->db->prepare('SELECT COUNT(*) FROM thegame WHERE token1=:token or token2=:token');
		$stmt->execute(array(':token' => $token));
		$count = $stmt->fetchColumn();
		if($count == 0){
			parent::error('token is not enabled');
		}
	}
	
	public function clear($token)
	{
		$stmt = $this->db->prepare('UPDATE thegame SET array1="" WHERE token1=:token');		
		$stmt->execute( array(':token'=> $token) );
		$stmt = $this->db->prepare('UPDATE thegame SET array2="" WHERE token2=:token');		
		$stmt->execute( array(':token'=> $token) );
	}

}
?>