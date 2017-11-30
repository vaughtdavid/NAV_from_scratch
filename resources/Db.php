<?php 

class Db {
	// The database connection
	protected static $connection;
	
	public function connect() {
		// Try and connect to the database
		if(!isset(self::$connection)) {
			$config = parse_ini_file('mysql_config.ini'); 
			self::$connection = new mysqli('localhost',$config['username'],$config['password'],$config['dbname']);
		}
	
		// If connection was not successful, handle the error
		if(self::$connection === false) {
			// Handle error - notify administrator, log to a file, show an error screen, etc.
			return false;
		}
		return self::$connection;
	}

	public function disconnect() {
	    if(isset(self::$connection)) {
	        self::$connection::close();
	        return true;
	    }
	    else { return false; }
	}

	public function tableExists($table_name) {
		$sql = "SELECT 1 FROM `".$table_name."` LIMIT 1;";
		$result = self::$connection::query($sql);

		if ($result == false) {
			return false;	
		} else {
			return true;
		}
	}

	public function query($query) {
		if(isset(self::$connection)) {		
			// Query the database
			$result = self::$connection::query($query);
			return $result;
		} else {
			return false;
		}
	}
	
	public function select($query) {
		$rows = array();
		$result = $this::query($query);
		if($result === false) {
			return false;
		}
		while ($row = $result::fetch_assoc()) {
			$rows[] = $row;
		}
		return $rows;
	}
	
	public function select($table, $rows = '*', $where = null, $order = null) {
        $q = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
        if($order != null)
            $q .= ' ORDER BY '.$order;
        if($this->tableExists($table)) {
        	$query = @mysql_query($q);
        	if($query) {
            	$this->numResults = mysql_num_rows($query);
            	for($i = 0; $i < $this->numResults; $i++) {
                	$r = mysql_fetch_array($query);
                	$key = array_keys($r); 
                	for($x = 0; $x < count($key); $x++) {
                    	// Sanitizes keys so only alphavalues are allowed
                    	if(!is_int($key[$x])) {
                        	if(mysql_num_rows($query) > 1) {
                            	$this->result[$i][$key[$x]] = $r[$key[$x]];
                        	}
                        	else if(mysql_num_rows($query) < 1) {
                            	$this->result = null; 
                        	}
                        	else {
                            	$this->result[$key[$x]] = $r[$key[$x]]; 
                        	}
                		}
                	}
            	}            
            	return true; 
        	} else { 
                return false; 
            }
        } else { 
            return false; 
        }
    }









	
	public function error() {
		$connection = $this -> connect();
		return $connection -> error;
	}
	
	/**
	 * Quote and escape value for use in a database query
	 *
	 * @param string $value The value to be quoted and escaped
	 * @return string The quoted and escaped string
	 */
	public function quote($value) {
		$connection = $this -> connect();
		return "'" . $connection -> real_escape_string($value) . "'";
	}
}