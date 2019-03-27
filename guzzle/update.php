<?php

if (isset($_SESSION["ID"]))
{ 

    // Afficher les erreurs à l'écran
    ini_set('display_errors', 1);
    // Enregistrer les erreurs dans un fichier de log
    ini_set('log_errors', 1);
    // Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
    ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

    require_once 'ApiOvh.php';

    require_once 'modele.php';

    echo '<title>Update des vps/domaines OVH</title>';

    echo '<h1><i>Update des vps/domaines OVH</i></h1>';


    $api = new ApiOvh(); //classe ApiOVH de ApiOvh.php
    $vps_api = $api->getVpsListApi();
    $domain_api = $api->getDomainListApi();


    $bdd = new BDD(); // classe BDD de modele.php
    $vps_bdd = $bdd->getVpsListBdd();
    $domain_bdd = $bdd->getDomainListBdd();


    function arrayEquals($array_api, $array_bdd)
    {         
        $oui = true;

        foreach ($array_api as $key => $value_api) {
            if(!isset($array_bdd[$key]) || $array_bdd[$key] != $value_api){
                $oui = false;
            }
        }
              
        return $oui;
    }

    // Nouvelles fonctions d'insert et d'update

    /*echo"<strong>Vps présents sur l'API</strong>";
    echo "<pre>";
    var_dump($vps_api);
    echo "</pre>";

    echo "<br>";
    echo "<br>";

    echo'<strong>Vps présents en BDD</strong>';
    echo "<pre>";
    var_dump($vps_bdd);
    echo "</pre>";

    echo "<br>";
    echo "<br>";*/

    echo'<strong>Domain présents sur l"API</strong>';
    echo "<pre>";
    var_dump($domain_api);
    echo "</pre>";

    echo "<br>";
    echo "<br>";

    echo'<strong>Domain présents en BDD</strong>';
    echo "<pre>";
    var_dump($domain_bdd);
    echo "</pre>";

    echo "<br>";


    echo "<br>";
    echo "------------------------------------------------------";

    echo "<br>";

    echo'<strong>Différence entre les 2 tableaux vps [vps_api] et [vps_bdd] (insert) !!!</strong>';
    echo "<br>";
    echo "<br>";

    $vps_insert = $bdd->arrayDiffVpsInsert($vps_api, $vps_bdd);

    /*echo "<pre>";
    var_dump($vps_insert);
    echo "<pre>";*/

    foreach ($vps_insert as $vps_name => $isInsert)
    {
        if ($isInsert)
        {
            echo "Requête d'insertion effectuée pour " . $vps_name ;
            echo "<br>";
            echo "<br>";
        }

        else
        {
            echo $vps_name." est déjà présent dans la BDD";
            echo "<br>";
            echo "Requête d'insertion non effectuée.";
            echo "<br>";
            echo "<br>";
        }
    }

    echo "<br>";
    echo "------------------------------------------------------";

    echo "<br>";

    echo'<strong>Différence entre les 2 tableaux domain [domain_api] et [domain_bdd] (insert) !!!</strong>';
    echo "<br>";
    echo "<br>";

    $domain_insert = $bdd->arrayDiffDomainInsert($domain_api, $domain_bdd);

    foreach ($domain_insert as $domain_name => $isInsert)
    {
        if ($isInsert)
        {
            echo "Requête d'insertion effectuée pour " . $domain_name ;
            echo "<br>";
            echo "<br>";
        }
        
        else
        {
            echo $domain_name." est déjà présent dans la BDD";
            echo "<br>";
            echo "Requête d'insertion non effectuée.";
            echo "<br>";
            echo "<br>";
        }
    }



    echo "<br>";
    echo "------------------------------------------------------";

    echo "<br>";
     
    echo'<strong>Différence entre les 2 tableaux vps [vps_api] et [vps_bdd] (update) !!!</strong>';
    echo "<br>";
    echo "<br>";
     
    $vps_update = $bdd->arrayDiffVpsUpdate($vps_api, $vps_bdd);

    foreach ($vps_update as $vps_name => $isUpdate)
    {
        if ($isUpdate)
        {
            echo "Requête d'update effectuée pour " . $vps_name ;
            echo "<br>";
            echo "<br>";
            
        }
        else
        {
            echo "Les infos de " . $vps_name . " sont déjà présentes dans la BDD";
            echo "<br>";
            echo "Requête d'update non effectuée.";
            echo "<br>";
            echo "<br>";
        }
    }

    echo "<br>";
    echo "------------------------------------------------------";

    echo "<br>";

    echo'<strong>Différence entre les 2 tableaux domain [domain_api] et [domain_bdd] (update) !!!</strong>';
    echo "<br>";
    echo "<br>";

    $domain_update = $bdd->arrayDiffDomainUpdate($domain_api, $domain_bdd);

    foreach ($domain_update as $domain_name => $isUpdate)
    {
        if ($isUpdate)
        {
            echo "Requête d'update effectuée pour " . $domain_name ;
            echo "<br>";
            echo "<br>";
            
        }
        else
        {
            echo "Les infos de " . $domain_name . " sont déjà présentes dans la BDD";
            echo "<br>";
            echo "Requête d'update non effectuée.";
            echo "<br>";
            echo "<br>";
        }
    }

    echo "<br>";
    echo "------------------------------------------------------";

    echo "<br>";

    echo'<strong>Différence entre les 2 tableaux vps [vps_bdd] et [vps_api] (flag ovh) !!!</strong>';
    echo "<br>";
    echo "<br>";

    $vps_flag = $bdd->arrayDiffVpsFlag($vps_bdd, $vps_api);

    foreach ($vps_flag as $vps_name => $isFlagUpdate)
    {
        if ($isFlagUpdate)
        {
            echo "Requête d'update effectuée pour " . $vps_name ;
            echo "<br>";
            echo "<br>";
            
        }
        else
        {
            echo $vps_name . " est encore présent sur l'API, le flag ovh reste à 1.";
            echo "<br>";
            echo "<br>";
        }
    }


    echo "<br>";
    echo "------------------------------------------------------";

    echo "<br>";

    echo'<strong>Différence entre les 2 tableaux domain [domain_bdd] et [domain_api] (flag ovh) !!!</strong>';
    echo "<br>";
    echo "<br>";

    $domain_flag = $bdd->arrayDiffDomainFlag($domain_bdd, $domain_api);

    foreach ($domain_flag as $domain_name => $isFlagUpdate)
    {
        if ($isFlagUpdate)
        {
            echo "Requête d'update effectuée pour " . $domain_name ;
            echo "<br>";
            echo "<br>";
            
        }
        else
        {
            echo $domain_name . " est encore présent sur l'API, le flag ovh reste à 1.";
            echo "<br>";
            echo "<br>";
        }
    }
}

else
{
    require_once 'vueErreurLogin.php';
}


?>