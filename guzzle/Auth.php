<?php 

require_once 'modele.php';

class Auth
{

	public function allow($username)
	{
		$bdd = new BDD();
		$_SESSION['ID']=$bdd->getUserID($username);
		$_SESSION['LEVEL']=$bdd->getUserLevel($username);
		//echo $_SESSION['LEVEL'];
		$level = array();
	}



}

?>