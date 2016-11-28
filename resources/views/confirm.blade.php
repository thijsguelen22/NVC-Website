@extends('layouts.main')

@section('title', 'Login')

@section('content')
<style>
.ticket-text {
	/*background-color:  hsla(0, 0%, 100%, 0.7);*/
	color: white;
	font-size: 24px;
}
#barcode {
	max-width: 400px;
}
.errTxt {
	color: red;
}
.smalltext {
	font-size: 18px;
}
</style>
<script type="text/javascript">
  function openWin()
  {
    var myWindow=window.open('','','width=200,height=100');
    myWindow.document.write("<p>This is 'myWindow'</p>");
    
    myWindow.document.close();
myWindow.focus();
myWindow.print();
myWindow.close();
    
  }
</script>
<?php
session_start();
if(isset($_SESSION['POST'])) {
	require_once __DIR__ . '/mail.php';
	include("./functions.php");
	//$Salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
	
	//$pass			= isset($_SESSION['POST']['password']) ? $_SESSION['POST']['password'] : '';
	//$hashedPassword		= hash('sha512', $pass);
	$_SESSION['ovErr'] = $_SESSION['naamErr'] = $_SESSION['ticketErr'] = $_SESSION['compErr'] = $_SESSION['donatieErr'] = $_SESSION['Err'] = NULL;
	$naam				= isset($_SESSION['POST']['naam']) ? $_SESSION['POST']['naam'] : '';
	$pass				= isset($_SESSION['pass']) ? $_SESSION['pass'] : '';
	$pass2				= isset($_SESSION['pass2']) ? $_SESSION['pass2'] : '';
	$email				= isset($_SESSION['POST']['email']) ? $_SESSION['POST']['email'] : '';
	$ticket				= isset($_SESSION['POST']['ticket']) ? $_SESSION['POST']['ticket'] : '';
	$vestiging			= isset($_SESSION['POST']['ovnummer']) ? $_SESSION['POST']['ovnummer'] : '';
	$donatie			= isset($_SESSION['POST']['donatie']) ? $_SESSION['POST']['donatie'] : '0';
	$comp1				= isset($_SESSION['POST']['comp1']) ? $_SESSION['POST']['comp1'] : '';
	$comp2				= isset($_SESSION['POST']['comp2']) ? $_SESSION['POST']['comp2'] : '';
	$comp3				= isset($_SESSION['POST']['comp3']) ? $_SESSION['POST']['comp3'] : '';
	
	if($comp1 != "none" && $comp1 != "hs" && $comp1 != "lol" && $comp1 != "csgo" && $comp1 != "rl" && $comp1 != "rss" && $comp1 != "ozu" && $comp2 != "none" && $comp2 != "hs" && $comp2 != "lol" && $comp2 != "csgo" && $comp2 != "rl" && $comp2 != "rss" && $comp2 != "ozu" && $comp3 != "none" && $comp3 != "hs" && $comp3 != "lol" && $comp3 != "csgo" && $comp3 != "rl" && $comp3 != "rss" && $comp3 != "ozu")
	{
		echo "<p>fucking compos</p>";
		header("Location: ./registratie");
		exit;
	}
	
	if($ticket != "regular" && $ticket != "food") {
		header("Location: ./registratie");
		exit;
	}
	
	if($comp2 == $comp1)
	{
		$comp2 = "none";
	}
	if($comp3 == $comp1)
	{
		$comp3 = "none";
	}
	if($comp3 == $comp2)
	{
		$comp3 = "none";
	}
	
	if(substr($vestiging, 0, 2) == "00") {
		$vestiging = substr($vestiging, 2);
	}
	
	if(!is_num_Only($vestiging)) {
		$_SESSION['err'] = true;
		$_SESSION['ovErr'] = '<span class="errTxt"><br />Leerlingnummer mag alleen nummers bevatten.</span>';
	}
	
	//voor als donatie gebruikt wordt
	/*if(!is_num_Only($donatie)) {
		$_SESSION['err'] = true;
		$_SESSION['donatieErr'] = '<span class="errTxt"><br />Leerlingnummer mag alleen nummers bevatten.</span>';
	}*/
	
	if(!is_minlength($vestiging, 5)) {
		$_SESSION['err'] = true;
		$_SESSION['ovErr'] = '<span class="errTxt"><br />Leerlingnummer moet minimaal 5 cijfers lang zijn.</span>';
	}
	
	if(!$_SESSION['passlenght']) {
		$_SESSION['err'] = true;
		$_SESSION['passErr'] = '<span class="errTxt"><br />wachtwoord moet minimaal 6 karakters lang zijn.</span>';
	}
	
	if($pass != $pass2) {
		$_SESSION['err'] = true;
		$_SESSION['passErr'] = '<span class="errTxt"><br />Wachtwoorden komen niet overeen.</span>';
	}
	
	if(!is_Char_Only($naam)) {
		$_SESSION['err'] = true;
		$_SESSION['naamErr'] = '<span class="errTxt"><br />Naam mag alleen letters bevatten.</span>';
	}
	if($_SESSION['err']) {
		header("Location: ./registratie");
		exit;
	}
	$barcode = "840162".rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
	$_SESSION['POST']['ean'] = $barcode;  //wat de fak doe ik hier kek
	
	//TODO:
	//check of de barcode bestaat!!!
	
	//insert de users ( ͡° ͜ʖ ͡°)
	//niet doordenken aub
	//blijf van de queries af als je niet weet wat je doet, database is ongesteld. (HELP CHOCOLA IS OP)
	
	
	//require('./connector.php'); //gewoon in de public map. livin' on the edge 
	try {
	$pdo = new PDO("mysql:host=localhost;dbname=nvc", 'root', '');
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	
	$sth = $pdo->prepare('SELECT COUNT(*) from login WHERE GastId = :ov');
	$sth2 = $pdo->prepare('SELECT COUNT(*) from tickets WHERE GastId = :ov');
	$sth3 = $pdo->prepare('SELECT COUNT(*) from gasten WHERE GastId = :ov');
	
	
	$PDOArr1 = array(':ov' => $vestiging);
	
	$sth->execute($PDOArr1);
	$sth2->execute($PDOArr1);
	$sth3->execute($PDOArr1);
	
	$data = $sth->fetchAll();
	$data2 = $sth2->fetchAll();
	$data3 = $sth3->fetchAll();
	
	if($data[0][0] != 0 || $data2[0][0] > 0 || $data3[0][0] > 0) {
		echo "<h1>Er bestaat al een account met dit leerlingnummer.</h1>";
	} else {
	
	
		//check of de barcode al bestaat, en zo ja, dan doe je t maar opnieuw
		
		
		//set de queries
		$sth = $pdo->prepare('INSERT INTO gasten(GastId, Naam) VALUES (:ovnummer, :naam)');
		$sth2 = $pdo->prepare('INSERT INTO login(GastId, Password) VALUES (:ovnummer, :password)');
		$sth3 = $pdo->prepare('INSERT INTO tickets(GastId, Ticket, Competitie1, Competitie2, Competitie3) VALUES (:ovnummer, :ticket, :comp1, :comp2, :comp3)');
		$comps = array('hs', 'ozu', 'rss', 'lol', 'rl', 'csgo');
		foreach($comps as $value) {
			if($comp1 == $value || $comp2 == $value || $comp3 == $value) {
				$sth4 = $pdo->prepare('INSERT INTO teams(TeamSpel, TeamAdmin) VALUES (:comp, :ovnummer)');
				$PDOArr4 = array(':comp'=>$value,
				':ovnummer'=>$vestiging);
				$sth4->execute($PDOArr4);
			}
		}
		
		//data binden in een array
		$PDOArr1 = array(
			':ovnummer' => $vestiging,
			':naam' => $naam);
		$PDOArr2 = array(
			':ovnummer' => $vestiging,
			':password' => $pass); //HASHED password!! nooit plain! kek
		$PDOArr3 = array(
			':ovnummer' => $vestiging,
			':ticket' => $ticket,
			':comp1' => $comp1,
			':comp2' => $comp2,
			':comp3' => $comp3);
			
		//and now the magic happens
		$sth3->execute($PDOArr3);
		$sth->execute($PDOArr1);
		$sth2->execute($PDOArr2);
		
		
		echo "<h1>Aanmelden succesvol</h1>";
		echo '<p class="ticket-text">Neem op de aanvang van de nacht je schoolpas mee. Op vertoon van deze pas mag je naar binnen.</p>';
		
		echo "<h3>overzicht</h3>";
		//echo "<div id='ticket'><h2>je ticket is aangemaakt</h2><br />";
		echo "<p class='ticket-text'>naam: $naam <br />leerlingnummer: $vestiging <br /> ticket: $ticket <br /><br /></p>";
		//echo '<img id="barcode" src="./barcode/sample-gd.php?ean='.$barcode.'" /></div>';
		
		
		if($comp1 != "none" || $comp2 != "none" || $comp3 != "none")
		{
			echo '<p class="ticket-text">We zien dat je je hebt aangemeld voor één of meerdere competities. Klik hier om je team(s) aan te maken.</p>';
			echo '<table class="registrationtable">
				<tr>';
			echo '<td><a href="./teams"><div id="next" class="nextbutton" name="print">Meld je aan voor team(s) <div class="icon-large"></div></div></a></td>';
			echo "</tr></table>";
		} else {
			echo '<p class="ticket-text">Het aanmelden is afgerond. Deze pagina kan afgesloten worden.</p>';
		}
		//bak mail het ticket naar de gene die zich waagd aan de party
		mailTicket();
			
		//var_dump($query);
		
		//session_destroy();
		
		//header("Location: http://nachtvancuijk.nl/");
		//exit;
	}		
} else {
//header("Location: http://nachtvancuijk.nl/");
//exit;
?>
    <div class="ticket-content">
        <h1>Inloggen</h1>
        <form method="POST" action="/login">
            {!! csrf_field() !!}
            <table>
                @if (!empty($errors))
                    <tr>
                        @foreach ($errors->all() as $error)
                            <td style="color:red;">{{ $error }}</td>
                        @endforeach
                    </tr>
                @endif

                <tr>
                    <td><input type="text" name="email" placeholder="Emailadres" ></td>
                </tr>
                <tr>
                    <td><input type="password" name="password" placeholder="Wachtwoord" ></td>
                </tr>
                <tr>
                    <td><input class="submitregistration" type="submit" name="login" value="Inloggen" ></td>
                </tr>
            </table>
        </form>
    </div>
    <div class="clear">

    </div>
<?php } ?>
@endsection

