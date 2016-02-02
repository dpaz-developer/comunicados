<?php
	session_start();

	function createSession($user, $pass){

		if($user == 'david.paz@marti.com.mx' && $pass == '123'){	
			$_SESSION['userId'] = 1;
		}

	}

	$email = $_POST['email'];
	$pass = $_POST['pass'];
	
	createSession($email, $pass);

	if($_SESSION['userId']){
		header("Location:../admin/dashboard.php");
	}else{
		header("Location:index.php?e=error");
	}

?>
