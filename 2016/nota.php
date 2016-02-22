
<?php
  require_once('../controllers/noticeController.php');
  require_once('../views/procesaViews.inc');
  require_once('../functions/functions.inc');

  
  $noticeId  = isset($_GET['id']) ? $_GET['id'] : 0 ;


  $objNoticeController = new NoticeController();
  $objNoticeController->getNotice($noticeId);

  $objNotice = new Notice();


  foreach ($objNoticeController->objNoticeService->listNotices as $notice){
                foreach ($notice as $propiedad => $valor) {
                  $objNotice->$propiedad = $valor;
                }
  }

  $sectionId = $objNotice->sectionId ? $objNotice->sectionId : 1;

?>

  <?php include '../taglibs/head.inc'; ?>
  <?php include '../taglibs/header.inc'; ?>

      <?php
      if ($objNotice->id){ ?>
        <div id="detalle_nota">
        <div class="jumbotron">
          <p class="lead"><img  src="<?php echo $objNotice->urlImageDetail ?>"/>
            <!--Download documents -->
            <?php 
             $imageDoc = 'pdf.jpg';
             if (!empty($objNotice->urlDocumentAtach))  {
              echo '<div class="detalle_notice_header"> ';
              echo '    <div class="detalle_download_files">';
              echo '      <a href="">';
              echo '      <ul>';
              echo '        <li><span>Ver el documento.</span></li>';
              echo '        <li><img class="detalles_download_icono" src="images/iconos/'.$imageDoc.'" /></li>';
              echo '      </ul>';
              echo '      </a>';  
              echo '    </div>';
              echo '</div>';
            }
            ?>
          </p>
        </div>
        <div class="jumbotron">
          
          
          <!-- Fecha -->
          <div class="row">
            <div class="col-xs-6 col-lg-12 ">
              <div class="detalle_notice_header"> 
                  <div class="detalle_fecha">
                    <h4><small>[ <?php echo substr($objNotice->dateRegistration, 0, 10); ?>]</small></h4>                
                  </div>
               </div>
            </div><!--/.col-xs-6.col-lg-4-->         
          </div><!--/row-->

        </div> 
      </div>

      <?php  }else{ ?>   
          <br><br>       
          <div class="alert alert-danger" role="alert">La noticia solicitada no existe</div>
      <?php }
      ?>
    
    <?php include '../taglibs/footer.inc'; ?>
    <?php include '../taglibs/scripts.inc'; ?>
  </body>
</html>
