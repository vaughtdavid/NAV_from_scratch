<?php 

function getAllDates() {
	$sql = "SELECT DISTINCT q.date FROM `Quotes` q ORDER BY q.date ASC;";
	$result['dates'] = $conn->query($sql);
	if ($result) {
		return $result['dates'];
	} else {
		$result['error'] = $conn->mysqli_error();
		return [false,$result];
	}	
}#RESULT: ["1.Jan.1969", "2.Jan.1969", ... "1.Nov.2017", "1.Nov.2017", "1.Nov.2017"]

function getTheseDates($start_date,$end_date) {
	$sql = "SELECT DISTINCT q.date FROM `Quotes` q WHERE q.date >= '".$start_date."' AND q.date <= '".$end_date."' ORDER BY q.date ASC;";
	$result['dates'] = $conn->query($sql);
	if ($result) {
		return $result['dates'];
	} else {
		$result['error'] = $conn->mysqli_error();
		return [false,$result];
	}	
}#RESULT: ["1.Jan.17", "2.Jan.17", ... "29.Jan.17", "30.Jan.17", "31.Jan.17"]


function getStockQuantity($symbol,$the_date) {
	$sql = "FROM `Transactions` t select sum(t.total) where t.symbol = ".$symbol." and t.date <= ".$the_date.";";
	$result['qty'] = $conn->query($sql);
	if ($result) {
		return $result['qty'];
	} else {
		$result['error'] = $conn->mysqli_error();
		return [false,$result];
	}	
}#RETURN: 50 (stocks)

function getStockQuantities($symbol,$date_list) {
	foreach ($date_list as $i => $current_date) {
		$result_list[$current_date] = getStockQuantity($symbol,$current_date);
	}
	return $result_list;
}#RETURN: ["1.Jan.17"=>"50", "2.Jan.17"=>"50", ... "31.Jan.17"=>"100"]

function getStockPrice($symbol,$the_date) {
	$sql = "FROM `Quotes` q select q.close where q.date = ".$the_date." and q.symbol = ".$symbol.";";
	$result['price'] = $conn->query($sql);
	if ($result['price']) {
		return $result['price'];
	} else {
		$result['error'] = $conn->mysqli_error();
		return [false,$result];
	}	
}#RETURN: $1.50 (price per share)

function getValueofPosition($symbol,$the_date) {
	$result['qty'] = getStockQuantity($symbol);
	$result['price'] = getStockPrice($symbol,$the_date);
	if ($result['qty'] && $result['price']) {
		return $result['qty'] * $result['price'];
	} else {
		return [false,$result];
	}
}#RETURN: $75.00 (position value)


function getChangeinValue($symbol,$initial_date,$final_date) {
	$result['initial'] = getValueofPosition($symbol,$initial_date);
	$result['final'] = getValueofPosition($symbol,$final_date);
	$result['diff'] = $result['final'] - $result['initial'];
	if ($result['diff']) {
		return $result['diff'];
	} else {
		return [false,$result];
	}
}#RETURN: $1.50 - $1.25 = 0.25

function getDayChanges($symbol,$date_list) {
	$last_date = $date_list[0];
	foreach ($date_list as $i => $current_date) {
		$result_list[$current_date] = getChangeinValue($symbol,$last_date,$current_date);
		$last_date = $current_date;
	}
	#Set Cost Basis
	$result_list[$date_list[0]] = getStockPrice($symbol,$date_list[0]);
	
	return $result_list;
}#RETURN: ["1.Jan.17"=>"$5.00", "2.Jan.17"=>".02", "3.Jan.17"=>".01", "4.Jan.17"=>".02"]

function getSimpleCostBasis($stock_list,$date_list) {
	foreach ($stock_list as $i => $symbol) {
		$result[$symbol] = getDayChanges($symbol,$date_list);
	}
	return $result;
}#RETURN: ['GOOG' => ["1.Jan.17"=>"5.00",  "2.Jan.17"=>".06", "3.Jan.17"=>".01"],
 #         'AMZN' => ["10.Feb.17"=>"10.00",  "11.Feb.17"=>".10", "12.Feb.17"=>".12"]]

function getAllStockQuantities($stock_list,$date_list) {
	foreach ($stock_list as $i => $symbol) {
		$result[$symbol] = getStockQuantities($symbol,$date_list);
	}
	return $$result;
}#RETURN: ['GOOG' => ["1.Jan.17"=>"50",  "2.Jan.17"=>"50", "3.Jan.17"=>"75"],
 #         'AMZN' => ["10.Feb.17"=>"20",  "11.Feb.17"=>"15", "12.Feb.17"=>"15"]]

function getAllStockValues() {

}

function getPortfolioValue($stock_list,$the_date) {
	$sum__qty_price = 0;
	foreach ($stock_list as $i => $symbol) {
		$temp = getValueofPosition($symbol,$the_date);
		if ($temp) {
			$sum__qty_price += $temp;
		} else {
			$result['error'] = $conn->mysqli_error();
			return [false,$result];  
		}
	}
	return $sum__qty_price;
}

 ?>