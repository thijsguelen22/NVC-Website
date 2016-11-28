<?php
//oy suka, dont touch this or babooshka will be mad
//and dont use root blin
try {
	$pdo = new PDO("mysql:host=localhost;dbname=nvc", 'root', '');
}
catch(PDOException $e) {
	echo $e->getMessage();
}