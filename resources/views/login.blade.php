@extends('layouts.main')

@section('title', 'Login')

@section('content')
<style>
#ticket {
	/*background-color:  hsla(0, 0%, 100%, 0.7);*/
	color: white;
	font-size: 24px;
}
#barcode {
	max-width: 400px;
}
</style>
<?php
session_start();
if(isset($_SESSION['POST'])) {
	require_once __DIR__ . '/mail.php';
	//$Salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
	
	//$password			= isset($_SESSION['POST']['password']) ? $_SESSION['POST']['password'] : '';
	//$hashedPassword		= hash('sha512', $password);
	$naam				= isset($_SESSION['POST']['naam']) ? $_SESSION['POST']['naam'] : '';
	$email				= isset($_SESSION['POST']['email']) ? $_SESSION['POST']['email'] : '';
	$ticket				= isset($_SESSION['POST']['ticket']) ? $_SESSION['POST']['ticket'] : '';
	$vestiging			= isset($_SESSION['POST']['ovnummer']) ? $_SESSION['POST']['ovnummer'] : '';
	$donatie			= isset($_SESSION['POST']['donatie']) ? $_SESSION['POST']['donatie'] : '0';
	$comp1				= isset($_SESSION['POST']['comp1']) ? $_SESSION['POST']['comp1'] : '';
	$comp2				= isset($_SESSION['POST']['comp2']) ? $_SESSION['POST']['comp2'] : '';
	$comp3				= isset($_SESSION['POST']['comp3']) ? $_SESSION['POST']['comp3'] : '';
	
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
	
	$barcode = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
	$_SESSION['POST']['ean'] = $barcode;
	
	$host = "localhost";
	$username = "root";
	$password = "";
	$dbname = "homestead";
	$link = new mysqli($host, $username, $password, $dbname);
	
	//$link = new mysqli("localhost", "website", "wTDNK6B5dvPnyLDX", "homestead");
	
	//insert de users
	$query = "INSERT INTO users (name, ovnummer, email, barcode, donatie, ticket, comp1, comp2, comp3) VALUES ('$naam', '$vestiging', '$email', '$barcode', '$donatie', '$ticket', '$comp1', '$comp2', '$comp3') ";
	$link->query($query);
	
	echo "<div id='ticket'><h2>je ticket is aangemaakt</h2><br />";
	echo "naam: $naam <br />leerlingnummer: $vestiging <br /> ticket: $ticket <br /><br />EAN: $barcode <br />";
	echo '<img id="barcode" src="./barcode/sample-gd.php?ean='.$barcode.'" /></div>';
	
	mailTicket();
	
	var_dump($query);
	
	//session_destroy();
	
	//header("Location: http://nachtvancuijk.nl/");
	//exit;
	
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

