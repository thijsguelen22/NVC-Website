<?php
session_start();
$fn = $_GET['fn'];
$fn = isset($_GET['fn']) ? $_GET['fn'] : 'nope';
if($fn == "Team") {
	$form = "join";
} elseif($fn == "nope") {
	$form = "";
} else {
	$form = "create";
}
$str = $_GET['str'];
$_SESSION["f".$fn] = $str;
$_SESSION['teamnaam'] = isset($_GET['teamnaam']) ? $_GET['teamnaam'] : 'nope';
//echo $fn;
//echo $form;
header("Location: ../teams2?team=".$form);
exit;