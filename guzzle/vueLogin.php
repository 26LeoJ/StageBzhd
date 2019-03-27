<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style_form.css" />  <!-- mise en place du css -->
		<title>Connexion - Administration serveurs OVH </title>
	</head>
	
	<body>
		<header>
			<!-- <a id="logo"><img src="ressources/images/logo.jpg" alt="logo"/></a> -->
				<!-- <h1 class="menuObj"><a href="accueil.php">Accueil</a></h1> -->
				<br>
				<p id="titre">Connectez-vous à l'interface d'administration API OVH</p>
		</header>
		
	<div class="container">  
    <form id="contact" action="<?= "index.php?action=logged"?>" method="post">
      <h3>Connexion</h3>
      <fieldset>
        <input placeholder="Login" name="login"  type="text" tabindex="1" required autofocus>
      </fieldset>
      <fieldset>
        <input placeholder="Mot de passe" name="password" type="password" tabindex="2" required>
      </fieldset>
      <fieldset>
        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Ajouter</button>
      </fieldset>
    </form>
  </div>

		<footer>
		</footer>
	</body>
</html>


