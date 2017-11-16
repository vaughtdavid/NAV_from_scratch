<?php
### SETUP
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/restful_api.php");


function main() {
	$symbol = "aapl";
	$response = _1_GET_quote($symbol);	
	print_r($response);
}

main();
?>