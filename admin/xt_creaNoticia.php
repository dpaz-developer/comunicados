<?php

	require_once('../controllers/noticeController.php');
  	require_once('../functions/functions.inc');

  	$seccionId 			= $_POST['inputSeccionId'];
	$title 				= $_POST['inputTitle'];
	$summary 			= $_POST['inputSummary'];
	$urlImgListado 		= $_POST['picListado'];
	$urlImgInterior 	= $_POST['picInterior'];
	$status				= 'deactive';
	$userId				= 1;
	$urlDocumentType	= $_POST['urlDocument'];
	$documentType 		= $_POST['documentType'];
	
	$objNoticeController = new NoticeController();
  	$objNoticeController->setNotice($seccionId, $title, $summary, $urlImgListado, $urlImgInterior, $status, $userId,$urlDocumentType, $documentType);

  	$objNotice = new Notice();


  	foreach ($objNoticeController->objNoticeService->listNotices as $notice){
                foreach ($notice as $propiedad => $valor) {
                  $objNotice->$propiedad = $valor;
                }
  	}


	

	//echo '<br>La noticia creada fue'.$objNotice->id;
	$url_redirect = 'dashboard.php?searchid='.$objNotice->id;
	header('Location:'.$url_redirect);
	
	/*echo '<br><b>seccion_id:</b>'.$objNotice->id;
	

	echo '<br><b>titulo:</b>'.$title;
	echo '<br><b>resumen:</b>'.$summary;
	echo '<br><b>imagen_listado:</b> <br> <img src="'.$urlImgListado.'" />';
	echo '<br><b>imagen_principal:</b><br> <img src="'.$urlImgInterior.'" />'
	*/
	

?>
