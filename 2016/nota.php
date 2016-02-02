
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
          <h1><?php echo $objNotice->title ?></h1>
          <p class="lead"><img  src="http://blogsportcity.com.mx/wp-content/uploads/2016/01/Servicios-SC.jpg"/></p>
        </div>
        <div class="jumbotron">
          <div class="row">
            <div class="col-xs-6 col-lg-12 ">
             <div class="detalle_notice_header">
                <h3><?php echo $objNotice->title ?> <small>[ <?php echo date_format(new DateTime($objNotice->dateRegistration), 'd/m/y'); ?> ]</small></h3> 
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" src="<?php echo $objNotice->urlImageMain ?>" alt="...">
                    </div>
                    <div class="media-body">
                      <p><?php echo $objNotice->summary ?> <?php echo $objNotice->summary ?> </p>
                    </div>
                </div>
              </div>
            </div><!--/.col-xs-6.col-lg-4-->         
          </div><!--/row-->
          <div class="row">
            <div class="col-xs-6 col-lg-12 ">
              <div class="detalle_notice_header"> 
                   <p><?php echo $objNotice->body?></p>                
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
