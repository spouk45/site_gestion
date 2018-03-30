<?php 
class Account
{
	private $_userName;
	private $_userPass;	
	private $_userId;
	
	const ERROR_LOG='Login ou mot de passe incorrect';
	
	public function __construct($data)
	{	//if(!isset($data['connect'])){$data['connect']=null;}
		$this->setUserName(trim($data['name']));
		$this->setUserPass(trim($data['pass']));
	}
	
	private function setUserName($name)
	{
		if(preg_match('/[\$\^\+\\/\<\>\!\#\~|\`\']/',$name) || strlen($name) <3)// 3 à 15 caractères
		{
			throw new Exception('3 à 15 caractères et pas de caractères spéciaux.');
		}
		$this->_userName=$name;
	}
	
	private function setUserPass($pass)
	{
		if(!preg_match('/[^\<\>]/',$pass))
			{
					throw new Exception('Password: Certains caractères sont interdits.');

			}
		else 
		{
			if(strlen($pass) <3 || strlen($pass) >15) // 4 à 15 caractères
			{
					throw new Exception('Password: mini 4, maxi 15 caractères.');

			}
		}
		$this->_userPass=md5($pass);
	}
	
	public function setUserId($id)
	{
		if(is_numeric($id)){
			$this->_userId=$id;
		}
		else {
			throw new Exception('L\'id doit être un int.');
		}
	}
	
	public function checkPass($pass2){
		if(md5($pass2) != $this->getUserPass())
		{
			throw new Exception('Mots de passes différents.');
		}
		return true;
	}
	
	public function getUserId()
	{
		return $this->_userId;
	}
	public function getUserName()
	{
		return $this->_userName;
	}
	
	public function getUserPass()
	{
		return $this->_userPass;
	}
}

class AccountManager
{	
	private $_db;

	const ERROR_LOG='Login ou mot de passe incorrect';
	const ERROR_USER_ID='Erreur lors de la récupération de l\'user id';

	public function __construct(PDO $db)
	{
		$this->_db=$db;
	}
	public function checkConnect($data){
		$name=$data['name'];
		$pass=md5($data['pass']);

		$sql='SELECT id FROM user WHERE name=:name AND pass=:pass';
		$stmnt=$this->_db->prepare($sql);
		$stmnt->bindParam(':name',$name);
		$stmnt->bindParam(':pass',$pass);
		$stmnt->execute();
		if(!$row=$stmnt->fetch(PDO::FETCH_ASSOC))
		{
			throw new Exception(self::ERROR_LOG);
		}
		return $row['id'];
	}

	public  function getLevel($userId){
		$sql='SELECT id,admin,tech FROM level WHERE user_id=:userId';
		$stmnt=$this->_db->prepare($sql);
		$stmnt->bindParam(':userId',$userId);
		$stmnt->execute();
		$error=$stmnt->errorInfo();
		if($error[0]!=00000){
			throw new Exception($error[2]);
		}

		while($row=$stmnt->fetch(PDO::FETCH_ASSOC))
		{
			$data['id']=$row['id'];
			$data['admin']=$row['admin'];
			$data['tech']=$row['tech'];
		}
		if($data==null){
			throw new Exception(self::ERROR_USER_ID);
		}
		return $data;
	}

	public function addUser(Account $Account)
	{
		$pass=$Account->getUserPass();
		$name=$Account->getUserName();

		$sql='INSERT INTO user(name,pass) VALUES (:name,:pass)';
		$stmnt=$this->_db->prepare($sql);
		$stmnt->bindParam(':name',$name);
		$stmnt->bindParam(':pass',$pass);
		$stmnt->execute();
		if($stmnt->rowCount() == 0)
		{
			throw new Exception('L\'enregistrement semble avoir échoué.');
		}

		return true;
	}

	public function userList(){
		$sql='SELECT id,name FROM user';
		$stmnt=$this->_db->prepare($sql);
		$stmnt->execute();
		$error=$stmnt->errorInfo();
		if($error[0]!=00000){
			throw new Exception($error[2]);
		}

		$i=0;
		$data=null;
		while($row=$stmnt->fetch(PDO::FETCH_ASSOC)){
			$data[$i]['id']=$row['id'];
			$data[$i]['name']=$row['name'];
		}

		if($data==null){
			throw new Exception('Aucun utilisateurs dans la liste.');
		}
		return $data;
	}
/*
	public function getUserId(Account $Account){
		$pass=$Account->getUserPass();
		$user=$Account->getUserName();
			
		$sql='SELECT account_id FROM account WHERE user=:user AND pass=:pass';
		$stmnt=$this->_db->prepare($sql);
		$stmnt->bindParam(':user',$user);
		$stmnt->bindParam(':pass',$pass);
		$stmnt->execute();
		if(!$row=$stmnt->fetch(PDO::FETCH_ASSOC))
				{
					throw new Exception('Login ou mot de passe incorrect.');
				}	
		return $row['account_id'];
	}
	*/
	/*
	public function checkLogin(Account $Account)
	{
		$user=$Account->getUserName();
		
		$sql='SELECT COUNT(account_id) FROM account WHERE user=:user';
		$stmnt=$this->_db->prepare($sql);
		$stmnt->bindParam(':user',$user);		
		$stmnt->execute();
		$row=$stmnt->fetch(PDO::FETCH_ASSOC);	
		return $row['COUNT(account_id)'];
	}
	*/



	/*
	public function getNameByAccountId($id)
	{
		$sql='SELECT user FROM account WHERE account_id=:id';
		$stmnt=$this->_db->prepare($sql);		
		$stmnt->bindParam(':id',$id);		
		$stmnt->execute();
		if(!$row=$stmnt->fetch(PDO::FETCH_ASSOC))
				{
					throw new Exception('Erreur lors de la récupération du nom account.');
				}	
		return $row['user'];
	}
*/
}