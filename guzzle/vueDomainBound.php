<?php

require_once 'modele.php';
$bdd = new BDD();

$vps_result = $bdd->getVpsListBdd();
$domain_result = $bdd->getDomainListBdd();
$client_result = $bdd->getClientListBdd();

$vpsBindToDomain_result = $bdd->getVpsBindToDomain($idDomain);
$clientBindToDomain_result = $bdd->getClientBindToDomain($idDomain);



if (isset($_SESSION["ID"]))
{ 

?>

  <!DOCTYPE html>
  <html>
  	<head>
  	<title>Domaines API OVH liés</title>
  	<!-- <script  language="javascript" type="text/javascript" src="ressources/javascript/main.js"></script> -->
  	<link rel="stylesheet" type="text/css" href="style_DomainBound.css">
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

      <h3>Domaine <?php echo $domainName; ?></h3>
      <fieldset>
        <p>
          <h4>Vps liés : </h4>
          <?php
          echo "<table>";
    echo "<tr>";
      echo "<th>id</th>";
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
      
    echo "</tr>";

    foreach ($vpsBindToDomain_result as $vpsBindToDomain)
    {
      echo "<tr>";

        echo "<td>";
        echo $vpsBindToDomain['id'];
        echo"</td>";
        
        echo "<td>";
        echo $vpsBindToDomain['name'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToDomain['display_name'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToDomain['zone'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToDomain['state'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToDomain['cluster'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToDomain['offer'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToDomain['contact_billing'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToDomain['billing_status'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToDomain['renew_period'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToDomain['renew_automatic'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToDomain['expiration'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToDomain['ovh'];
        echo"</td>";

      echo "</tr>";
    }

  echo "</table>";

      ?>    
      </p>
      </fieldset>

      <fieldset>
       <p>
        <h4>Clients liés : </h4>
        <?php
        echo "<table>";
    echo "<tr>";
      echo "<th>id</th>";
      echo "<th>name</th>";
      echo "<th>tel</th>";
      echo "<th>email</th>";
    echo "</tr>";


  foreach ($clientBindToDomain_result as $clientBindToDomain)
  {
    echo "<tr>";

      echo "<td>";
      echo $clientBindToDomain['id'];
      echo"</td>";
      
      echo "<td>";
      echo $clientBindToDomain['nom'];
      echo"</td>";

      echo "<td>";
      echo $clientBindToDomain['tel'];
      echo"</td>";

      echo "<td>";
      echo $clientBindToDomain['email'];
      echo"</td>";
    echo "</tr>";
  }

  echo "</table>";
  ?>

       
      </p>
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

