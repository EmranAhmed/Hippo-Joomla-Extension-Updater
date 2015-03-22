<?php

define('SOURCE_FILE_DIR', 'zips/');

// You will get username / purchasecode and theme name
$buyer = trim($_GET['username']);
$purchase_key = trim($_GET['purchase_code']);
$template = trim($_GET['template']);

$username = "themehippo";
$apikey = "API_KEY";

require_once "Envato_marketplaces.php";

$Envato = new Envato_marketplaces();

$Envato->cache_expires = 0;


$Envato->set_api_key($apikey);

$verify = $Envato->verify_purchase($username, $purchase_key);

// Quickie test. 
if ( isset($verify->buyer) and $verify->buyer==$buyer ){


	$filename = "{$template}.zip";
	$filepath = dirname(__FILE__).'/' . SOURCE_FILE_DIR;

	
    // http headers for zip downloads
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"".$filename."\"");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($filepath.$filename));
	ob_end_flush();
	@readfile($filepath.$filename);
}