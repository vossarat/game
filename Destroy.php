<?php

/**
* class для удаления записи  
* 
*/
class Destroy extends Controller
{
	public function index( $jsonData )
	{
		$this->chkID($jsonData['id']); // проверяем ID на существование
		
		$stmt = $this->db->prepare('DELETE FROM thegame WHERE id=:id'); // готовим запрос к mysql
		
		//выполение подготовленного запроса с параметрами
		$stmt->execute( array(':id'=>$jsonData['id']) );
		
		// json для ответа 
		$json = array(
					'status'=>'delete',
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