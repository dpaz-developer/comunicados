
<?php
  require_once('../controllers/noticeController.php');
  require_once('../views/procesaViews.inc');
  require_once('../functions/functions.inc');

  $sectionId  = isset($_GET['s']) ? $_GET['s'] : 1 ;
  $query    = isset($_GET['q']) ? $_GET['q'] : '' ;
  $offset   = isset($_GET['offset'])? $_GET['offset'] : 0;

  $objNoticeController = new NoticeController();
  $objNoticeController->searchBySection($query, $sectionId, $offset);
  $numPages = calculateNumberPages($objNoticeController->objNoticeService->totalNotices);
  

?>


    <?php include '../taglibs/head.inc'; ?>
    <?php include '../taglibs/header.inc'; ?>

<?php
    
    if ($objNoticeController->objNoticeService->totalNotices > 0 ) {

    $primernoticia = 0;
    $primerRenglon = 0;
    foreach ($objNoticeController->objNoticeService->listNotices as $notice){
      $objNotice = new Notice();
      foreach ($notice as $propiedad => $valor) {
        $objNotice->$propiedad = $valor;
      }
      if ($primernoticia == 0){

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
          echo   '</div>';
          echo   '    <hr>';

          echo createPagination($objNoticeController->objNoticeService->totalNotices, $offset); 
           

          echo   '<br>';

          $numNoticiasSinNotaPrincipal = $objNoticeController->objNoticeService->totalNotices - 1;
          if( $numNoticiasSinNotaPrincipal%2 == 0){
            $numNoticiasSinNotaPrincipal = $numNoticiasSinNotaPrincipal + 1;
          }

      }else{

          if($primerRenglon == 0){
            echo   '<div class="row">';
          } else{

            if ( $numNoticiasSinNotaPrincipal%2 != 0 ){
                echo   '<hr class="division_notas_listado"><div class="row">';
            }
          }

          echo   '  <div class="col-xs-6 col-lg-6 ">';
          echo   '    <div class="sub_noticia"> <a href="nota.php?id='.$objNotice->id.'">';
          echo   '     <img class="notice_secondary_image" src="'.$objNotice->urlImageMain.'"/>';
          echo   '       <div class="noticia_secondary_summary">';
          echo   '         <h3>'.truncateString($objNotice->title, 47).'</h3>';
          echo   '            <small> '.getTimeDate(substr($objNotice->dateRegistration, 0, 10)).'</small>';
          echo   '          <p>';
          echo   '           '.truncateString($objNotice->summary, 117).'</p>';          
          echo   '       </div>';
          echo   '       </a>';
          echo   '    </div>';
          echo   '  </div><!--/.col-xs-6.col-lg-4-->';

          if ( $numNoticiasSinNotaPrincipal%2 == 0 ){
              echo '</div><!--/row-->';
              $primerRenglon ++;
          }
          
          $numNoticiasSinNotaPrincipal = $numNoticiasSinNotaPrincipal -1;
      }
        $primernoticia ++;
    }
     

     echo createPagination($objNoticeController->objNoticeService->totalNotices, $offset); 

  }else{?>
    
        <br><br>
        <div class="alert alert-danger" role="alert">No hay notas para mostrar en la secci&oacuten</div>        

  <?php } ?>

    <?php include '../taglibs/footer.inc'; ?>
    <?php include '../taglibs/scripts.inc'; ?>
  </body>
</html>
