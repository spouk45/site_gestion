<?php 
class Generic {
	protected $_db;

	public function __construct(PDO $db)
	{
		$this->_db = $db;
	}

	// ************* info ********
	// $tableDB : table de la base où on recherche
	//$data : les champ à rechercher (array)
	//$param : AND ou OR si un champ avec plusieur valeur a rechercher
	//$list: nom des champs de la base qu'on souhaite récuperer
	//*************
	public function getData($tableDB,$data,$param,$list,$order){
		$seek=''; // init des champ à rechercher
		if($tableDB==null){ // table de la base où on recherche
			throw new Exception('tableDB est vide');
		}
		if ($data == null) {
			$where='';
		}
		else if(!is_array ($data)){
			throw new Exception('data doit etre array');
		}
		else {
			$where=' WHERE ';
			if($param != 'OR' && $param != 'AND' && $param != null){
				throw new Exception('mauvais param�tre entr�');
			}
			if($param =='' && count($data)>1){
				throw new Exception('le parametre ne peut pas etre null -> OR ou AND');
			}

			// --- where ----
			$i=0;


			foreach($data as $key => $value){
				if(is_array($value)) {

					foreach ($value as $key2=>$value2){
						if($i==0){
							if(preg_match('/[*]/',$value2)) {
								$seek .= $key . ' LIKE :' . $key . $key2;
							}
							else{
								$seek .= $key . '=:' . $key . $key2;
							}
						}
						else {
							if(preg_match('/[*]/',$value2)) {
								$seek .= ' ' . $param . ' ' . $key . ' LIKE :' . $key . $key2;
							}
							else {
								$seek .= ' ' . $param . ' ' . $key . '=:' . $key . $key2;
							}
						}
						$i++;
					}
				}
				else {
					if ($i == 0) {
						if(preg_match('/[*]/',$value)){
							$seek .= $key . ' LIKE :' . $key;
						}
						else{
							$seek .= $key . '=:' . $key;
						}
					}
					else {
						if(preg_match('/[*]/',$value)){
							$seek .= $key . ' LIKE :' . $key;
						}
						else{
							$seek .= ' ' . $param . ' ' . $key . ' =:' . $key;
						}
					}
				}
				$i++;
			}
		}

		if($list==null){$field='*';}
		else{$field=$list;}

		if($order!=null){
			$order=' ORDER BY '.$order;
		}
		$sql='SELECT '.$field.' FROM '.$tableDB.$where.$seek.$order;

		// -------------------
		//echo $sql.'<br>';print_r($data);

		// ---------------------
		$stmnt=$this->_db->prepare($sql);
		if($data!=null){
			foreach($data as $key => $value){
				if(is_array($value)){
					foreach($value as $key2=>$value2){
						$stmnt->bindValue(':'.$key.$key2,$value2);
					}
				}
				else {
					if(preg_match('/[*]/',$value)) {
						$rep=str_replace('*','%',$value);
						$stmnt->bindValue(':' .$key, $rep);
					}
					else{
						$stmnt->bindValue(':' . $key, $value);
					}
				}
			}
		}

		$stmnt->execute();
		$error=$stmnt->errorInfo();

		if($error[0]!=00000){
			throw new Exception($error[2]);
		}
		$data=null;
		$i=0;
		//$count = $stmnt->rowCount();
		while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
		{
			//if($count>1){
				foreach($row as $key=>$value){
					$data[$i][$key]=$row[$key];
				}
			//}
			/*else{
				foreach($row as $key=>$value){
					$data[$key]=$value;
				}
			}*/
			$i++;
		}
		return $data;
	}
}