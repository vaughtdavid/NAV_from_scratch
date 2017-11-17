<?php
### SETUP
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/php-quandl-master/Quandl.php");
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/php-quandl-master/examples.php");
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/additional_helper_functions.php");

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
	$php_std_obj = json_decode($json_data);
	
	
	### THE HEADERS...
	print_r("\n\nThe headers are...\n");
	print_r(($php_std_obj->dataset)->column_names);

	### THE RECORDS...
	print_r("\n\nThe data is...\n");
	print_r(_2d_array_print(($php_std_obj->dataset)->data));
}



main();
?>