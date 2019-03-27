<?php

if (isset($_SESSION["ID"]))
{ 

?>

  <!DOCTYPE html>
  <html>
  	<head>
  	<title>Modification d'un utilisateur API OVH</title>
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
            <h1 class="menuObj"><a href="<?php echo "index.php?action=goAddClient"; ?>">Ajouter un client</a></h1>
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
    <form id="contact" action="<?= "index.php?action=modifUser"?>" method="post">
      
      <h3>Modifier un utilisateur</h3>
      <fieldset>
        <input placeholder="Votre prénom" name="prenom"  type="text" tabindex="1" required autofocus>
      </fieldset>
      <fieldset>
        <input placeholder="Votre nom" name="nom" type="text" tabindex="2" required>
      </fieldset>
      <fieldset>
        <input placeholder="Votre login" name="login" type="text" tabindex="3" required>
      </fieldset>
      <fieldset>
        <input placeholder="Votre mot de passe" name="mdp" type="password" tabindex="3" required>
      </fieldset>
      <fieldset>
        <input placeholder="Votre Adresse Email" name="email" type="text" tabindex="4" required>
      </fieldset>
      <fieldset>
      <div class="custom-select">
        <select name="level" id="level">
        <option style="display:none" value="0">Votre rôle</option>
        <option value="Admin">Admin</option>
        <option value="Manager">Manager</option>
        <option value="User">User</option>
        </select>
      </div>
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

