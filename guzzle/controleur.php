<?php

require_once 'modele.php';


// Action 1 : Affiche la page de login
function login()
{
	require_once 'vueLogin.php';
}

function erreurLogin()
{
	require_once 'vueErreurLogin.php';
}

function logged($username)
{	
	$bdd = new BDD();
	$_SESSION['logged']=true;
	$_SESSION['ID']=$bdd->getUserID($username);
	$_SESSION['LEVEL']=$bdd->getUserLevel($username);
	/* $_SESSION['prenom']=getUserName($nameuser); */
	require_once 'vueDisplayOVH.php';
}

function update()
{
	if (!isset($_SESSION["ID"]))
    {
        require_once 'vueErreurLogin.php';
    }

    elseif($_SESSION["LEVEL"] == 'Admin')
    {
    	require_once 'update.php';
    }

    else
    {
    	include 'forbidden.php';
    }
}


function goAddUser()
{
	if (!isset($_SESSION["ID"]))
    {
        require_once 'vueErreurLogin.php';
    }

    elseif($_SESSION["LEVEL"] == 'Admin')
    {
    	require_once 'vueAddUser.php';
    }

    else
    {
    	include 'forbidden.php';
    }
}

function goAddClient()
{
	if (!isset($_SESSION["ID"]))
    {
        require_once 'vueErreurLogin.php';
    }

    elseif($_SESSION["LEVEL"] == 'Manager' || $_SESSION["LEVEL"] == 'Admin')
    {
    	require_once 'vueAddClient.php';
    }

    else
    {
    	include 'forbidden.php';
    }

}

function goModifClient()
{
	if (!isset($_SESSION["ID"]))
    {
        require_once 'vueErreurLogin.php';
    }

    elseif($_SESSION["LEVEL"] == 'Manager' || $_SESSION["LEVEL"] == 'Admin' )
    {
    	require_once 'vueModifClient.php';
    }

    else
    {
    	include 'forbidden.php';
    }
}

function goModifUser()
{
	if (!isset($_SESSION["ID"]))
    {
        require_once 'vueErreurLogin.php';
    }

    elseif($_SESSION["LEVEL"] == 'Admin')
    {
    	require_once 'vueModifUser.php';
    }

    else
    {
    	include 'forbidden.php';
    }
}

function consul()
{
	if (!isset($_SESSION["ID"]))
    {
        require_once 'vueErreurLogin.php';
    }

    else
    {
    	require_once 'vueDisplayOVH.php';
    }
	
}

function addUser($nom, $prenom, $login, $mdp, $email, $level)
{
	$userToAdd = array('nom' => $nom,'prenom'=> $prenom,'login' => $login,'mdp' => $mdp, 'email' => $email, 'level' => $level);
	$bdd = new Bdd();
	$bdd->addNewUser($userToAdd);
}

function addClient($nom, $tel, $email)
{
	$clientToAdd = array('nom' => $nom,'tel'=> $tel,'email' => $email);
	$bdd = new Bdd();
	$bdd->addNewClient($clientToAdd);
}

function goBindVps($vpsName, $idVps)
{
	if (!isset($_SESSION["ID"]))
    {
        include 'vueErreurLogin.php';
    }

    elseif($_SESSION["LEVEL"] == 'Manager' || $_SESSION["LEVEL"] == 'Admin' )
    {
    	require_once 'vueBindVps.php';
    }

    else
    {
    	include 'forbidden.php';
    }
}

function goBindDomain($domainName, $idDomain)
{
	if (!isset($_SESSION["ID"]))
    {
        include 'vueErreurLogin.php';
    }

    elseif($_SESSION["LEVEL"] == 'Manager' || $_SESSION["LEVEL"] == 'Admin' )
    {
    	require_once 'vueBindDomain.php';
    }

    else
    {
    	include 'forbidden.php';
    }
}

function goBindClient($clientName, $idClient)
{
	if (!isset($_SESSION["ID"]))
    {
        include 'vueErreurLogin.php';
    }

    elseif($_SESSION["LEVEL"] == 'Manager' || $_SESSION["LEVEL"] == 'Admin' )
    {
    	require_once 'vueBindClient.php';
    }

    else
    {
    	include 'forbidden.php';
    }
}

function goVpsBound($vpsName, $idVps)
{
	if (!isset($_SESSION["ID"]))
    {
        include 'vueErreurLogin.php';
    }

    else
    {
    	include 'vueVpsBound.php';
    }
}

function goDomainBound($domainName, $idDomain)
{
	if (!isset($_SESSION["ID"]))
    {
        include 'vueErreurLogin.php';
    }

    else
    {
    	include 'vueDomainBound.php';
    }
}

function goClientBound($clientName, $idClient)
{
	if (!isset($_SESSION["ID"]))
    {
        include 'vueErreurLogin.php';
    }

    else
    {
    	include 'vueClientBound.php';
    }
}


