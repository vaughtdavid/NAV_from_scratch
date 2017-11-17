<?php
### SETUP
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/php-quandl-master/Quandl.php");
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/php-quandl-master/examples.php");

### GET QUANDL API KEY FROM STDIN
if (defined('STDIN')) {
  $api_key = $argv[1];
} else { 
  throw new Exception("No user input received. Need API Key as argument.", 1);
}


// https://github.com/DannyBen/php-quandl
function main() {
	global $api_key;
	$json_data = example2($api_key, "WIKI/AAPL");
	$data = json_decode($json_data);
	print_r("\n@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@\n");
	print_r($data);
	//print_r("\n\n\nThe data is...\n");
	//print_r($data["dataset"]["data"]);
}

main();
?>