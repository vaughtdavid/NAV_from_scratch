<?php
 
class Position {

    // Class properties and methods go here
    public $quantity = 0;
    public $mkt_value = 0;

    public function setEODValue($the_date) {
    	#Query database for End of Day value of the given day


    	$this->
    }

	public function setProperty($newval) {
		$this->prop1 = $newval;
	}

	public function getProperty() {
		return $this->prop1 . "<br />";
	}
	

	

}
 
class Portfolio {

	public function getPositions {
		return [$this->positions, $this->quantities, $this->value]
	}

	public function hasEnvelope {

	}

	public function addEnvelope {

	}

	

}



$obj = new MyClass;
 
echo $obj->getProperty(); // Get the property value
$obj->setProperty("I'm a new property value!"); // Set a new one
echo $obj->getProperty(); // Read it out again to show the change

var_dump($obj); // To see the contents of the class, use var_dump():


?>