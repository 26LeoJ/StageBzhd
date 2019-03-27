<?php

require_once 'modele.php';
$bdd = new BDD();

$vps_result = $bdd->getVpsListBdd();
$domain_result = $bdd->getDomainListBdd();
$client_result = $bdd->getClientListBdd();

$domainBindToVps_result = $bdd->getDomainBindToVps($idVps);
$clientBindToVps_result = $bdd->getClientBindToVps($idVps);

/*echo "<pre>";
var_dump($domainBindToVps_result);
echo "<pre>";*/

if (isset($_SESSION["ID"]))
{ 

?>

  <!DOCTYPE html>
  <html>
  	<head>
  	<title>Vps API OVH liés</title>
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

      <h3>VPS <?php echo $vpsName; ?></h3>
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

    foreach ($domainBindToVps_result as $domainBindToVps)
    {
      echo "<tr>";

        echo "<td>";
        echo $domainBindToVps['id'];
        echo"</td>";
        
        echo "<td>";
        echo $domainBindToVps['name'];
        echo"</td>";

        echo "<td>";
        echo $domainBindToVps['contact_billing'];
        echo"</td>";

        echo "<td>";
        echo $domainBindToVps['billing_status'];
        echo"</td>";

        echo "<td>";
        echo $domainBindToVps['renew_period'];
        echo"</td>";

        echo "<td>";
        echo $domainBindToVps['renew_automatic'];
        echo"</td>";

        echo "<td>";
        echo $domainBindToVps['expiration'];
        echo"</td>";

        echo "<td>";
        echo $domainBindToVps['ovh'];
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


  foreach ($clientBindToVps_result as $clientBindToVps)
  {
    echo "<tr>";

      echo "<td>";
      echo $clientBindToVps['id'];
      echo"</td>";
      
      echo "<td>";
      echo $clientBindToVps['nom'];
      echo"</td>";

      echo "<td>";
      echo $clientBindToVps['tel'];
      echo"</td>";

      echo "<td>";
      echo $clientBindToVps['email'];
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

