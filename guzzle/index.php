<?php

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

session_start(); // On démarre la session avant d'écrire du PHP
$_SESSION['logged']=TRUE;

require_once 'controleur.php';
require_once 'Auth.php';

$bdd = new Bdd();
$vps_bdd = $bdd->getVpsListBdd();
$domain_bdd = $bdd->getDomainListBdd();
$client_bdd = $bdd->getClientListBdd();

// attention : toutes les urls prennent index.php comme referentiel, 
//on se considere toujours dans le dossier contenant index.php

try
{
	//var_dump($_SESSION['ID']);

	if(isset($_GET['action'])==false)
	{
		$_GET['action']=null;
	}

	$action = $_GET['action'];

	// si aucune action définie : affichage de la page login
	if($action==null)
	{
		login();
	}

	if($action=="logged")
	{
		if((isset($_POST['login']) && isset($_POST['password'])) && testLoginMatch($_POST['login'],$_POST['password'])==true)
		{
			logged($_POST['login']);
			$auth = new Auth();
			$auth->allow($_POST['login']);
		}

		else
		{
			//Si le mot de passe ne correspond pas
			//Renvoie l'utilisateur vers la page de connexion (!)-> vueErreurLogin.php afin qu'il puisse entrer à nouveau ses identifiants
			erreurLogin(); 
		}
	}

	if(isset($_SESSION['logged'])==false)
	{
		$_SESSION['logged']=false;
	}

	if($_SESSION['logged']==false)
	{
		login();
	} 

	elseif($action=="logout")
	{
		logout();					
	}

	elseif($action=="update")
	{
		update();					
	}

	elseif($action=="consul")
	{
		consul();					
	}

	elseif($action=="goAddUser")
	{
		goAddUser();					
	}

	elseif($action=="goAddClient")
	{
		goAddClient();					
	}

	elseif($action=="goModifClient")
	{
		goModifClient();					
	}

	elseif($action=="goModifUser")
	{
		goModifUser();					
	}

	elseif($action=="addUser")
	{
		$email = $_POST['email'];

		if (filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			addUser($_POST['nom'], $_POST['prenom'], $_POST['login'], $_POST['mdp'], $email, $_POST['level'] );
			echo "L'utilisateur a bien été ajouté !";
		}
		
		else
		{
			if (filter_var($email, FILTER_VALIDATE_EMAIL) == false)
			{
				echo "L'adresse email $email est considérée comme invalide";
				echo "<br>";
			}
		}

		
		goAddUser();			
	}

	elseif($action=="addClient")
	{
		$email = $_POST['email'];
		$tel = $_POST['tel'];

		if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $tel))
		{
			$meta_carac = array("-", ".", " ");
			$tel = str_replace($meta_carac, "", $tel);
			addClient($_POST['nom'], $tel, $email);
			echo "Le client a bien été ajouté !";
		}
		
		else
		{
			if (filter_var($email, FILTER_VALIDATE_EMAIL) == false)
			{
				echo "L'adresse email $email est considérée comme invalide";
				echo "<br>";
			}

			if(preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $tel) == false)
			{
				echo "Le numéro de téléphone $tel est considéré comme invalide";
			}
		}

		goAddClient();			
	}



	elseif($action=="goBindVps")
	{
		goBindVps($_GET['vpsName'], $_GET['idVps']);		
	}

	elseif($action=="goBindDomain")
	{
		goBindDomain($_GET['domainName'], $_GET['idDomain']);		
	}

	elseif($action=="goBindClient")
	{
		goBindClient($_GET['clientName'], $_GET['idClient']);		
	}


	elseif($action=="goVpsBound")
	{
		goVpsBound($_GET['vpsName'], $_GET['idVps']);		
	}

	elseif($action=="goDomainBound")
	{
		goDomainBound($_GET['domainName'], $_GET['idDomain']);		
	}

	elseif($action=="goClientBound")
	{
		goClientBound($_GET['clientName'], $_GET['idClient']);		
	}



	elseif($action=="bindVps")
	{
		if(isset($_POST['idDomain']))
		{	
			foreach($_POST['idDomain'] as $idDomain)
			{
				bindVpsToDomain($_GET['idVps'], $idDomain);
			}

			$bdd = new BDD();
			$domainIdBindToVps_result = $bdd->getDomainIdBindToVps($_GET['idVps']);
			$domainIdBindToVps = array_map('current', $domainIdBindToVps_result);
				
			$result = array_diff($domainIdBindToVps, $_POST['idDomain']);

			if($result)
			{
				foreach($result as $test)
				{
					unbindDomainToVps($test);
				}	
			}	
		}
		else
		{
			unbindVpsToDomain($_GET['idVps']);
		}

		if(isset($_POST['idClient']))
		{
			foreach($_POST['idClient'] as $idClient)
			{
				bindVpsToClient($_GET['idVps'], $idClient);	
			}

			$bdd = new BDD();
			$clientIdBindToVps_result = $bdd->getClientIdBindToVps($_GET['idVps']);
			$clientIdBindToVps = array_map('current', $clientIdBindToVps_result);
				
			$result = array_diff($clientIdBindToVps, $_POST['idClient']);

			if($result)
			{
				foreach($result as $test)
				{
					unbindClientToVps($test);
				}	
			}
		}
		else
		{
			unbindVpsToClient($_GET['idVps']);
		}	

		goVpsBound($_GET['vpsName'], $_GET['idVps']);
	}			
	


	elseif($action=="bindDomain")
	{
		if(isset($_POST['idVps']))
		{
			foreach($_POST['idVps'] as $idVps)
			{
   				bindDomainToVps($_GET['idDomain'], $idVps);
			}

			$bdd = new BDD();
			$vpsIdBindToDomain_result = $bdd->getVpsIdBindToDomain($_GET['idDomain']);
			$vpsIdBindToDomain = array_map('current', $vpsIdBindToDomain_result);
				
			$result = array_diff($vpsIdBindToDomain, $_POST['idVps']);

			if($result)
			{
				foreach($result as $test)
				{
					unbindVpsToDomain($test);
				}	
			}
		}
		else
		{
			unbindDomainToVps($_GET['idDomain']);
		}

		if(isset($_POST['idClient']))
		{
			foreach($_POST['idClient'] as $idClient)
			{
   				bindDomainToClient($_GET['idDomain'], $idClient);
			}

			$bdd = new BDD();
			$clientIdBindToDomain_result = $bdd->getClientIdBindToDomain($_GET['idDomain']);
			$clientIdBindToDomain = array_map('current', $clientIdBindToDomain_result);
				
			$result = array_diff($clientIdBindToDomain, $_POST['idClient']);

			if($result)
			{
				foreach($result as $test)
				{
					unbindClientToDomain($test);
				}	
			}
		}
		else
		{
			unbindDomainToClient($_GET['idDomain']);
		}

		goDomainBound($_GET['domainName'], $_GET['idDomain']);
	}



	elseif($action=="bindClient")
	{
		if(isset($_POST['idVps']))
		{
			foreach($_POST['idVps'] as $idVps)
			{
   				bindClientToVps($_GET['idClient'], $idVps);
			}

			$bdd = new BDD();
			$vpsIdBindToClient_result = $bdd->getVpsIdBindToClient($_GET['idClient']);
			$vpsIdBindToClient = array_map('current', $vpsIdBindToClient_result);
				
			$result = array_diff($vpsIdBindToClient, $_POST['idVps']);

			if($result)
			{
				foreach($result as $test)
				{
					unbindVpsToClient($test);
				}	
			}
		}
		else
		{
			unbindClientToVps($_GET['idClient']);
		}
		
		if(isset($_POST['idDomain']))
		{
			foreach($_POST['idDomain'] as $idDomain)
			{
   				bindClientToDomain($_GET['idClient'], $idDomain);
			}

			$bdd = new BDD();
			$domainIdBindToClient_result = $bdd->getDomainIdBindToClient($_GET['idClient']);
			$domainIdBindToClient = array_map('current', $domainIdBindToClient_result);
				
			$result = array_diff($domainIdBindToClient, $_POST['idDomain']);

			if($result)
			{
				foreach($result as $test)
				{
					unbindDomainToClient($test);
				}	
			}
		}
		else
		{
			unbindClientToDomain($_GET['idClient']);
		}

		goClientBound($_GET['clientName'], $_GET['idClient']);
	}

	elseif($action=="deleteClient")
	{
		deleteClient($_GET['idClient']);
		unbindClientToVps($_GET['idClient']);
		unbindClientToDomain($_GET['idClient']);
		echo "Le client a bien été supprimé !";
		consul();					
	}

	elseif($action=="deleteUser")
	{
		deleteUser($_GET['idUser']);
		echo "L'utilisateur a bien été supprimé !";
		consul();					
	}

	elseif($action=="modifClient")
	{
		modifClient($_GET['idClient']);
		echo "Le client a bien été modifié !";
		goModifClient();					
	}

	elseif($action=="modifUser")
	{
		modifUser($_GET['idUser']);
		echo "L'utilisateur a bien été modifié !";
		goModifUser();					
	}
}		


catch (Exception $e)
{
    erreur($e->getMessage());
}

?>