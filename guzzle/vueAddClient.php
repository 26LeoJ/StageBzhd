<?php

if (isset($_SESSION["ID"]))
{ 

?>

  <!DOCTYPE html>
  <html>
  	<head>
  	<title>Ajout d'un client API OVH</title>
  	<!-- <script  language="javascript" type="text/javascript" src="ressources/javascript/main.js"></script> -->
  	<link rel="stylesheet" type="text/css" href="style_form.css">
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
            <h1 class="menuObj"><a href="<?php echo "index.php?action=goAddUser"; ?>">Ajouter un utilisateur</a></h1>
            <h1 class="menuObj"><a href="<?php echo "index.php?action=update"; ?>">Mettre à jour les données des vps et domaines OVH</a></h1>
          <?php
          }

          elseif($_SESSION["LEVEL"] == 'Manager')
          {
          ?>
            <h1 class="menuObj"><a href="<?php echo "index.php?action=update"; ?>">Mettre à jour les données des vps et domaines OVH</a></h1>
          <?php
          }
          ?>
  		</div>
  	</header>

    <br>

  	<div class="container">  
    <form id="contact" action="<?= "index.php?action=addClient"?>" method="post">

      <h3>Ajouter un client</h3>
      <fieldset>
        <input placeholder="Nom du client" name="nom"  type="text" tabindex="1" required autofocus>
      </fieldset>
      <fieldset>
        <input placeholder="Téléphone" name="tel" type="tel" tabindex="2" required>
      </fieldset>
      <fieldset>
        <input placeholder="Adresse Email" name="email" type="text" tabindex="3" required>
      </fieldset>
      <fieldset>
        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Ajouter</button>
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

