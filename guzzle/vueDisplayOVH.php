<?php

if (isset($_SESSION["ID"]))
{ 
	//echo $_SESSION['LEVEL'];

 ?>

	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8" />
			<link rel="stylesheet" href="style_tab.css" />  <!-- mise en place du css -->
		</head>

		<body>
			<header>
				<div class="menu">
					
					<h1 class="menuObj"><a href="<?php echo "index.php?action=logout"; ?>">Déconnexion</a></h1>
					<?php
					if($_SESSION["LEVEL"] == 'Admin')
					{
					?>
						<h1 class="menuObj"><a href="<?php echo "index.php?action=goAddClient"; ?>">Ajouter un client</a></h1>
						<h1 class="menuObj"><a href="<?php echo "index.php?action=goAddUser"; ?>">Ajouter un utilisateur</a></h1>
						<h1 class="menuObj"><a href="<?php echo "index.php?action=update"; ?>">Mettre à jour les données des vps et domaines OVH</a></h1>
					<?php
					}

					elseif($_SESSION["LEVEL"] == 'Manager')
					{
					?>
						<h1 class="menuObj"><a href="<?php echo "index.php?action=goAddClient"; ?>">Ajouter un client</a></h1>
						<h1 class="menuObj"><a href="<?php echo "index.php?action=update"; ?>">Mettre à jour les données des vps et domaines OVH</a></h1>
					<?php
					}
					?>

				</div>
			</header>
		<br>

	<?php

	// Afficher les erreurs à l'écran
	ini_set('display_errors', 1);
	// Enregistrer les erreurs dans un fichier de log
	ini_set('log_errors', 1);
	// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
	ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

	require_once 'modele.php';

	/*require_once 'ApiOvh.php';

	$api = new ApiOvh();

	$api->getVpsListApi();*/

	// 1er tableau de 21 lignes et 13 colonnes (11 infos à afficher sur les vps)

	echo '<title>Affichage des vps/domaines OVH</title>';

	echo '<h1><i>Affichage des vps OVH</i></h1>';

	// Nouvelle méthode d'affichage des données vps (à partir de la BDD AdminOVH)

	$bdd = new BDD();

	// Affichage du nombre de lignes des tables vps et domain
	/*$vps_count = $bdd->countVpsBdd();
	echo'<br>';
	echo'<br>';
	$domain_count = $bdd->countDomainBdd();*/

	$vps_result = $bdd->getVpsListBdd();

	echo '<p style="text-align: center;">Il y a '.count($vps_result).' vps actifs !</p>';

	/*echo "<pre>";
	var_dump($vps_result);
	echo "</pre>";*/

	echo "<table>";
		echo "<tr>";
			echo "<th>name</th>";
			echo "<th>display_name</th>";
			echo "<th>zone</th>";
			echo "<th>state</th>";
			echo "<th>cluster</th>";
			echo "<th>offer</th>";
			echo "<th>contact_billing</th>";
			echo "<th>billing_status</th>";
			echo "<th>renew_period</th>";
			echo "<th>renew_automatic</th>";
			echo "<th>expiration</th>";
			echo "<th>ovh</th>";
			
			if($_SESSION["LEVEL"] == 'Manager' || $_SESSION["LEVEL"] == 'Admin')
			{
				echo "<th>Bind vps</th>";
			}
		echo "</tr>";


	foreach ($vps_result as $vps)
	{

		echo "<tr>";

			echo "<td>";
			?>
			<span class="bind"> <a href="<?php echo "index.php?action=goVpsBound&vpsName=".$vps['display_name']."&idVps=".$vps['id']; ?>"> <?php echo $vps['name']; ?> </a> </span>
			<?php
			echo"</td>";

			echo "<td>";
			echo $vps['display_name'];
			echo"</td>";

			echo "<td>";
			echo $vps['zone'];
			echo"</td>";

			echo "<td>";
			echo $vps['state'];
			echo"</td>";

			echo "<td>";
			echo $vps['cluster'];
			echo"</td>";

			echo "<td>";
			echo $vps['offer'];
			echo"</td>";

			echo "<td>";
			echo $vps['contact_billing'];
			echo"</td>";

			echo "<td>";
			echo $vps['billing_status'];
			echo"</td>";

			echo "<td>";
			echo $vps['renew_period'];
			echo"</td>";

			echo "<td>";
			echo $vps['renew_automatic'];
			echo"</td>";

			echo "<td>";
			echo $vps['expiration'];
			echo"</td>";

			echo "<td>";
			echo $vps['ovh'];
			echo"</td>";

			if($_SESSION["LEVEL"] == 'Manager' || $_SESSION["LEVEL"] == 'Admin')
			{
				echo "<td>";
				?>
				<span class="bind"> <a href="<?php echo "index.php?action=goBindVps&vpsName=".$vps['display_name']."&idVps=".$vps['id']; ?>"> => </a> </span> 
				<?php
				echo"</td>";
			}

		echo "</tr>";

		}

		

	echo "</table>";


	echo "<br>";



	// 2ème tableau de 170 lignes et 8 colonnes (infos à afficher sur les domaines)

	echo '<h1><i>Affichage des domaines OVH</i></h1>';

	// Nouvelle méthode d'affichage des données domain (à partir de la BDD AdminOVH)

	$domain_result = $bdd->getDomainListBdd();

	echo '<p style="text-align: center;">Il y a '.count($domain_result).' domaines actifs !</p>';


	echo "<table>";
		echo "<tr>";
			echo "<th>name</th>";
			echo "<th>contact_billing</th>";
			echo "<th>billing_status</th>";
			echo "<th>renew_period</th>";
			echo "<th>renew_automatic</th>";
			echo "<th>expiration</th>";
			echo "<th>ovh</th>";
			if($_SESSION["LEVEL"] == 'Manager' || $_SESSION["LEVEL"] == 'Admin')
			{
				echo "<th>Bind domain</th>";
			}

		echo "</tr>";


	foreach ($domain_result as $domain)
	{
		echo "<tr>";
			
			echo "<td>";
			?>
			<span class="bind"> <a href="<?php echo "index.php?action=goDomainBound&domainName=".$domain['name']."&idDomain=".$domain['id']; ?>"> <?php echo $domain['name']; ?> </a> </span>
			<?php
			echo"</td>";

			echo "<td>";
			echo $domain['contact_billing'];
			echo"</td>";

			echo "<td>";
			echo $domain['billing_status'];
			echo"</td>";

			echo "<td>";
			echo $domain['renew_period'];
			echo"</td>";

			echo "<td>";
			echo $domain['renew_automatic'];
			echo"</td>";

			echo "<td>";
			echo $domain['expiration'];
			echo"</td>";

			echo "<td>";
			echo $domain['ovh'];
			echo"</td>";

			if($_SESSION["LEVEL"] == 'Manager' || $_SESSION["LEVEL"] == 'Admin')
			{
				echo "<td>";
				?>
				<span class="bind"> <a href="<?php echo "index.php?action=goBindDomain&domainName=".$domain['name']."&idDomain=".$domain['id']; ?>"> => </a> </span>  
				<?php
				echo"</td>";
			}
		echo "</tr>";
	}

	echo "</table>";


	echo "<br>";

	// 3ème tableau de ? lignes et ? colonnes (infos à afficher sur les clients)

	echo '<h1><i>Affichage des clients OVH</i></h1>';

	// Nouvelle méthode d'affichage des données domain (à partir de la BDD AdminOVH)

	$client_result = $bdd->getClientListBdd();

	echo '<p style="text-align: center;">Il y a actuellement '.count($client_result).' clients !</p>';


	echo "<table>";
		echo "<tr>";
			echo "<th>name</th>";
			echo "<th>tel</th>";
			echo "<th>email</th>";

			if($_SESSION["LEVEL"] == 'Manager' || $_SESSION["LEVEL"] == 'Admin')
			{
				echo "<th>Edit client</th>";
				echo "<th>Bind client</th>";
				echo "<th>Delete client</th>";
			}
		echo "</tr>";


	foreach ($client_result as $client)
	{
		echo "<tr>";
			
			echo "<td>";
			?>
			<span class="bind"> <a href="<?php echo "index.php?action=goClientBound&clientName=".$client['nom']."&idClient=".$client['id']; ?>"> <?php echo $client['nom']; ?> </a> </span>
			<?php
			echo"</td>";

			echo "<td>";
			echo $client['tel'];
			echo"</td>";

			echo "<td>";
			echo $client['email'];
			echo"</td>";

			if($_SESSION["LEVEL"] == 'Manager' || $_SESSION["LEVEL"] == 'Admin')
			{
				echo "<td>";
				?>
				<span class="bind"> <a href="<?php echo "index.php?action=goModifClient&clientName=".$client['nom']."&idClient=".$client['id']; ?>"> ➤ </a> </span> 
				<?php
				echo"</td>";

				echo "<td>";
				?>
				<span class="bind"> <a href="<?php echo "index.php?action=goBindClient&clientName=".$client['nom']."&idClient=".$client['id']; ?>"> => </a> </span> 
				<?php
				echo"</td>";

				echo "<td>";
				?>
				<span class="bind"> <a href="<?php echo "index.php?action=deleteClient&clientName=".$client['nom']."&idClient=".$client['id']; ?>"> X </a> </span>
				<?php
				echo"</td>";
			}
		echo "</tr>";
	}

	echo "</table>";


	echo "<br>";

	// 4ème tableau de ? lignes et ? colonnes (infos à afficher sur les users)

	echo '<h1><i>Affichage des utilisateurs OVH</i></h1>';

	// Nouvelle méthode d'affichage des données domain (à partir de la BDD AdminOVH)

	$user_result = $bdd->getUserListBdd();

	echo '<p style="text-align: center;">Il y a actuellement '.count($user_result).' utilisateurs !</p>';


	echo "<table>";
		echo "<tr>";
			echo "<th>surname</th>";
			echo "<th>forename</th>";
			echo "<th>email</th>";
			echo "<th>level</th>";

			if($_SESSION["LEVEL"] == 'Admin')
			{
				echo "<th>Edit user</th>";
				echo "<th>Delete user</th>";
			}
		echo "</tr>";


	foreach ($user_result as $user)
	{
		echo "<tr>";
			
			echo "<td>";
			echo $user['nom'];
			echo"</td>";

			echo "<td>";
			echo $user['prenom'];
			echo"</td>";

			echo "<td>";
			echo $user['email'];
			echo"</td>";

			echo "<td>";
			echo $user['level'];
			echo"</td>";

			if($_SESSION["LEVEL"] == 'Admin')
			{
				echo "<td>";
				?>
				<span class="bind"> <a href="<?php echo "index.php?action=goModifUser&UserName=".$user['prenom']."&idUser=".$user['id']; ?>"> ➤ </a> </span> 
				<?php
				echo"</td>";

				echo "<td>";
				?>
				<span class="bind"> <a href="<?php echo "index.php?action=deleteUser&userName=".$user['prenom']."&idUser=".$user['id']; ?>"> X </a> </span> 
				<?php
				echo"</td>";
			}

		echo "</tr>";
	}

	echo "</table>";

	echo "<br>";
}

else
{
	require_once 'vueErreurLogin.php';
}

?>