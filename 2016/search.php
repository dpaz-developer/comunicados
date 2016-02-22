
<?php
  require_once('../controllers/noticeController.php');
  require_once('../views/procesaViews.inc');
  require_once('../functions/functions.inc');


  $sectionId = 0;
  $query    = isset($_GET['q']) ? $_GET['q'] : '' ;
  $offset   = isset($_GET['offset'])? $_GET['offset'] : 0;

  $objNoticeController = new NoticeController();
  $objNoticeController->searchBySection($query, $sectionId, $offset);
  $numPages = calculateNumberPages($objNoticeController->objNoticeService->totalNotices);
  

?>


    <?php include '../taglibs/head.inc'; ?>
    <?php include '../taglibs/header.inc'; ?>

    <div class="sub_noticia">

    <?php echo createPagination($objNoticeController->objNoticeService->totalNotices, $offset);  ?>

<?php
    
    if ($objNoticeController->objNoticeService->totalNotices > 0 ) {

    foreach ($objNoticeController->objNoticeService->listNotices as $notice){
      $objNotice = new Notice();
      foreach ($notice as $propiedad => $valor) {
        $objNotice->$propiedad = $valor;
      }

      echo   '<div class="row">';
      echo   '      <div class="col-md-12 noticia"> <a href="nota.php?id='.$objNotice->id.'">';
      echo   '        <div class="notice_image">';
      echo   '          <img src="'.$objNotice->urlImageMain.'"/>';
      echo   '        </div>';
      echo   '        <div class="notice_main_resumen">';
      echo   '          <h2 class="titulo_limitado">'.$objNotice->title.'</h2>';
      echo   '            <small> '.getTimeDate(substr($objNotice->dateRegistration, 0, 10)).'</small>';
      echo   '          <p>'.$objNotice->summary.'</p>';
      echo   '        </div> </a>';
      echo   '      </div>';
      echo   ' </div>';
      echo   '    <hr>';                
      
    }
  }else{ ?>
      <br><br>
      <div class="alert alert-danger" role="alert">No hay notas para mostrar :(</div>
  <?php } ?>

    <?php echo createPagination($objNoticeController->objNoticeService->totalNotices, $offset);  ?>      

    </div><!--/div sub_noticia-->  
   	<?php include '../taglibs/footer.inc'; ?>
    <?php include '../taglibs/scripts.inc'; ?>
  </body>
</html>

