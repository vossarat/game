<?php

/**
* class для редактирования данных по ID записи  
* 
*/
class Update extends Controller
{
	public function index( $jsonData )
	{
		$this->chkID($jsonData['id']); // проверяем ID на существование
		
		$stmt = $this->db->prepare('UPDATE thegame SET gamer1=:gamer1, gamer2=:gamer2, array1=:array1, array2=:array2, info=:info  WHERE id=:id'); // готовим запрос к mysql
		

		//выполение подготовленного запроса с параметрами
		$stmt->execute( array(
				':id'=>$jsonData['id'],
				':gamer1'=> isset($jsonData['gamer1']) ? $jsonData['gamer1'] : '', //еcли есть значение то изменяем  
				':gamer2'=> isset($jsonData['gamer2']) ? $jsonData['gamer2'] : '',
				':array1'=> isset($jsonData['array1']) ? $jsonData['array1'] : '',
				':array2'=> isset($jsonData['array2']) ? $jsonData['array2'] : '',
				'info'=> isset($jsonData['info']) ? $jsonData['info'] : '',						
		) );
		
		// json для ответа 
		$json = array(
					'status'=>'update',
					'id'=>$jsonData['id'],					
					);
		parent::response($json);
	}
	
	
	/**
	* 
	* @param undefined $id проверяем ID на дубль 
	* 
	* @return bool 0-если нет записей, >=1 если есть  
	*/
	public function chkID($id){
		$stmt = $this->db->prepare('SELECT COUNT(*) FROM thegame where id=:id');
		$stmt->execute(array(':id' => $id));
		$count = $stmt->fetchColumn();
		if($count == 0){
			parent::error('ID is not enabled');
		}
	}

}
?>