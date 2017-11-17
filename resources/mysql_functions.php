<?php

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
	
	$sql = "CREATE TABLE `".$table_name."` (\n`id` int(11) NOT NULL AUTO_INCREMENT,\n`Date` date DEFAULT NULL,\n`Open` double DEFAULT 0,\n`High` double DEFAULT 0,\n`Low` double DEFAULT 0,\n`Close` double DEFAULT 0,\n`Volume` double DEFAULT 0,\n`Ex-Dividend` double DEFAULT 0,\n`Split Ratio` double DEFAULT 0,\n`Adj_Open` double DEFAULT 0,\n`Adj_High` double DEFAULT 0,\n`Adj_Low` double DEFAULT 0,\n`Adj_Close` double DEFAULT 0,\n`Adj_Volume` double DEFAULT 0,\nPRIMARY KEY (`id`)\n) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=latin1;";
	$result = $conn->query($sql);

	if ($result == FALSE) {
		return false;
	} else {
  		return true;
	}
}


function Query_Builder_INSERT_INTO_Quotes ($acct_num, $data_array) {
	$beginning = "INSERT INTO `Statements_".$acct_num."` (\n\t`id`,\n\t";

	$headers = "`";
	$values = "'";
	foreach ($data_array as $key => $value) {
		$headers .= $key;
		$headers .= "`,\n\t`";

		$values .= _3_helper___Arr_Get($data_array,$key);
		$values .= "',\n\t'";
	}
	#remove comma after last header (one, two, three, ) -> (one, two, three)
	$headers = rtrim($headers,",\n\t`");

	$middle = "`\n) VALUES (\n\tNULL,\n\t";

	#remove comma after last value (1, 2, 3, ) -> (1, 2, 3)
	$values = rtrim($values,",\n\t'");

	$end = "'\n);";
	
	return $beginning.$headers.$middle.$values.$end;
}

?>