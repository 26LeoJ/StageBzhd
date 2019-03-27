<?php

require_once 'modele.php';
$bdd = new BDD();

$vps_result = $bdd->getVpsListBdd();
$domain_result = $bdd->getDomainListBdd();
$client_result = $bdd->getClientListBdd();

$domainNameBindToVps_result = $bdd->getDomainNameBindToVps($idVps);
$clientNameBindToVps_result = $bdd->getClientNameBindToVps($idVps);

$domainNameBindToVps = array_map('current', $domainNameBindToVps_result);
$clientNameBindToVps = array_map('current', $clientNameBindToVps_result);




if (isset($_SESSION["ID"]))
{ 

?>

  <!DOCTYPE html>
  <html>
  	<head>
  	<title>Lier un vps API OVH</title>
  	<!-- <script  language="javascript" type="text/javascript" src="ressources/javascript/main.js"></script> -->
  	<link rel="stylesheet" type="text/css" href="style_bindVpsClient.css">
  	<meta type="text/html" charset="utf-8">
  	</head>

  	<body>
  	<header>
  		<div class="menu">
  			<h1 class="menuObj"><a href="<?php echo "index.php?action=logout"; ?>">Déconnexion</a></h1>
        <h1 class="menuObj"><a href="<?php echo "index.php?action=consul"; ?>">Affichage des infos OVH</a></h1>
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

  	<div class="container">  
    <form id="contact" action="<?php echo "index.php?action=bindVps&vpsName=".$vpsName."&idVps=".$idVps; ?>" method="post">

      <h3>Lier le vps <?php echo $vpsName; ?></h3>
      <fieldset>
        <p>
          <h4>Cochez les domaines à lier : </h4>
          <?php 
          foreach ($domain_result as $domain)
          {
            ?>
            <input type="checkbox" name="idDomain[]" value="<?php echo $domain['id']; ?>" <?php if(in_array($domain['name'], $domainNameBindToVps)) echo'checked = checked' ;?> id="idDomain" /> <label for="idDomain"><?php echo $domain['name'];  ?> </label><br>
            <?php
          }

          ?>
      </p>
      </fieldset>

      <fieldset>
       <p>
        <h4>Cochez les clients à lier : </h4>
       <?php 

          foreach ($client_result as $client)
          {
            ?>
            <input type="checkbox" name="idClient[]" value="<?php echo $client['id']; ?>" <?php if(in_array($client['nom'], $clientNameBindToVps)) echo'checked = checked' ;?> id="idClient" /> <label for="idClient"><?php echo $client['nom'];  ?> </label><br>
            <?php
          }

          ?>
      </p>
      </fieldset>

      <fieldset>
        <button name="submit" type="submit" value="delete" id="contact-submit" data-submit="...Sending">Enregistrer</button>
      </fieldset>

    </form>
  </div>
  	
  </body>
  </html>

  <?php
}

else
{
  require_once 'vueErreurLogin.php';
}

