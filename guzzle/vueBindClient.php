<?php

require_once 'modele.php';
$bdd = new BDD();

$vps_result = $bdd->getVpsListBdd();
$domain_result = $bdd->getDomainListBdd();
$client_result = $bdd->getClientListBdd();

$vpsNameBindToClient_result = $bdd->getVpsNameBindToClient($idClient);
$domainNameBindToClient_result = $bdd->getDomainNameBindToClient($idClient);

$vpsNameBindToClient = array_map('current', $vpsNameBindToClient_result);
$domainNameBindToClient = array_map('current', $domainNameBindToClient_result);

if (isset($_SESSION["ID"]))
{ 

?>

  <!DOCTYPE html>
  <html>
  	<head>
  	<title>Lier un client API OVH</title>
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
    <form id="contact" action="<?= "index.php?action=bindClient&clientName=".$clientName."&idClient=".$idClient; ?>" method="post">

      <h3>Lier le client <?php echo $clientName; ?></h3>
      <fieldset>
      <p>
          <h4>Cochez les vps à lier : </h4>
          <?php 

          foreach ($vps_result as $vps)
          {
            ?>
            <input type="checkbox" name="idVps[]" value="<?php echo $vps['id']; ?>" <?php if(in_array($vps['display_name'], $vpsNameBindToClient)) echo'checked = checked' ;?> id="idVps" /> <label for="idVps"><?php echo $vps['display_name'];  ?> </label><br>
            <?php
          }

          ?>
      </p>
      </fieldset>

      <fieldset>
      <p>
          <h4>Cochez les domaines à lier : </h4>
          <?php 

          foreach ($domain_result as $domain)
          {
            ?>
            <input type="checkbox" name="idDomain[]" value="<?php echo $domain['id']; ?>" <?php if(in_array($domain['name'], $domainNameBindToClient)) echo'checked = checked' ;?> id="idDomain" /> <label for="idDomain"><?php echo $domain['name'];  ?> </label><br>
            <?php
          }

          ?>
      </p>  
      </fieldset>

      <fieldset>
        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Enregistrer</button>
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

