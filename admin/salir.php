<?php
	
	session_start();

	function closeSession(){
		session_destroy();
	}

	closeSession();

	header("Location:../admin");

	
?>