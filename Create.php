<?php

/**
* class для добавления записи  
* 
*/
class Create extends Controller
{
	public function index( $jsonData )
	{
		$this->chkID($jsonData['id']); // проверяем ID на дубль 
		
		$stmt = $this->db->prepare('INSERT INTO thegame (id) VALUES (:id)'); // готовим запрос к msqql
		//выполение подготовленного запроса с параметрами
		$stmt->execute(array(
							':id'=>$jsonData['id'],
						));
		$lastInsertId = $this->db->lastInsertId(); // последний добавленный ID
		
		// json для ответа 
		$json = array(
					'status'=>'add',
					'id'=>$lastInsertId,					
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
		if($count){
			parent::error('ID is enabled');
		}
	}

}
?>