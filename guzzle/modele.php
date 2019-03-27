<?php 

class BDD
{
	// déclaration des variables;
	private $pdo;


	// fonction qui se connecte à la BDD AdminOVH
	public function __construct()
	{
		$host='localhost';
		$dbname='AdminOVH';
		$loginBdd='root';
		$passwordBdd='';

		try
		{
			$this->pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $loginBdd, $passwordBdd);
		}

		catch(Exception $e)
		{
			die('Erreur : '. $e->getMessage());
		}
	}

	// nouvelles fonction 
	public function getPass($username)
	{
		//récupère le mot de passe correspondant au nom d'utilisateur entré en paramètre
		$password = $this->pdo->prepare('SELECT mdp FROM user WHERE login=?');
		$password->execute(array($username));
		$password = $password->fetch();
		return($password['mdp']);
	}

	public function getUserID($username)
	{
		//récupère le mot de passe correspondant au nom d'utilisateur entré en paramètre
		$userID = $this->pdo->prepare('SELECT id FROM user WHERE login=?');
		$userID->execute(array($username));
		$userID = $userID->fetch();
		return($userID['id']);
	}

	public function getUserLevel($username)
	{
		//récupère le rôle correspondant au nom d'utilisateur entré en paramètre
		$userLevel = $this->pdo->prepare('SELECT level FROM user WHERE login=?');
		$userLevel->execute(array($username));
		$userLevel = $userLevel->fetch();
		return($userLevel['level']);
	}

	public function addNewUser($userToAdd)
	{
		$newUser = $this->pdo->prepare('INSERT INTO user (nom, prenom, login, mdp, email, level) VALUES (:nom, :prenom, :login, :mdp, :email, :level) ');
		$newUser->bindValue(':nom', $userToAdd['nom'], PDO::PARAM_STR);
		$newUser->bindValue(':prenom', $userToAdd['prenom'], PDO::PARAM_STR);
		$newUser->bindValue(':login', $userToAdd['login'], PDO::PARAM_STR);
		$newUser->bindValue(':mdp', $userToAdd['mdp'], PDO::PARAM_STR);
		$newUser->bindValue(':email', $userToAdd['email'], PDO::PARAM_STR);
		$newUser->bindValue(':level', $userToAdd['level'], PDO::PARAM_STR);
		$newUser->execute();
	}

	public function addNewClient($clientToAdd)
	{
		$newClient = $this->pdo->prepare('INSERT INTO client (nom, tel, email) VALUES (:nom, :tel, :email) ');
		$newClient->bindValue(':nom', $clientToAdd['nom'], PDO::PARAM_STR);
		$newClient->bindValue(':tel', $clientToAdd['tel'], PDO::PARAM_STR);
		$newClient->bindValue(':email', $clientToAdd['email'], PDO::PARAM_STR);
		//$newClient->execute();

		if($newClient->execute() == false)
		{
			echo "\nPDOStatement::errorCode(): ";
			print $newClient->errorCode();
			echo "\nPDOStatement::errorInfo():\n";
			$error = $newClient->errorInfo();
			print_r($error);
		}
	}

	public function deleteClient($clientToDelete)
	{
		$deleteClient = $this->pdo->prepare('DELETE FROM client WHERE client.id = :idClient');
		$deleteClient->bindValue(':idClient', $clientToDelete, PDO::PARAM_STR);
		$deleteClient->execute();
	}

	public function deleteUser($userToDelete)
	{
		$deleteUser = $this->pdo->prepare('DELETE FROM user WHERE user.id = :idUser');
		$deleteUser->bindValue(':idUser', $userToDelete, PDO::PARAM_STR);
		$deleteUser->execute();
	}






	public function bindVpsToDomain(array $vpsToBind)
	{	
		$bindVpstoDomain = $this->pdo->prepare('INSERT INTO vpsXdomain (idVps, idDomain) VALUES (:idVps, :idDomain) ');
		$bindVpstoDomain->bindValue(':idVps', $vpsToBind['idVps'], PDO::PARAM_INT);
		$bindVpstoDomain->bindValue(':idDomain', $vpsToBind['idDomain'], PDO::PARAM_INT);
		$bindVpstoDomain->execute();

	}

	public function unbindVpsToDomain($vpsToUnbind)
	{	
		$unbindVpsToDomain = $this->pdo->prepare('DELETE FROM vpsXdomain WHERE vpsXdomain.idVps = :idVps  ');
		$unbindVpsToDomain->bindValue(':idVps', $vpsToUnbind, PDO::PARAM_INT);
		$unbindVpsToDomain->execute();
	}



	public function bindVpsToClient(array $vpsToBind)
	{
		$bindVpstoClient = $this->pdo->prepare('INSERT INTO clientXvps (idClient, idVps) VALUES (:idClient, :idVps)');
		$bindVpstoClient->bindValue(':idClient', $vpsToBind['idClient'], PDO::PARAM_INT);
		$bindVpstoClient->bindValue(':idVps', $vpsToBind['idVps'], PDO::PARAM_INT);
		$bindVpstoClient->execute();
	}

	public function unbindVpsToClient($vpsToUnbind)
	{
		$unbindVpsToClient = $this->pdo->prepare('DELETE FROM clientXvps WHERE clientXvps.idVps = :idVps');
		$unbindVpsToClient->bindValue(':idVps', $vpsToUnbind, PDO::PARAM_INT);
		$unbindVpsToClient->execute();
	}



	public function bindDomainToVps(array $domainToBind)
	{	
		$bindDomainToVps = $this->pdo->prepare('INSERT INTO vpsXdomain (idVps, idDomain) VALUES (:idVps, :idDomain) ');
		$bindDomainToVps->bindValue(':idVps', $domainToBind['idVps'], PDO::PARAM_INT);
		$bindDomainToVps->bindValue(':idDomain', $domainToBind['idDomain'], PDO::PARAM_INT);
		$bindDomainToVps->execute();
	}

	public function unbindDomainToVps($domainToUnbind)
	{
		$unbindDomainToVps = $this->pdo->prepare('DELETE FROM vpsXdomain WHERE vpsXdomain.idDomain = :idDomain');
		$unbindDomainToVps->bindValue(':idDomain', $domainToUnbind, PDO::PARAM_INT);
		$unbindDomainToVps->execute();
	}



	public function bindDomainToClient(array $domainToBind)
	{
		$bindDomainToClient = $this->pdo->prepare('INSERT INTO clientXdomain (idClient, idDomain) VALUES (:idClient, :idDomain) ');
		$bindDomainToClient->bindValue(':idClient', $domainToBind['idClient'], PDO::PARAM_INT);
		$bindDomainToClient->bindValue(':idDomain', $domainToBind['idDomain'], PDO::PARAM_INT);
		$bindDomainToClient->execute();
	}

	public function unbindDomainToClient($domainToUnbind)
	{
		$unbindDomainToVps = $this->pdo->prepare('DELETE FROM clientXdomain WHERE clientXdomain.idDomain = :idDomain');
		$unbindDomainToVps->bindValue(':idDomain', $domainToUnbind, PDO::PARAM_INT);
		$unbindDomainToVps->execute();
	}



	public function bindClientToVps(array $clientToBind)
	{	
		$bindClientToVps = $this->pdo->prepare('INSERT INTO clientXvps (idClient, idVps) VALUES (:idClient, :idVps) ');
		$bindClientToVps->bindValue(':idClient', $clientToBind['idClient'], PDO::PARAM_INT);
		$bindClientToVps->bindValue(':idVps', $clientToBind['idVps'], PDO::PARAM_INT);
		$bindClientToVps->execute();
	}

	public function unbindClientToVps($clientToUnbind)
	{
		$unbindClientToVps = $this->pdo->prepare('DELETE FROM clientXvps WHERE clientXvps.idClient = :idClient');
		$unbindClientToVps->bindValue(':idClient', $clientToUnbind, PDO::PARAM_INT);
		$unbindClientToVps->execute();
	}



	public function bindClientToDomain(array $clientToBind)
	{
		$bindClientToDomain = $this->pdo->prepare('INSERT INTO clientXdomain (idClient, idDomain) VALUES (:idClient, :idDomain) ');
		$bindClientToDomain->bindValue(':idClient', $clientToBind['idClient'], PDO::PARAM_INT);
		$bindClientToDomain->bindValue(':idDomain', $clientToBind['idDomain'], PDO::PARAM_INT);
		$bindClientToDomain->execute();
	}

	public function unbindClientToDomain($clientToUnbind)
	{
		$unbindClientToDomain = $this->pdo->prepare('DELETE FROM clientXdomain WHERE clientXdomain.idClient = :idClient');
		$unbindClientToDomain->bindValue(':idClient', $clientToUnbind, PDO::PARAM_INT);
		$unbindClientToDomain->execute();
	}




	public function getDomainBindToVps($idVps)
	{
		$getDomainBindToVps = $this->pdo->prepare('SELECT id, name, contact_billing, billing_status, renew_period, renew_automatic, expiration, ovh FROM vpsXdomain 
		INNER JOIN domain ON vpsXdomain.idDomain = domain.id WHERE vpsXdomain.idVps = :idVps');
		$getDomainBindToVps->bindValue(':idVps', $idVps, PDO::PARAM_INT);
		$getDomainBindToVps->execute();
		$infos = $getDomainBindToVps->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}

	public function getDomainNameBindToVps($idVps)
	{
		$getDomainBindToVps = $this->pdo->prepare('SELECT name FROM vpsXdomain INNER JOIN domain ON vpsXdomain.idDomain = domain.id WHERE vpsXdomain.idVps = :idVps');
		$getDomainBindToVps->bindValue(':idVps', $idVps, PDO::PARAM_INT);
		$getDomainBindToVps->execute();
		$infos = $getDomainBindToVps->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}

	public function getDomainIdBindToVps($idVps)
	{
		$getDomainBindToVps = $this->pdo->prepare('SELECT id FROM vpsXdomain INNER JOIN domain ON vpsXdomain.idDomain = domain.id WHERE vpsXdomain.idVps = :idVps');
		$getDomainBindToVps->bindValue(':idVps', $idVps, PDO::PARAM_INT);
		$getDomainBindToVps->execute();
		$infos = $getDomainBindToVps->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}





	public function getClientBindToVps($idVps)
	{
		$getClientBindToVps = $this->pdo->prepare('SELECT id, nom, tel, email FROM clientXvps 
		INNER JOIN client ON clientXvps.idClient = client.id WHERE clientXvps.idVps = :idVps');
		$getClientBindToVps->bindValue(':idVps', $idVps, PDO::PARAM_INT);
		$getClientBindToVps->execute();
		$infos = $getClientBindToVps->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}

	public function getClientNameBindToVps($idVps)
	{
		$getClientBindToVps = $this->pdo->prepare('SELECT nom FROM clientXvps INNER JOIN client ON clientXvps.idClient = client.id WHERE clientXvps.idVps = :idVps');
		$getClientBindToVps->bindValue(':idVps', $idVps, PDO::PARAM_INT);
		$getClientBindToVps->execute();
		$infos = $getClientBindToVps->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}

	public function getClientIdBindToVps($idVps)
	{
		$getClientBindToVps = $this->pdo->prepare('SELECT id FROM clientXvps INNER JOIN client ON clientXvps.idClient = client.id WHERE clientXvps.idVps = :idVps');
		$getClientBindToVps->bindValue(':idVps', $idVps, PDO::PARAM_INT);
		$getClientBindToVps->execute();
		$infos = $getClientBindToVps->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}






	public function getVpsBindToDomain($idDomain)
	{
		$getVpsBindToDomain = $this->pdo->prepare('SELECT id, name, display_name, zone, state, cluster, offer, contact_billing, billing_status, renew_period, renew_automatic, expiration, ovh FROM vpsXdomain 
		INNER JOIN vps ON vpsXdomain.idVps = vps.id WHERE vpsXdomain.idDomain = :idDomain');
		$getVpsBindToDomain->bindValue(':idDomain', $idDomain, PDO::PARAM_INT);
		$getVpsBindToDomain->execute();
		$infos = $getVpsBindToDomain->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}

	public function getVpsNameBindToDomain($idDomain)
	{
		$getVpsBindToDomain = $this->pdo->prepare('SELECT display_name FROM vpsXdomain INNER JOIN vps ON vpsXdomain.idVps = vps.id WHERE vpsXdomain.idDomain = :idDomain');
		$getVpsBindToDomain->bindValue(':idDomain', $idDomain, PDO::PARAM_INT);
		$getVpsBindToDomain->execute();
		$infos = $getVpsBindToDomain->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}

	public function getVpsIdBindToDomain($idDomain)
	{
		$getVpsBindToDomain = $this->pdo->prepare('SELECT id FROM vpsXdomain INNER JOIN vps ON vpsXdomain.idVps = vps.id WHERE vpsXdomain.idDomain = :idDomain');
		$getVpsBindToDomain->bindValue(':idDomain', $idDomain, PDO::PARAM_INT);
		$getVpsBindToDomain->execute();
		$infos = $getVpsBindToDomain->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}




	public function getClientBindToDomain($idDomain)
	{
		$getClientBindToDomain = $this->pdo->prepare('SELECT id, nom, tel, email FROM clientXdomain 
		INNER JOIN client ON clientXdomain.idClient = client.id WHERE clientXdomain.idDomain = :idDomain');
		$getClientBindToDomain->bindValue(':idDomain', $idDomain, PDO::PARAM_INT);
		$getClientBindToDomain->execute();
		$infos = $getClientBindToDomain->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}

	public function getClientNameBindToDomain($idDomain)
	{
		$getClientBindToDomain = $this->pdo->prepare('SELECT nom FROM clientXdomain 
		INNER JOIN client ON clientXdomain.idClient = client.id WHERE clientXdomain.idDomain = :idDomain');
		$getClientBindToDomain->bindValue(':idDomain', $idDomain, PDO::PARAM_INT);
		$getClientBindToDomain->execute();
		$infos = $getClientBindToDomain->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}

	public function getClientIdBindToDomain($idDomain)
	{
		$getClientBindToDomain = $this->pdo->prepare('SELECT id FROM clientXdomain 
		INNER JOIN client ON clientXdomain.idClient = client.id WHERE clientXdomain.idDomain = :idDomain');
		$getClientBindToDomain->bindValue(':idDomain', $idDomain, PDO::PARAM_INT);
		$getClientBindToDomain->execute();
		$infos = $getClientBindToDomain->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}




	public function getVpsBindToClient($idClient)
	{
		$getVpsBindToClient = $this->pdo->prepare('SELECT id, name, display_name, zone, state, cluster, offer, contact_billing, billing_status, renew_period, renew_automatic, expiration, ovh FROM clientXvps 
		INNER JOIN vps ON clientXvps.idVps = vps.id WHERE clientXvps.idClient = :idClient');
		$getVpsBindToClient->bindValue(':idClient', $idClient, PDO::PARAM_INT);
		$getVpsBindToClient->execute();
		$infos = $getVpsBindToClient->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}

	public function getVpsNameBindToClient($idClient)
	{
		$getVpsBindToClient = $this->pdo->prepare('SELECT display_name FROM clientXvps 
		INNER JOIN vps ON clientXvps.idVps = vps.id WHERE clientXvps.idClient = :idClient');
		$getVpsBindToClient->bindValue(':idClient', $idClient, PDO::PARAM_INT);
		$getVpsBindToClient->execute();
		$infos = $getVpsBindToClient->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}

	public function getVpsIdBindToClient($idClient)
	{
		$getVpsBindToClient = $this->pdo->prepare('SELECT id FROM clientXvps 
		INNER JOIN vps ON clientXvps.idVps = vps.id WHERE clientXvps.idClient = :idClient');
		$getVpsBindToClient->bindValue(':idClient', $idClient, PDO::PARAM_INT);
		$getVpsBindToClient->execute();
		$infos = $getVpsBindToClient->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}



	public function getDomainBindToClient($idClient)
	{
		$getDomainBindToClient = $this->pdo->prepare('SELECT id, name, contact_billing, billing_status, renew_period, renew_automatic, expiration, ovh FROM clientXdomain 
		INNER JOIN domain ON clientXdomain.idDomain = domain.id WHERE clientXdomain.idClient = :idClient');
		$getDomainBindToClient->bindValue(':idClient', $idClient, PDO::PARAM_INT);
		$getDomainBindToClient->execute();
		$infos = $getDomainBindToClient->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}

	public function getDomainNameBindToClient($idClient)
	{
		$getDomainBindToClient = $this->pdo->prepare('SELECT name FROM clientXdomain 
		INNER JOIN domain ON clientXdomain.idDomain = domain.id WHERE clientXdomain.idClient = :idClient');
		$getDomainBindToClient->bindValue(':idClient', $idClient, PDO::PARAM_INT);
		$getDomainBindToClient->execute();
		$infos = $getDomainBindToClient->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}

	public function getDomainIdBindToClient($idClient)
	{
		$getDomainBindToClient = $this->pdo->prepare('SELECT id FROM clientXdomain 
		INNER JOIN domain ON clientXdomain.idDomain = domain.id WHERE clientXdomain.idClient = :idClient');
		$getDomainBindToClient->bindValue(':idClient', $idClient, PDO::PARAM_INT);
		$getDomainBindToClient->execute();
		$infos = $getDomainBindToClient->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}













	private function insert($table_name, array $columns, array $data)
	{
		$column_names =  array_keys($columns);

		$insert = $this->pdo->prepare('INSERT INTO ' . $table_name . ' ' . '(' . implode(", ", $column_names) . ')'. ' VALUES ' . '(' . ':' . implode(", :", $column_names) . ')');

		foreach ($columns as $key => $value) 
		{
			$insert ->bindvalue($key, $data[$key], $value);
		}

		$insert->execute();
	}


	// Fonction qui permet l'insertion des nouveaux vps
	public function arrayDiffVpsInsert($vps_api, $vps_bdd)
	{
		$return = [];

	    foreach ($vps_api as $key_api => $value_api)
	    {
	        $isFound = false;
	        
	        foreach ($vps_bdd as $key_bdd => $value_bdd)
	        {
	            if($value_api['name'] == $value_bdd['name'])
	            {
	                $isFound = true;                	
	            } 
	        }

	        if($isFound == false)
	        {
	        	$this->insert('vps', ['name' => PDO::PARAM_STR,'display_name' => PDO::PARAM_STR, 'zone' => PDO::PARAM_STR, 'state' => PDO::PARAM_STR, 'cluster' => PDO::PARAM_STR, 'offer' => PDO::PARAM_STR, 'contact_billing' => PDO::PARAM_STR, 'billing_status' => PDO::PARAM_STR, 'renew_period' => PDO::PARAM_INT, 'renew_automatic' => PDO::PARAM_BOOL, 'expiration' => PDO::PARAM_STR], $value_api);
	        }

	        $return[$value_api['name']] = !$isFound;
		}

	   	return $return; 
	}

	// Fonction qui permet l'insertion des nouveaux domain
	public function arrayDiffDomainInsert($domain_api, $domain_bdd)
	{
		$return = [];

	    foreach ($domain_api as $key_api => $value_api)
	    {
	        $isFound = false;

	        foreach ($domain_bdd as $key_bdd => $value_bdd)
	        {
	            if($value_api['name'] == $value_bdd['name'])
	            {
	                $isFound = true;
	            } 
	        }  

	        if($isFound == false)
	        {  
				$this->insert('domain', ['name' => PDO::PARAM_STR ,'contact_billing' => PDO::PARAM_STR, 'billing_status' => PDO::PARAM_STR, 'renew_period' => PDO::PARAM_INT, 'renew_automatic' => PDO::PARAM_BOOL, 'expiration' => PDO::PARAM_STR], $value_api);
	        }

	        $return[$value_api['name']] = !$isFound; 
	    }

	    return $return; 
	}



	private function update($table_name, array $columns, array $data)
	{
	    $column_names =  array_keys($columns);

		//$update = $this->pdo->prepare('UPDATE ' . $table_name . ' ' . 'SET' . ' ' . implode(", ", $column_names) . ' ' . ':' . implode(", :", $column_names) . ' ' . 'WHERE name = :name' );
		$sql = 'UPDATE ' . $table_name . ' SET ' ;

		foreach ($column_names as $value)
		{
			if($value!='name')
			{
				$sql .= $value.' = :'.$value.', ';
			}
		}

		$sql = substr($sql,0,-1);
		$sql .= ' ovh = 1' . ' ' . 'WHERE name = :name';
		$update = $this->pdo->prepare($sql );
		
		foreach ($columns as $key => $value) 
		{
			$update ->bindvalue($key, $data[$key], $value);
		}

		$update->execute();
	}


    private function arrayEquals($array_api, $array_bdd)
    {	      
	    $oui = true;

    	foreach ($array_api as $key => $value_api) {
    		if(!isset($array_bdd[$key]) || $array_bdd[$key] != $value_api){
    			$oui = false;
    		}
    	}
		      
    	return $oui;
    }


	// fonction qui permet d'update des nouvelles infos vps
	public function arrayDiffVpsUpdate($vps_api, $vps_bdd)
	{
		$return = [];

	    foreach ($vps_api as $key_api => $value_api)
	    {
	        $isFound = false;
	        $infosEquals = false;

	        foreach ($vps_bdd as $key_bdd => $value_bdd)
	        {
	            if($value_api['name'] == $value_bdd['name'])
	            {
	                $isFound = true;

	                if($this->arrayEquals($value_api, $value_bdd))
	                {
	                    $infosEquals = true;
	                } 
	            } 
	        } 

	        if($isFound)
	        {
	            if($infosEquals == false)
	            {
	            	$this->update('vps', ['name' => PDO::PARAM_STR,'display_name' => PDO::PARAM_STR, 'zone' => PDO::PARAM_STR, 'state' => PDO::PARAM_STR, 'cluster' => PDO::PARAM_STR, 'offer' => PDO::PARAM_STR, 'contact_billing' => PDO::PARAM_STR, 'billing_status' => PDO::PARAM_STR, 'renew_period' => PDO::PARAM_INT, 'renew_automatic' => PDO::PARAM_BOOL, 'expiration' => PDO::PARAM_STR], $value_api); 
	            }   
	    	}

	    	$return[$value_api['name']] = !$infosEquals;
		}

		return $return;
	}


	public function arrayDiffDomainUpdate($domain_api, $domain_bdd)
	{
		$return = [];

	    foreach ($domain_api as $key_api => $value_api)
	    {
	        $isFound = false;
	        $infosEquals = false;

	        foreach ($domain_bdd as $key_bdd => $value_bdd)
	        {
	            if($value_api['name'] == $value_bdd['name'])
	            {
	                $isFound = true;

	                if($this->arrayEquals($value_api, $value_bdd))
	                {
	                    $infosEquals = true;
	                    
	                } 
	            } 
	        } 

	        if($isFound)
	        {
	            if($infosEquals == false)
	            {
	                $this->update('domain', ['name' => PDO::PARAM_STR, 'contact_billing' => PDO::PARAM_STR, 'billing_status' => PDO::PARAM_STR, 'renew_period' => PDO::PARAM_INT, 'renew_automatic' => PDO::PARAM_BOOL, 'expiration' => PDO::PARAM_STR], $value_api);
	            }
	        }

	        $return[$value_api['name']] = !$infosEquals; 
	    } 

	    return $return;
	}




	private function arrayDiffFlag($table_name, array $columns, array $data)
	{
		$column_names =  array_keys($columns);

		$update = $this->pdo->prepare('UPDATE ' . $table_name . ' ' . 'SET ovh = ' . 0 . ' ' . 'WHERE name = :name' );

		foreach ($columns as $key => $value) 
		{
			$update ->bindvalue($key, $data[$key], $value);
			var_dump($data[$key]);
		}

		$update->execute();
	}



	// Fonction qui va mettre le flag ovh à 0 si le vps n'est plus sur l'API
	public function arrayDiffVpsFlag($vps_bdd, $vps_api)
	{
		$return = [];

	    $resultDiff= array();

	    foreach ($vps_bdd as $key_bdd => $value_bdd)
	    {
	        $isFound = false;
	        foreach ($vps_api as $key_api => $value_api)
	        {
	            if($value_bdd['name'] == $value_api['name'])
	            {
		            $isFound = true;
	            }

	        }

	        if($isFound == false)
	        {
	            $this->arrayDiffFlag('vps', ['name' => PDO::PARAM_STR], $value_bdd);
	        }

	        $return[$value_bdd['name']] = !$isFound; 
	    }

	    return $return;
	}


	// Fonction qui va mettre le flag ovh à 0 si le domain n'est plus sur l'API
	public function arrayDiffDomainFlag($domain_bdd, $domain_api)
	{
		$return = [];

	    $resultDiff= array();

	    foreach ($domain_bdd as $key_bdd => $value_bdd)
	    {
	        $isFound = false;
	        foreach ($domain_api as $key_api => $value_api)
	        {
	            if($value_bdd['name'] == $value_api['name'])
	            {
	                $isFound = true;
	            }
	        }

	        if($isFound == false)
	        {
	           $this->arrayDiffFlag('domain', ['name' => PDO::PARAM_STR], $value_bdd);
	        }

	        $return[$value_bdd['name']] = !$isFound;
	    }

	    return $return;
	}


	private function get(array $column_names, $table_name)
	{
		$get = $this->pdo->prepare('SELECT '.implode(",", $column_names).' FROM ' . $table_name);
		$get->execute();
		$infos = $get->fetchAll(PDO::FETCH_ASSOC);
		return $infos;
	}

	// Fonction qui permet la récupération des données vps
	public function getVpsListBdd()
	{	
		return $this->get(['id', 'name','display_name', 'zone', 'state', 'cluster', 'offer', 'contact_billing', 'billing_status', 'renew_period', 'renew_automatic', 'expiration', 'ovh'],'vps');
	}

	// Fonction qui permet la récupération des données domain
	public function getDomainListBdd()
	{	
		return $this->get(['id', 'name','contact_billing', 'billing_status', 'renew_period', 'renew_automatic', 'expiration', 'ovh'],'domain');
	}

	// Fonction qui permet la récupération des données domain
	public function getClientListBdd()
	{	
		return $this->get(['id', 'nom','tel', 'email'],'client');
	}

	public function getUserListBdd()
	{	
		return $this->get(['id', 'nom','prenom', 'email', 'level'],'user');
	}
}


?>