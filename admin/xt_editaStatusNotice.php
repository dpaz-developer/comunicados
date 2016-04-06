<?php

	require_once('../controllers/noticeController.php');
  	require_once('../functions/functions.inc');

  	$noticeId 		= isset($_GET['noticeId']) ? $_GET['noticeId']: 0;
  	$status 		= isset($_GET['status']) ? $_GET['status']:'' ;
	

	
	$objNoticeController = new NoticeController();
  	$objNoticeController->editStatusNotice($noticeId, $status);

	

	$url_redirect = 'dashboard.php?searchid='.$noticeId;
	header('Location:'.$url_redirect);
	
	
	

?>
