<?php

require_once 'modele.php';
$bdd = new BDD();

$vps_result = $bdd->getVpsListBdd();
$domain_result = $bdd->getDomainListBdd();
$client_result = $bdd->getClientListBdd();

$vpsBindToClient_result = $bdd->getVpsBindToClient($idClient);
$domainBindToClient_result = $bdd->getDomainBindToClient($idClient);


if (isset($_SESSION["ID"]))
{ 

?>

  <!DOCTYPE html>
  <html>
  	<head>
  	<title>Clients API OVH liés</title>
  	<!-- <script  language="javascript" type="text/javascript" src="ressources/javascript/main.js"></script> -->
  	<link rel="stylesheet" type="text/css" href="style_ClientBound.css">
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

      <h3>Client <?php echo $clientName; ?></h3>
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

    foreach ($vpsBindToClient_result as $vpsBindToClient)
    {
      echo "<tr>";

        echo "<td>";
        echo $vpsBindToClient['id'];
        echo"</td>";
        
        echo "<td>";
        echo $vpsBindToClient['name'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToClient['display_name'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToClient['zone'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToClient['state'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToClient['cluster'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToClient['offer'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToClient['contact_billing'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToClient['billing_status'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToClient['renew_period'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToClient['renew_automatic'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToClient['expiration'];
        echo"</td>";

        echo "<td>";
        echo $vpsBindToClient['ovh'];
        echo"</td>";

      echo "</tr>";
    }

  echo "</table>";

      ?>    
      </p>
      </fieldset>

      <fieldset>
       <p>
        <h4>Domaines liés : </h4>
        <?php
        echo "<table>";
    echo "<tr>";
      echo "<th>id</th>";
      echo "<th>name</th>";
      echo "<th>contact_billing</th>";
      echo "<th>billing_status</th>";
      echo "<th>renew_period</th>";
      echo "<th>renew_automatic</th>";
      echo "<th>expiration</th>";
      echo "<th>ovh</th>";
    echo "</tr>";


  foreach ($domainBindToClient_result as $domainBindToClient)
  {
    echo "<tr>";

      echo "<td>";
        echo $domainBindToClient['id'];
        echo"</td>";
        
        echo "<td>";
        echo $domainBindToClient['name'];
        echo"</td>";

        echo "<td>";
        echo $domainBindToClient['contact_billing'];
        echo"</td>";

        echo "<td>";
        echo $domainBindToClient['billing_status'];
        echo"</td>";

        echo "<td>";
        echo $domainBindToClient['renew_period'];
        echo"</td>";

        echo "<td>";
        echo $domainBindToClient['renew_automatic'];
        echo"</td>";

        echo "<td>";
        echo $domainBindToClient['expiration'];
        echo"</td>";

        echo "<td>";
        echo $domainBindToClient['ovh'];
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

