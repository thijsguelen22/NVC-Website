<?php
function CreateTeamQueries($pdo, $teamNaam, $CurrentUserId, $comp, $teamlid) {
	foreach($teamlid as $value) {
		$data[$value] = JoinTeamQueries($pdo, $teamnaam, $value, $comp, $true);
	}
	
	return $data;
}
function JoinTeamQueries($pdo, $teamNaam, $CurrentUserId, $comp, $create) {
	$PDOArr[0] = array(':teamnaam'=>$teamNaam,':comp'=>$comp);
	$PDOArr[1]= array(':GastId'=>$CurrentUserId,':comp'=>$comp);
	
	//$teamAdmin = $_POST['inputfieldTeam'];\
	$query[0] = 'SELECT * from teams WHERE teamNaam = :teamnaam AND TeamSpel = :comp'; // selecteer alles van de regel waar teamnaam en spel overeen komt
	
	$query[1] = 'SELECT * from teams WHERE TeamAdmin = :GastId AND TeamSpel = :comp AND Teamlid2 IS NOT NULL OR TeamAdmin = :GastId AND TeamSpel = :comp AND Teamlid3 IS NOT NULL OR TeamAdmin = :GastId AND TeamSpel = :comp AND Teamlid4 IS NOT NULL OR TeamAdmin = :GastId AND TeamSpel = :comp AND Teamlid5 IS NOT NULL'; //Selecteer alle teams die de huidige gebruiker beheert, en waar één of meerdere teamledenvelden NIET leeg zijn
	
	$query[2] = 'SELECT * from teams WHERE TeamSpel = :comp AND Teamlid2 = :GastId OR TeamSpel = :comp AND Teamlid3 = :GastId OR TeamSpel = :comp AND Teamlid4 = :GastId OR TeamSpel = :comp AND Teamlid5 = :GastId'; //Selecteer alle teams waar de huidige gebruiker in zit
	
	$query[3] = 'SELECT * from teams WHERE TeamNaam = :teamnaam AND TeamSpel = :comp AND Teamlid2 IS NOT NULL AND TeamNaam = :teamnaam AND TeamSpel = :comp AND Teamlid3 IS NOT NULL AND TeamNaam = :teamnaam AND TeamSpel = :comp AND Teamlid4 IS NOT NULL AND TeamNaam = :teamnaam AND TeamSpel = :comp AND Teamlid5 IS NOT NULL'; //Selecteer alles van teams waar teamnaam overeen komt, en waar het team vol is
	
	if($create) {
		$query[4] = 'SELECT * from gasten, teams 
WHERE gasten.GastId = :GastId 
AND teams.TeamSpel = :comp 
AND teams.Teamlid2 = :GastId 
OR gasten.GastId = :GastId 
AND teams.TeamSpel = :comp 
AND teams.Teamlid3 = :GastId 
OR gasten.GastId = :GastId 
AND teams.TeamSpel = :comp 
AND teams.Teamlid4 = :GastId 
OR gasten.GastId = :GastId 
AND teams.TeamSpel = :comp 
AND teams.Teamlid5 = :GastId
OR teams.TeamAdmin = gasten.GastId
AND Teamlid2 IS NOT NULL
OR teams.TeamAdmin = gasten.GastId
AND Teamlid3 IS NOT NULL
OR teams.TeamAdmin = gasten.GastId
AND Teamlid4 IS NOT NULL
OR teams.TeamAdmin = gasten.GastId
AND Teamlid5 IS NOT NULL'; //Selecteer alle teams waar de huidige gebruiker in zit
	}
	
	$PArrOrd = array(0, 1, 1, 0, 1);
	
	return SQLDataToArray($query, $pdo, $PDOArr, $PArrOrd);

}

function SQLDataToArray($queries, $pdo, $PDOArr, $PDOArrayOrder) {
	for($i=0;$i<count($queries);$i++) {
		$sth = $pdo->prepare($queries[$i]);
		$sth->execute($PDOArr[$PDOArrayOrder[$i]]);
		$data[$i] = $sth->fetchAll(PDO::FETCH_ASSOC);
		
	}
	return $data;
}

function bindUserToTeam($pdo, $teamData, $GastId, $teamNaam, $comp) {
	$PDOArr = array(':GastId'=>$GastId, ':teamnaam'=>$teamNaam, ':comp'=>$comp);
	$PDOArr2 = array(':GastId'=>$GastId, ':comp'=>$comp);
	if($teamData['Teamlid2'] == NULL) {
		$row = "Teamlid2";
	} elseif($teamData['Teamlid3'] == NULL) {
		$row = "Teamlid3";
	} elseif($teamData['Teamlid4'] == NULL) {
		$row = "Teamlid4";
	} else {
		$row = "Teamlid5";
	} 	
	$sth = $pdo->prepare('UPDATE teams SET '.$row.' = :GastId WHERE TeamNaam = :teamnaam AND TeamSpel = :comp');
	$sth2 = $pdo->prepare('DELETE FROM teams WHERE TeamAdmin = :GastId AND TeamSpel = :comp');
	
	$sth->execute($PDOArr);
	$sth2->execute($PDOArr2);
}

function bindTeamToUser($pdo, $teamData, $GastId, $teamNaam, $comp) {
	$sth = $pdo->prepare('UPDATE teams SET TeamNaam = :teamnaam, Teamlid2 = :teamlid2, Teamlid3 = :teamlid3, Teamlid4 = :teamlid4, Teamlid5 = :teamlid5 WHERE TeamAdmin = :GastId AND TeamSpel = :comp');
	for($i=2;$i<6;$i++) {
		$sth = $pdo->prepare('DELETE from teams WHERE TeamSpel = :comp AND TeamAdmin = :teamlid'.$i);
		$PDOArr2 = array(':teamlid'.$i=>$teamData[($i - 2)],
			':comp'=>$comp);
		$sth2->execute($PDOArr2);
	}
	
	$PDOArr = array(":GastId"=>$GastId,
		':teamnaam'=>$teamNaam,
		':comp'=>$comp,
		'Teamlid2'=>$teamData[0],
		'Teamlid3'=>$teamData[1],
		'Teamlid4'=>$teamData[2],
		'Teamlid5'=>$teamData[3]);
	
	$sth->execute($PDOArr);
	
}