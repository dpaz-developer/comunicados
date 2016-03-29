<?php
	session_start();
	require_once('../controllers/SectionController.php');
	require_once('../controllers/noticeController.php');
  	require_once('../functions/functions.inc');
	
	if(!$_SESSION['userId']){
		header("Location:index.php");
	}


	$obj_section_controller = new SectionController();

	$obj_section_controller->getAllSections();


	function getComboSections($obj_section){
		$result = "";
		foreach($obj_section->obj_section_service->list_sections as $section){
			foreach ($section as $key => $value) {
				if ($key == 'id'){
					$id = $value;
				}
				if ($key == 'section'){
					$result = $result.'<option value="'.$id.'">'.$value.'</option>';
				}	
			}
		}
		return $result;
	}


	function getComboSectionsSelect($obj_section, $sectionId){
		$result = "";
		foreach($obj_section->obj_section_service->list_sections as $section){
			foreach ($section as $key => $value) {
				if ($key == 'id'){
					$id = $value;
				}
				if ($key == 'section'){
					if($id==$sectionId){
						$result = $result.'<option value="'.$id.'" selected >'.$value.'</option>';
					}else{
						$result = $result.'<option value="'.$id.'">'.$value.'</option>';
					}
				}	
			}
		}
		return $result;
	}


	// obtenemos la noticia que queremos modificar
	$noticeId  =  isset($_GET['searchid']) ? $_GET['searchid'] : 0 ;

	if ($noticeId > 0) {
		$objNoticeController = new NoticeController();
	  	$objNoticeController->getNotice($noticeId);

	  	$objNotice = new Notice();


		foreach ($objNoticeController->objNoticeService->listNotices as $notice){
		                foreach ($notice as $propiedad => $valor) {
		                  $objNotice->$propiedad = $valor;
		                }
		}
	}


  	

  

   

?>


