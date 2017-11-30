<?php

include('./resources/database.php');
$db = new Database();
$db->connect();
$db->select('mysqlcrud');
$res = $db->getResult();
print_r($res);

$db->update('mysqlcrud',array('name'=>'Changed!'),array('id',1));
$db->update('mysqlcrud',array('name'=>'Changed2!'),array('id',2));
$res = $db->getResult();
print_r($res);

$db->insert('mysqlcrud',array(3,"Name 4","this@wasinsert.ed"));
$res = $db->getResult();
print_r($res);


?>