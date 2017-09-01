<?php

/**
* class для редактирования данных по ID записи  
* 
*/
class Update extends Controller
{
	public function index( $jsonData )
	{
		$this->chkToken($jsonData['token']); // проверяем token на существование
		
		$data1 = '';
		$data2 = '';
		
		if( !array_key_exists('rewrite', $jsonData) ){
			$stmt = $this->db->prepare('SELECT array1, array2 FROM thegame WHERE token1=:token or token2=:token LIMIT 1');
			$stmt->execute( array(
				':token'=> $jsonData['token'],						
			) );
			$data = $stmt->fetchall(PDO::FETCH_ASSOC);
			$data1 = $data[0]['array1'];
			$data2 = $data[0]['array2'];
		}	
		
		$stmt = $this->db->prepare('UPDATE thegame SET array1=:data1, array2=:data2 WHERE token1=:token or token2=:token');		

		//выполение подготовленного запроса с параметрами
		$stmt->execute( array(
				':token'=> $jsonData['token'],						
				':data1'=> $data1.$jsonData['data'],						
				':data2'=> $data2.$jsonData['data'],						
		) );
		
		// json для ответа 
		$json = array(
					'status'=>'update',
					);
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

}
?>