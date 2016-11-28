<?php
function InsertData($_POST) {
	
	$Salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
	
	$Password = hash('sha512', $_POST['password'] . $Salt);
	
	$parameters = array(
		':name'=>$_POST['naam'];,
		':email'=>$_POST['email'],
		':ovnummer'=>$_POST['vestiging'],
		':password'=>$Password,
		':salt'=>$Salt,
		':ticket'=>$_POST['ticket']);
	$query = "INSERT INTO `users`
		(
			`name`, 
			`ovnummer`,
			`email`, 
			`password`, 
			`salt`, 
			`ticket`) 
			VALUES (
			:name, 
			:ovnummer,
			:email,  
			:password, 
			:salt, 
			:ticket)";
	$sth = $pdo->prepare($query);
		if (!$sth) {
			echo "\nPDO::errorInfo():\n";
			print_r($pdo->errorInfo());
		}
		$sth->execute($parameters);
}