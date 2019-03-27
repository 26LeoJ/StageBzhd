<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;


class ApiOvh
{
	// déclaration des variables
	private $ak;

	private $as;

	private $ck;

	private $base_url;

	private $clientGuzzle;


	// fonction constructeur
	public function __construct()
	{ 
		$this->ak = 'OVhdf73Crgjfj44Hc'; // 
		$this->as = 'dR3eTI7l5gdfg5dgdz44wDhPEUMIsjFUqiZWhS'; // à commmenter
		$this->ck = '30ZjjhRdWZ8JIM4g5fdg4fdg6iEyBe9aFXKosh6x'; //
		$this->base_url = 'https://eu.api.ovh.com/1.0/';
		$this->clientGuzzle = new Client(['base_uri' => $this->base_url]);
	}


	public function getVpsListApi() // fonction qui va lister tous les vps actifs
	{

		$vps = $this->get('vps/');

		$return = [];

		$i = 0;
		foreach ($vps as $vps_name)
		{

			//echo $vps_name.'<br>';

			$vps_infos = $this->get('vps/'.$vps_name);

			$vps_serviceInfos = $this->get('vps/'.$vps_name.'/serviceInfos');

			/*echo "<pre>";
			var_dump($vps_infos);
			echo "</pre>";*/

			$tab = array('name' => $vps_infos['name'], 'display_name' => $vps_infos['displayName'], 'zone' => $vps_infos['zone'], 'state' => $vps_infos['state'], 'cluster' => $vps_infos['cluster'], 'offer' => $vps_infos['model']['offer'], 'contact_billing' => $vps_serviceInfos['contactBilling'], 'billing_status' => $vps_serviceInfos['status'], 'renew_period' => $vps_serviceInfos['renew']['period'], 'renew_automatic' => $vps_serviceInfos['renew']['automatic'], 'expiration' => $vps_serviceInfos['expiration']);


			array_push($return, $tab);

			$i++;

			/*echo "<pre>";
			print_r($return);
			echo "</pre>";*/

		}


		return $return;	
	}


	public function getDomainListApi()  // fonction qui va lister tous les domaines actifs
	{
		$domain = $this->get('domain/');

		$return = [];

		foreach ($domain as $domain_name)
		{	
			$domain_infos = $this->get('domain/'.$domain_name.'/serviceInfos');

			$tab= array('name' => $domain_infos['domain'], 'contact_billing' => $domain_infos['contactBilling'], 'billing_status' => $domain_infos['status'], 'renew_period' => $domain_infos['renew']['period'], 'renew_automatic' => $domain_infos['renew']['automatic'], 'expiration' => $domain_infos['expiration']);

			array_push($return, $tab);
		}

		return $return;
	}

	private function get($end_url){
		//$end_url= '/vps';
		$timestamp = time();

		$signature = '$1$'.sha1($this->as.'+'.$this->ck.'+'.'GET'.'+'.$this->base_url.$end_url.'+'.''.'+'.$timestamp);

		// Lister tous les vps avec GET sur API OVH
		$res = $this->clientGuzzle->get($end_url,[
			'headers' => [
				'X-Ovh-Application' => $this->ak,
				'X-Ovh-Timestamp'=> $timestamp,
				'X-Ovh-Signature'=> $signature,
				'X-Ovh-Consumer'=> $this->ck,
			],

			'http_errors' => false]
		);
		

		if ($res->getStatusCode() !== 200 )
		{
			echo $res->getStatusCode();      // >>> 200
			echo '<br>';
			echo $res->getReasonPhrase();    // >>> OK
			die();
		}

		/*echo '<pre>';
		var_dump($res);
		echo '</pre>';*/
		
		$body = $res->getBody();

		$return = (json_decode($body, true));

		return $return;
	}

}

?>