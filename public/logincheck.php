<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<?php
echo "penis";
session_start();
	$query = "SELECT * FROM users WHERE email = ".$_POST['email'];
	$result = mysqli_query($daLink, $query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $amount = count($data) - 1;
	
	$DBPass = $data[$i]['password'];
	$DBSalt = $data[$i]['salt'];
	$password			= isset($_SESSION['POST']['password']) ? $_SESSION['POST']['password'] : '';
	$hashedPassword		= hash('sha512', $password.$DBSalt);
	
	if($amount == 0 && $hashedPassword == $DBPass){
		$_SESSION['login'] = true; 
		header("Location: http://nachtvancuijk.nl/DEV/public");
	} else {
		$_SESSION['LoginErr'] = '<br /><p style="color: red;">Dit email adres is niet bekend</p>';
		header("Location: http://nachtvancuijk.nl/DEV/public/login");	
	}
?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>