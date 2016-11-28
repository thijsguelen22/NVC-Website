@extends('layouts.main')

@section('title', 'Login')

@section('content')
<script>

function showResult(str, fn, form) {
  if (str.length==0) { 
    document.getElementById("livesearch"+fn).innerHTML="";
	name = document.getElementById("teamnaam").value;
    //document.getElementById("livesearchTeam").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch"+fn).innerHTML=this.responseText;
      //document.getElementById("livesearchTeam").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","/inc/teamsearch.php?comp=hs&fn="+fn+"&form="+form+"&q="+str+"&name="+name,true);
  xmlhttp.send();
}
</script>
<?php
session_start();
//var_dump($_SESSION);
if(empty($_SESSION['err']))
	{
		$_SESSION['err'] = false;
	}
if($_SESSION['err']) {
	$naamErr = $_SESSION['naamErr'];
	$ovErr = $_SESSION['ovErr'];
	$passErr = $_SESSION['passErr'];
	$donatieErr = $_SESSION['donatieErr'];
	unset($_SESSION['err']);
} else {
	if(empty($_SESSION['team'])) {
		$_SESSION['team'] = "";
	}
$naamErr = $ovErr = $passErr = "";}?>
<style>
.errTxt {
	color: red;
}
.dynsearch {
	width: 50%;
}
p {
	color: white;
}
</style>
<?php
$CurrentUserId = "99999";
include("connector.php");
include("./inc/teamfunctions.php");
if(isset($_POST['continue2'])) {
	
}
if(isset($_POST['continue'])) {
	$data = JoinTeamQueries($pdo, $_SESSION['TEAM']['naam'], $CurrentUserId, $_SESSION['TEAM']['comp'], false);
	bindUserToTeam($pdo, $data[0][0], $CurrentUserId, $_SESSION['TEAM']['naam'], $_SESSION['TEAM']['comp']);
	echo "<h1>Aansluiten bij team ".$_SESSION['TEAM']['naam']." gelukt.</h1>";
} elseif(isset($_POST['save1'])) {
	$overrideable = $err = false;
	$errMsg = "";
	$teamNaam = strtolower($_POST['inputfieldTeam']);
	
	//deze variabelen moeten veranderd worden!!!
	//$CurrentUserId = $_SESSION['user']['UserId'];
	$_SESSION['user']['id'] = $CurrentUserId = "12345";
	//$comp = $_POST['comp'];
	$comp = "hs";
	
	echo "<h1>save1></h1><br />";

	$data = JoinTeamQueries($pdo, $teamNaam, $CurrentUserId, $comp, false);

	echo "</p>";
	if(empty($data[0][0]['TeamNaam'])) {
		$err = true;
		$errMsg = "Een team met de ingevoerde naam kan niet gevonden worden.";
	} elseif(!empty($data[3][0])) {
		$err = true;
		$errMsg = "Het door jouw gekozen team is vol.";
	} elseif(!empty($data[1][0])) {
		$err = true;
		$overrideable = true;
		$errMsg = "Jij bent momenteel beheerder van een groep. Als je je bij deze groep voegt, zal je huidige team verwijderd worden. Weet je zeker dat je door wilt gaan?";
	} elseif(!empty($data[2][0])) {
		$err = true;
		$overrideable = true;
		$errMsg = "Je zit momenteel al in een team. Als je doorgaat, verlaat je het huidige team en wordt je in het huidige team toegevoegd. Weet je zeker dat je door wilt gaan?";
	}
	
	
	if($err) {
		echo "<h1>Waarschuwing</h1>";
		echo "<p style='color: white'>".$errMsg."</p><br />";
		var_dump($data);
		if($overrideable) {
			var_dump($data);
			$_SESSION['TEAM']['naam'] = $teamNaam;
			$_SESSION['TEAM']['comp'] = $comp;
			echo '<form method="POST"><table class="registrationtable"><tr><td><button name="reset" class="nextbutton">Terug <div class="icon-large-left"></div></div></button></td><td><button name="continue" class="nextbutton">Doorgaan <div class="icon-large"></div></div></button></td></tr></table>';
		}
	} else {
		bindUserToTeam($pdo, $data[0][0], $CurrentUserId, $teamNaam, $comp, false);
		echo "<h1>Aansluiten bij team ".$teamNaam." gelukt.</h1>";
	}
	
	
	echo "<br />";
	//var_dump($data);
} elseif(isset($_POST['save2'])) {
	$err = $overrideable = false;
	$comp = "hs";
	$teamNaam = strtolower(isset($_POST['teamnaam']) ? $_POST['teamnaam'] : '');
	for($i=0;$i<4;$i++) {
		$teamlid[$i] = isset($_POST['inputfield'.$i]) ? $_POST['inputfield'.$i] : '';
	}
	for($i=0;$i<4;$i++) {
		for($j=0;$j<4;$j++) {
			if($i != $j) {
				if($teamlid[$i] == $teamlid[$j]) {
					$teamlid[$j] = "kutje";
					$err = true;
					$overrideable = true;
					$errMsg = "Teamlid kan niet twee keer in één team worden toegevoegd. Lid maar één keer toegevoegd.";
				}
			}
		}
	}
	if(empty($_POST['teamnaam'])) {
		$err = true;
		$overrideable = true;
		$errMsg = "Er is geen teamnaam ingevuld. (dit kan later aangepast worden)";
	}
	$data = JoinTeamQueries($pdo, $teamNaam, $CurrentUserId, $comp, $teamlid, true);
	if(isset($data[4][0]['GastId'])) {
		$err = true;
		$errMsg = "<h1>Een of meerdere leden zitten al in een team. Zij kunnen niet worden toegevoegd.</h1><br /><p style='color: white'>Onderstaande persoon/personen kunnen niet worden toegevoegd: <br /><table class='registrationtable' style='color: white; text-align: center;'>";
		$overrideable = true;
		foreach($data[4] as $value) {
			$errMsg = $errMsg . '<tr><td><b>Naam: '.$value['Naam']."</b></td><td><b>Ov nummer: ".$value['GastId']."</b></td></tr>";
		}
		$errMsg = $errMsg . '</table>';
	}
	if(isset($data[0][0]['TeamNaam'])) {
		$err = true;
		$overrideable = false;
		$errMsg = "<h1>Deze naam is al in gebruik.</h2><p>kies een andere naam.</p>";
	}
	if($err) {
		echo "<h1>".$errMsg."</h1>";
		if($overrideable){
			$_SESSION['TEAM']['naam'] = $teamNaam;
			$_SESSION['TEAM']['comp'] = $comp;
			$_SESSION['TEAM']['leden'] = $teamlid;
			//var_dump($teamlid);
			echo '<form method="POST"><table class="registrationtable"><tr><td><button name="reset" class="nextbutton">Terug <div class="icon-large-left"></div></div></button></td><td><button name="continue2" class="nextbutton">Doorgaan <div class="icon-large"></div></div></button></td></tr></table>';
		} else {
			echo '<form method="POST"><table class="registrationtable"><tr><td><button name="reset" class="nextbutton">Terug <div class="icon-large-left"></div></div></button></td></tr></table>';
		}
	} else {
		bindTeamToUser($pdo, $teamlid, $CurrentUserId, $teamNaam, $comp);
	}

	
	foreach($data as $value) {
		echo "<p style='color: white'>";
		//var_dump($value);
		echo "</p><br />";
	}
} else {
?>
<form method="post" action="">

        <h1>Teams</h1>
                <div id="registration1" class="ticket-content">
                        <table class="registrationtable">
							<tr>
                                <td><div id="teamjoinbtn" class="nextbutton" name="teamjoin">Een team joinen <div class="icon-large"></div></div></td>
								<td><div id="teamcreatebtn" class="nextbutton" name="teamcreate">Een team aanmaken <div class="icon-large"></div></div></td>
                            </tr>
                        </table>
                </div>
                <div id="teamjoin" class="ticket-content">
                        <table class="registrationtable">
							<tr>
								<?php 
								if(empty($_SESSION['fTeam'])) {
									$_SESSION['fTeam'] = "";
								}
								echo '<td><input value="'.$_SESSION["fTeam"].'" name="inputfieldTeam" type="text" autocomplete="off" size="30" onkeyup="showResult(this.value, '."'Team', 'naam'".')"></td></tr></table><br /><table class="registrationtable" id="livesearchTeam"></table>'; ?>
                            </tr>
						</table>
						<table>
							<tr>
								<td><div id="back" class="nextbutton" name="back">Terug <div class="icon-large-left"></div></div></td>
								<td><button id="save2" class="nextbutton" type="submit" name="save1">Opslaan <div class="icon-large"></div></button></td>
							</tr>
                        </table>
                </div>
				<div id="teamcreate" class="ticket-content">
					<p>Typ het leerlingnummer van je teamgenoten in, of typ op naam om bijbehorend leerlingnummer te zoeken</p>
                        <table class="registrationtable">
							<tr>
								<?php
								if(empty($_SESSION['teamnaam'])) {
									$_SESSION['teamnaam'] = "";
								}?>
								<td><input type="text" name="teamnaam" id="teamnaam" placeholder="Teamnaam" value="<?php echo $_SESSION['teamnaam']; ?>" />
                            <?php
								//session_start();
								
								for($i=1; $i < 5; $i++) {
								
								if(empty($_SESSION['f'.$i])) {
									$_SESSION['f'.$i] = "";
								}
								
								echo '<tr><td><input value="'.$_SESSION['f'.$i].'" name="inputfield'.$i.'" type="text" autocomplete="off" size="30" onkeyup="showResult(this.value, '.$i.', '."'kek'".')"><td></td></tr></table><br /><table class="registrationtable" id="livesearch'.$i.'"></table><br />';	
								}
								
								?>
							</table>
							<br />
							<table class="registrationtable">
								<tr>
									<td><div id="back1" class="nextbutton" name="back1">Terug <div class="icon-large-left"></div></div></td>
									<td><button id="save2" class="nextbutton" type="submit" name="save2">Opslaan <div class="icon-large"></div></button></td>
								</tr>
                        </table>
                </div>
    </form>

<div class="clear">

</div>
<script type="text/javascript">

    $('#teamcreate').hide();
	$('#teamjoin').hide();


    var cur = 1;
    var max = $(".ticket-content").length;

    $("#teamcreatebtn").click(function(){
        $('#registration1').hide();
		$('#teamjoin').hide();
        $('#teamcreate').fadeIn();
    });
	
	$("#teamjoinbtn").click(function(){
        $('#registration1').hide();
		$('#teamcreate').hide();
        $('#teamjoin').fadeIn();
    });

    $("#back").click(function(){
        $('#teamjoin').hide();
		$('#teamcreate').hide();
        $('#registration1').fadeIn();
    });
	
	$("#back1").click(function(){
        $('#teamjoin').hide();
		$('#teamcreate').hide();
        $('#registration1').fadeIn();
    });
</script>
<?php
echo '<script>';
if(empty($_GET['team'])) {
	$_GET['team'] = "nope";
}
if($_GET['team'] == "join") {
	echo '$("#registration1").hide();
		$("#teamcreate").hide();
        $("#teamjoin").fadeIn();';
} elseif($_GET['team'] == 'create') {
	echo '$("#registration1").hide();
		$("#teamcreate").fadeIn();
        $("#teamjoin").hide();';
} else {
	echo '$("#registration1").fadeIn();
		$("#teamcreate").hide();
        $("#teamjoin").hide();';
}
echo "</script>";
}
?>
@endsection