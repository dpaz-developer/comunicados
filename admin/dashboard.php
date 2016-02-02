<?php
	session_start();

	if(!$_SESSION['userId']){
		header("Location:index.php");
	}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
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

  <body>

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
            
            <input class="btn btn-success" type="button" value="Crear">
            <input class="btn btn-warning" type="button" value="Editar">
            <input class="btn btn-danger" type="button" value="Eliminar">

          </div>

          <h2 class="sub-header">Crear noticia</h2>
          <div class="table-responsive">
           	<div class="panel panel-default">
			  <div class="panel-body">
			    <form class="form-horizontal" action="xt_creaNoticia.php" Method="POST" enctype="multipart/form-data">
				  <div class="form-group">
				    <label for="inputSection" class="col-sm-2 control-label">Seccion</label>
				    <div class="col-sm-10">
				      	<select name="inputSeccionId" class="form-control">
						  <option value="1">Avisos</option>
						  <option value="2">Lo que tenemos que cumplir</option>
						  <option value="3">Lo que queremos comunicar</option>
						  <option value="4">Lo que queremos saber</option>
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
				    <label class="col-sm-2 control-label">Imagen Principal</label>
				    <div class="col-sm-10">
				      <input type="file" name="inputMainImage" class="form-control" id="inputMainImage" >
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-2 control-label">Imagen Detalle</label>
				    <div class="col-sm-10">
				      <input type="file" name="inputDetailImage" class="form-control" id="inputTitle" placeholder="detalleImage">
				    </div>
				  </div>
				  <div class="form-group">
				    <label  class="col-sm-2 control-label">Resumen</label>
				    <div class="col-sm-10">
				      <textarea name="inputSummary" class="form-control" rows="3"></textarea>
				    </div>
				  </div>
				  <div class="form-group">
				    <label  class="col-sm-2 control-label">Detalle</label>
				    <div class="col-sm-10">
				      	<textarea name="editor" id="editor" rows="10" cols="80">
			                
			            </textarea>
			            
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
        </div>
      </div>
    </div>
    <script src="ckeditor.js"></script>
	<script src="js/sample.js"></script>
	<script>
	initSample();
	</script>
  </body>
</html>

