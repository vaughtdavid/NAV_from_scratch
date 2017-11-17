<?php
# SETUP

## DEPENDANCIES
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/php-quandl-master/Quandl.php");
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/php-quandl-master/examples.php");
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/additional_helper_functions.php");
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/mysql_functions.php");

## LIGHT SWITCHES
$debug = false;

## GET QUANDL API KEY FROM STDIN
if (defined('STDIN')) {
  $api_key = $argv[1];
  $symbol = $argv[2];
} else { 
  throw new Exception("No user input received. Need API Key and Stock Symbol as arguments.", 1);
}

## GLOBAL VARUABLES
$host = "localhost";
$username = "root";
$password = "root";
$database = "NAV_from_scratch";

// https://github.com/DannyBen/php-quandl
function main() {
	
	# SETUP
	global $api_key, $symbol, $debug, $host, $username, $password, $database;
	$conn = SQL_Connect($host,$username,$password,$database);
	if (! Table_Exists($conn, "quotes")) {
		if (! CREATE_Quotes_TABLE($conn, "quotes")) {
			throw new Exception("Quotes table does not exist and could not be created in ".$database, 1);
		};
	}

	# GET DATA FROM QUANDL...
	$json_data = example2($api_key, "WIKI/".$symbol);
	$php_std_obj = json_decode($json_data);
	
	## THE HEADERS...
	if($debug){ print_r("\n\nThe headers are...\n"); }
	if($debug){ print_r(($php_std_obj->dataset)->column_names); }
	$headers = ($php_std_obj->dataset)->column_names;
	array_push($headers, "symbol");

	## THE RECORDS...
	if($debug){ print_r("\n\nThe data is...\n"); }
	if($debug){ print_r(_2d_array_print(($php_std_obj->dataset)->data)); }
	$records = ($php_std_obj->dataset)->data;
	
	foreach ($records as $record) {
	     array_push($record, $symbol);
	     $sql = Query_Builder_INSERT_INTO_Quotes ($header, $record);
	     $result = $conn->query($sql);
	     if ($result == FALSE) {
	           # Copy record to the reject list in the output file. 
	           print_r($record);
	     } else {
	           # Continue. 
	     }
	}


}



main();
?>