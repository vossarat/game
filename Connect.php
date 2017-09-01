<?php

/**
* class connect подключает игроков по ID
* необходимо передвать запрос типа
* '{"id":47, "gamer":"test"}'
* скрипт сам определит первый или второй игрок 
* если нет игры будет сгенерирована ошибка 'the game does not exist, need to create game'
* если заполнена будет сгенерирована ошибка 'game is FULL'
* 
*/
class Connect extends Controller
{
	public function index( $jsonData )
	{		
		$id = $jsonData['id'];
		$token = sha1(mt_rand(1, 90000) . $jsonData['gamer']); // генерация токена
		$gamer = $jsonData['gamer'];
		
		$oneOrTwoGamer = $this->oneOrTwoGamer($id);
		
		$whatGamer = 'gamer'.$oneOrTwoGamer;
		$whatToken = 'token'.$oneOrTwoGamer;
		
		if( $oneOrTwoGamer == 2 ){
			$stmt = $this->db->prepare('UPDATE thegame SET token2=:token, gamer2=:gamer WHERE id=:id'); // готовим запрос к msqql
			//выполение подготовленного запроса с параметрами
			$stmt->execute(array(
								':id'=>$id,
								':token'=>$token,
								':gamer'=>$gamer,
							));
		} else {
			$stmt = $this->db->prepare('UPDATE thegame SET token1=:token, gamer1=:gamer WHERE id=:id'); // готовим запрос к msqql
			//выполение подготовленного запроса с параметрами
			$stmt->execute(array(
								':id'=>$id,
								':token'=>$token,
								':gamer'=>$gamer,
							));
		}		
				
		// json для ответа 
		$json = array(
					'status' => 'add',
					'player' => $whatGamer,
					$whatToken => $token,
										
					);
		parent::response($json);
	}
	
	public function oneOrTwoGamer($id)
	{
		$stmt = $this->db->prepare('SELECT gamer1, gamer2 FROM thegame where id=:id');
		$stmt->execute(array(':id' => $id));
		$oneOrTwoGamer = $stmt->fetchall(PDO::FETCH_ASSOC);
		
		if(!array_key_exists('gamer1', $oneOrTwoGamer[0])){
			parent::error('the game does not exist, need to create game'); //ошибка если нет игры
		}
		if($oneOrTwoGamer[0]['gamer2']){
			parent::error('game is FULL'); //если есть второй игрок, то игра заполнена
		}
		if($oneOrTwoGamer[0]['gamer1']){
			return 2; //если есть перрвый игрок, то заполним второго
		}
		return 1;
	}

}
?>