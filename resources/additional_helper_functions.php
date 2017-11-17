<?php
$to_return = "";

function _2d_array_print(&$_2d_data) {
	global $to_return;
	array_walk($_2d_data, "print_row");
	$to_return .= "\n";
	return $to_return;
}

function print_row(&$item) {
	global $to_return;
	$to_return .= "\n";
	array_walk($item, "print_cell");
}

function print_cell(&$item) {
	global $to_return;
	$to_return .= str_pad($item, 17);
	$to_return .= " ";
}

?>
