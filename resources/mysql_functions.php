<?php
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/globals.php");

function SQL_Connect($host,$username,$password,$database) {
	#  Connect Error (2002) — No such file or directory. => https:# stackoverflow.com/questions/4219970/warning-mysql-connect-2002-no-such-file-or-directory-trying-to-connect-vi
	
	# DEFINE('DB_USERNAME', 'root');
	# DEFINE('DB_PASSWORD', 'root');
	# DEFINE('DB_HOST', 'localhost');
	# DEFINE('DB_DATABASE', 'TDA_NAV');
	$conn = new mysqli($host,$username,$password,$database);

	if (mysqli_connect_error()) {
	  die('Connect Error ('.mysqli_connect_errno().') — '.mysqli_connect_error().".\n");
	}

	# I'll close the connection in the caller function
	return $conn;
}
function Table_Exists($conn, $table_name) {
	$sql = "SELECT 1 FROM `".$table_name."` LIMIT 1;";
	$result = $conn->query($sql);

	if ($result == false) {
		return false;	
	} else {
		return true;
	}
}
function CREATE_Quotes_TABLE($conn, $table_name) {
	
	$sql = "CREATE TABLE `".$table_name."` (\n`id` int(11) NOT NULL AUTO_INCREMENT,\n`symbol` text DEFAULT NULL,\n`date` date DEFAULT NULL,\n`open` double DEFAULT 0,\n`high` double DEFAULT 0,\n`low` double DEFAULT 0,\n`close` double DEFAULT 0,\n`volume` double DEFAULT 0,\n`ex-dividend` double DEFAULT 0,\n`split_ratio` double DEFAULT 0,\n`adj_open` double DEFAULT 0,\n`adj_high` double DEFAULT 0,\n`adj_low` double DEFAULT 0,\n`adj_close` double DEFAULT 0,\n`adj_volume` double DEFAULT 0,\nPRIMARY KEY (`id`)\n) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=latin1;";
	$result = $conn->query($sql);

	if ($result == FALSE) {
		return false;
	} else {
  		return true;
	}
}


function Query_Builder_INSERT_INTO_Quotes ($headers, $record) {
	global $debug;
	# ZIPPER FUNCTION, just for good measure. =)
	if($debug){ print_r($headers); }
	if($debug){ print_r($record); }
	
	$data_array = array_combine($headers, $record);
	if($debug){ print_r($data_array); }
	
	
	$beginning = "INSERT INTO `quotes` (\n\t`id`,\n\t";

	$headers = "`";
	$values = "'";
	foreach ($data_array as $key => $value) {
		$headers .= $key;
		$headers .= "`,\n\t`";

		$values .= Arr_Get($data_array,$key);
		$values .= "',\n\t'";
	}
	#remove comma after last header (one, two, three, ) -> (one, two, three)
	$headers = rtrim($headers,",\n\t`");

	$middle = "`\n) VALUES (\n\tNULL,\n\t";

	#remove comma after last value (1, 2, 3, ) -> (1, 2, 3)
	$values = rtrim($values,",\n\t'");

	$end = "'\n);";
	
	if($debug){ print_r($beginning.$headers.$middle.$values.$end); }
	return $beginning.$headers.$middle.$values.$end;
}

?>