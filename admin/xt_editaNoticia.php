<?php

	require_once('../controllers/noticeController.php');
  	require_once('../functions/functions.inc');

  	$noticeId 		= $_POST['noticeId'];
  	$seccionId 		= $_POST['inputSeccionId'];
	$title 			= $_POST['inputTitle'];
	$summary 		= $_POST['inputSummary'];
	$urlImgListado 	= $_POST['picListado'];
	$urlImgInterior = $_POST['picInterior'];
	$status			= 'deactive';
	$userId			= 1;

	echo '<br> Los datos a modificar';
	echo '<br>'.$noticeId;
	echo '<br>'.$seccionId;
	echo '<br>'.$title;
	echo '<br>'.$summary;
	echo '<br>'.$urlImgListado;
	echo '<br>'.$urlImgInterior;
	echo '<br>'.$status;
	echo '<br>'.$userId;
	
	
	/*
	$objNoticeController = new NoticeController();
  	$objNoticeController->editNotice($noticeId, $seccionId, $title, $summary, $urlImgListado, $urlImgInterior,  $userId);

  	$objNotice = new Notice();


  	foreach ($objNoticeController->objNoticeService->listNotices as $notice){
                foreach ($notice as $propiedad => $valor) {
                  $objNotice->$propiedad = $valor;
                }
  	}


	

	$url_redirect = 'dashboard.php?searchid='.$objNotice->id;
	header('Location:'.$url_redirect);
	*/
	
	

?>