<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Admin noticias comunicados</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">    
    <link href="css/dashboard.css" rel="stylesheet">
  </head>

  <body ng-app="ComunicadosAdmin"  ng-controller="ComunicadosAdminController" >

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Admin - Comunicación interna</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="salir.php">Salir</a></li>
          </ul>
         
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Noticias <span class="sr-only">(current)</span></a></li>
          </ul>
        
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Noticias</h1>

          <div class="row placeholders">
            <input class="btn btn-success" type="button" data-toggle="modal" data-target="#myModalCreate" value="Crear">
            <input class="btn btn-warning" type="button" data-toggle="modal" data-target="#myModalSearch" value="Buscar">
          </div>

          	<?php if ($noticeId > 0 ) { ?>
		    <!-- Inicia el listado para administrar  las noticias creadas o buscadas -->
		    <div class="panel panel-default">
					  <div class="panel-body">
					  		
					  		<table class="table table-bordered">
		  						<tr>
		  							<th>Ppciones</th>
		  							<th>id</th>
		  							<th>Listado</th>
		  							<th>Titulo/Resumen</th>
		  						</tr>
		  						<tr>
		  							<?php  								
		  								echo '<td>';
			  							echo '	<ul>';
			  							echo '		<li><a href="Activar">Activar</a></li>';
			  							echo "		<li><a href=\"#\" ng-click=\"editNota('".$objNotice->urlImageMain."','".$objNotice->urlImageDetail."');\" data-toggle=\"modal\" data-target=\"#myModalEdit\" >Modificar</a></li>";
			  							echo '		<li><a href="#"  data-toggle="modal" data-target="#myModal">Ver Imagen</a></li>';
			  							echo '	</ul>';
			  							echo '</td>';
		  								echo '<td>'.$objNotice->id.'</td>';
			  							echo '<td><img src="'.$objNotice->urlImageMain.'"/></td>';
			  							echo '<td><b>'.$objNotice->title.'</b><br>'.$objNotice->summary.'</td>';
			  							
		  							?>
		  						</tr>
							</table>
					  </div>
			</div>
		    <!-- Termina el listado para administrar las noticias creadas o buscadas -->
		    <?php }?>


        <!-- Crear noticia modal -->
        <div class="modal fade" id="myModalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      		<div class="modal-dialog modal-lg" role="document">
        	<div class="modal-content">
          		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            		<h2 class="modal-title" id="myModalLabel">Crear noticia</h2>
          		</div>
          		<div class="modal-body">
			   <!-- inicia el formulario de creacion de notticias -->
			          <div class="table-responsive" ng-show="true">
			           	<div class="panel panel-default">
						  <div class="panel-body">

						  	<div class="form-group input-group-lg">
								
							  		 <div class="array_pictures">
				                        <div class="fileUpload btn_foto">
									  		<label>Listado</label>
						                    <input id="picture_0" class="upload" type="file" ng-file-select="onFileSelect($files,0)" multiple accept="image/*" data-multiple="true">
						                    <img ng-show="urlPic[0] != null" ng-src="{{urlPic[0]}}" class="img-rounded">
						                    
						                </div>
						                <div class="fileUpload btn_foto">
									  		<label>Interior</label>
						                    <input id="picture_1" class="upload" type="file" ng-file-select="onFileSelect($files,1)" multiple accept="image/*" data-multiple="true">
						                    <img ng-show="urlPic[1] != null" ng-src="{{urlPic[1]}}" class="img-rounded">
						                    
						                </div>
						            </div>
					        	
			                </div>


						    <form class="form-horizontal" action="xt_creaNoticia.php" Method="POST" enctype="multipart/form-data">
						    	<input type="hidden" name="picListado" value="{{urlPic[0]}}"/>
						    	<input type="hidden" name="picInterior" value="{{urlPic[1]}}"/>
							  <div class="form-group">
							    <label for="inputSection" class="col-sm-2 control-label">Seccion</label>
							    <div class="col-sm-10">
							      	<select name="inputSeccionId" class="form-control">
									  <?php
									  	echo getComboSections($obj_section_controller);
									  ?>
									</select>
							    </div>
							  </div>
							  <div class="form-group">
							    <label for="inputTitle" class="col-sm-2 control-label">Titulo</label>
							    <div class="col-sm-10">
							      <input type="text" name="inputTitle"  class="form-control" id="inputTitle" placeholder="Titulo">
							    </div>
							  </div>
							  <div class="form-group">
							    <label  class="col-sm-2 control-label">Resumen</label>
							    <div class="col-sm-10">
							      <textarea name="inputSummary" class="form-control" rows="3"></textarea>
							    </div>
							  </div>
							  <div class="form-group">
							    <div class="col-sm-offset-2 col-sm-10">
							      <button type="submit" class="btn btn-success">Crear</button>
							    </div>
							  </div>
							</form>				

						  </div>
						</div>

			          </div>
			    <!-- Termina el formulario de creacion de noticias -->
          		</div>
        	</div>
      		</div>
    	</div>

    	<!-- Buscar noticia modal -->
    	<div class="modal fade" id="myModalSearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      		<div class="modal-dialog modal-lg" role="document">
        	<div class="modal-content">
          		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            		<h2 class="modal-title" id="myModalLabel">Buscar nota</h2>
          		</div>
          		<div class="modal-body">
            		  <!-- hacemos formulario para buscar nota  -->

					    <div class="panel panel-default">
								  <div class="panel-body">
								  	<form class="form-inline" action="dashboard.php" Method="GET">
										  <div class="form-group">
										    <label class="sr-only" for="exampleInputPassword3">id de noticia:</label>
										    <input type="text" class="form-control" id="searchid" name="searchid" placeholder="">
										  </div>
										  <button type="submit" class="btn btn-default">Buscar</button>
									</form>	
								  </div>
						</div>

    					<!-- termina el formulario para buscar nota -->
          		</div>
        	</div>
      		</div>
    	</div>

    	<!-- Editar noticia modal -->
    	<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      		<div class="modal-dialog modal-lg" role="document">
        	<div class="modal-content">
          		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            		<h2 class="modal-title" id="myModalLabel">Editar nota</h2>
          		</div>
          		<div class="modal-body">
            		 <!-- Aqui dejamos el formulario para editar una nota -->

				    <div class="table-responsive" ng-show="true">
				           	<div class="panel panel-default">
							  <div class="panel-body">

							  	

							  	<div class="form-group input-group-lg">

								  		 <div class="array_pictures">
					                        <div class="fileUpload btn_foto">
										  		<label>Listado</label>
							                    <input id="picture_0" class="upload" type="file" ng-file-select="onFileSelect($files,0)" multiple accept="image/*" data-multiple="true">
							                    <img ng-show="urlPic[0] != ''" ng-src="{{urlPic[0]}}" class="img-rounded">
							                    <!-- <img ng-show="urlPic[0] == ''" ng-src="<?php echo $objNotice->urlImageMain; ?>" class="img-rounded"> -->
							                    
							                </div>
							                <div class="fileUpload btn_foto">
										  		<label>Interior</label>
							                    <input id="picture_1" class="upload" type="file" ng-file-select="onFileSelect($files,1)" multiple accept="image/*" data-multiple="true">
							                    <img ng-show="urlPic[1] != ''" ng-src="{{urlPic[1]}}" class="img-rounded">
							                    <!-- <img ng-show="urlPic[1] == ''" ng-src="<?php echo $objNotice->urlImageDetail; ?>" class="img-rounded"> -->
							                    
							                </div>
							            </div>
						        	
				                </div>


							    <form class="form-horizontal" action="xt_editaNoticia.php" Method="POST" enctype="multipart/form-data">
							    	
							    	<input type="hidden" name="picListado" value="{{urlPic[0]}}"/>							    	
							    	<input type="hidden" name="picInterior" value="{{urlPic[1]}}"/>					


							    	<input type="hidden" name="noticeId" value="<?php echo $objNotice->id; ?>">
								  <div class="form-group">
								    <label for="inputSection" class="col-sm-2 control-label">Seccion</label>
								    <div class="col-sm-10">
								      	<select name="inputSeccionId" class="form-control">
										  <?php
										  	echo getComboSectionsSelect($obj_section_controller, $objNotice->sectionId);
										  ?>
										</select>
								    </div>
								  </div>
								  <div class="form-group">
								    <label for="inputTitle" class="col-sm-2 control-label">Titulo</label>
								    <div class="col-sm-10">
								      <input type="text" name="inputTitle"  class="form-control" id="inputTitle" placeholder="Titulo" value="<?php echo $objNotice->title; ?>">
								    </div>
								  </div>
								  <div class="form-group">
								    <label  class="col-sm-2 control-label">Resumen</label>
								    <div class="col-sm-10">
								      <textarea name="inputSummary" class="form-control" rows="3" ><?php echo $objNotice->summary; ?></textarea>
								    </div>
								  </div>
								  <div class="form-group">
								    <div class="col-sm-offset-2 col-sm-10">
								      <button type="submit" class="btn btn-success">Editar</button>
								    </div>
								  </div>
								</form>				

							  </div>
							</div>

				          </div>

				    <!-- Termina el formulario para editar una nota -->
          		</div>
        	</div>
      		</div>
    	</div>


    <!-- modal de la imagen grande -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Imagen interior</h4>
          </div>
          <div class="modal-body">
            <?php
            echo '<img src="'.$objNotice->urlImageDetail.'" /> ';
            ?>
          </div>
        </div>
      </div>
    </div>
    <!-- termina el modal de la imagen grande -->




        </div>
      </div>
    </div>
    <script src="js/jquery.min.js"></script>

    <script src="ckeditor.js"></script>
	<script src="js/sample.js"></script>

	<script src="js/angular.min.js"></script>
	<script src="js/angular-resource.min.js"></script>
	<script src="js/underscore-min.js"></script>
	<script src="js/bootstrap.min.js"></script> 
	<script src="js/angular-file-upload.js"></script> 
	<script src="js/angular-file-upload-shim.js"></script> 

	<script src="js/app.js"></script>
	<script src="js/filters.js"></script> 
	<script src="js/controllers.js"></script>
	<script src="js/services.js"></script> 
	<script>
	initSample();
	</script>
  </body>
</html>