function bindVpsToDomain($idVps, $idDomain)
{
	$bdd = new BDD();
	$domainIdBindToVps_result = $bdd->getDomainIdBindToVps($idVps);
	$domainIdBindToVps = array_map('current', $domainIdBindToVps_result);

	/*echo "<pre>";
	var_dump($_POST['idDomain']);
	echo "<pre>";

	echo "<pre>";
	var_dump($domainIdBindToVps);
	echo "<pre>";*/

	if(!in_array($idDomain, $domainIdBindToVps))
	{
		$vpsToBind = array('idVps' => $idVps,'idDomain'=> $idDomain);
		$bdd = new Bdd();
		$bdd->bindVpsToDomain($vpsToBind);
	}
}

function unbindVpsToDomain($idVps)
{
	$vpsToUnbind = $idVps;
	$bdd = new Bdd();
	$bdd->unbindVpsToDomain($vpsToUnbind);
}

function bindVpsToClient($idVps, $idClient)
{
	$bdd = new BDD();
	$clientIdBindToVps_result = $bdd->getClientIdBindToVps($idVps);
	$clientIdBindToVps = array_map('current', $clientIdBindToVps_result);

	if(!in_array($idClient, $clientIdBindToVps))
	{
		$vpsToBind = array('idVps' => $idVps, 'idClient' => $idClient);
		$bdd = new Bdd();
		$bdd->bindVpsToClient($vpsToBind);
	}
}

function unbindVpsToClient($idVps)
{
	$vpsToUnbind = $idVps;
	$bdd = new Bdd();
	$bdd->unbindVpsToClient($vpsToUnbind);
}



function bindDomainToVps($idDomain, $idVps)
{
	$bdd = new BDD();
	$vpsIdBindToDomain_result = $bdd->getVpsIdBindToDomain($idDomain);
	$vpsIdBindToDomain = array_map('current', $vpsIdBindToDomain_result);

	if(!in_array($idVps, $vpsIdBindToDomain))
	{
		$domainToBind = array('idDomain' => $idDomain,'idVps'=> $idVps);
		$bdd = new Bdd();
		$bdd->bindDomainToVps($domainToBind);
	}
}

function unbindDomainToVps($idDomain)
{
	$domainToUnbind = $idDomain;
	$bdd = new Bdd();
	$bdd->unbindDomainToVps($domainToUnbind);
}


function bindDomainToClient($idDomain, $idClient)
{
	$bdd = new BDD();
	$clientIdBindToDomain_result = $bdd->getClientIdBindToDomain($idDomain);
	$clientIdBindToDomain = array_map('current', $clientIdBindToDomain_result);

	/*echo "<pre>";
	var_dump($idClient);
	echo "<pre>";

	echo "<pre>";
	var_dump($clientIdBindToDomain);
	echo "<pre>";*/

	if(!in_array($idClient, $clientIdBindToDomain))
	{
		$domainToBind = array('idDomain' => $idDomain, 'idClient' => $idClient);
		$bdd = new Bdd();
		$bdd->bindDomainToClient($domainToBind);
	}	
}

function unbindDomainToClient($idDomain)
{
	$domainToUnbind = $idDomain;
	$bdd = new Bdd();
	$bdd->unbindDomainToClient($domainToUnbind);
}



function bindClientToVps($idClient, $idVps)
{
	$bdd = new BDD();
	$vpsIdBindToClient_result = $bdd->getVpsIdBindToClient($idClient);
	$vpsIdBindToClient = array_map('current', $vpsIdBindToClient_result);

	if(!in_array($idVps, $vpsIdBindToClient))
	{
		$clientToBind = array('idClient' => $idClient,'idVps'=> $idVps);
		$bdd = new Bdd();
		$bdd->bindClientToVps($clientToBind);
	}	
}

function unbindClientToVps($idClient)
{
	$clientToUnbind = $idClient;
	$bdd = new Bdd();
	$bdd->unbindClientToVps($clientToUnbind);
}


function bindClientToDomain($idClient, $idDomain)
{
	$bdd = new BDD();
	$domainIdBindToClient_result = $bdd->getDomainIdBindToClient($idClient);
	$domainIdBindToClient = array_map('current', $domainIdBindToClient_result);

	if(!in_array($idDomain, $domainIdBindToClient))
	{
		$clientToBind = array('idClient' => $idClient, 'idDomain' => $idDomain);
		$bdd = new Bdd();
		$bdd->bindClientToDomain($clientToBind);
	}
	
}

function unbindClientToDomain($idClient)
{
	$clientToUnbind = $idClient;
	$bdd = new Bdd();
	$bdd->unbindClientToDomain($clientToUnbind);
}


function deleteClient($idClient)
{
	$clientToDelete = $idClient;
	$bdd = new Bdd();
	$bdd->deleteClient($clientToDelete);
}

function deleteUser($idUser)
{
	$userToDelete = $idUser;
	$bdd = new Bdd();
	$bdd->deleteUser($userToDelete);
}



function logout()
{
	$_SESSION['logged']=false;
	session_unset();
	session_destroy();
	require_once 'vueLogin.php';
}

function testLoginMatch($username,$password)
{
	$bdd = new BDD();
	$pass=$bdd->getPass($username);

	if($pass==$password)
	{
		return(true);
	}

	else
	{
		return(false);
	}
}




?>