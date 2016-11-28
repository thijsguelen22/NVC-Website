@extends('layouts.main')

@section('title', 'Login')

@section('content')
<?php 
	session_start();
	include("./functions.php");
if(isset($_POST['aanmeldenDone'])) {
	$pass = isset($_POST['password']) ? $_POST['password'] : '';
	$_SESSION['passlenght'] = is_minlength($pass, 6);
	$_SESSION['pass'] = hash("sha256", isset($_POST['password']) ? $_POST['password'] : '');
	$_SESSION['pass2'] = hash("sha256", isset($_POST['password2']) ? $_POST['password2'] : '');
	$_SESSION['POST']['naam']		= $_POST['name'];
	$_SESSION['POST']['ovnummer']	= isset($_POST['vestiging']) ? $_POST['vestiging'] : '';
	$_SESSION['POST']['ticket']		= isset($_POST['ticket']) ? $_POST['ticket'] : '';
	$_SESSION['POST']['donatie']	= isset($_POST['donatie']) ? $_POST['donatie'] : '';
	$_SESSION['POST']['comp1']		= isset($_POST['comp1']) ? $_POST['comp1'] : '';
	$_SESSION['POST']['comp2']		= isset($_POST['comp2']) ? $_POST['comp2'] : '';
	$_SESSION['POST']['comp3']		= isset($_POST['comp3']) ? $_POST['comp3'] : '';
	if(empty($_SESSION['err'])) {
		$_SESSION['err'] = false;
	}
	if($_SESSION['err'] == false) {
		header("Location: ./confirm");
		exit;
	}
	include("./inc/regform.php");
} else {
include("./inc/regform.php");
}

?>
@endsection