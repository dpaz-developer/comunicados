<?php
	echo 'aqui vamos a crear una noticia';

	$path_images = '../2016/images/test/';

	if (!is_dir($path_images)){
	if(!mkdir($path_images,0777, true)){
		die('Valio quesadillas y no creo la carpeta');
	}
	}else{
		echo "El directorio ya existe";
	}

	$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
	$limite_kb = 1000000;
	$nameMainImage = "img_main_".rand(0, 1000);

	if($_FILES['inputMainImage']['size']>$limite_kb){
		die("el archivo pesa mas de 1MB");
	}else{
		if(!in_array($_FILES['inputMainImage']['type'], $permitidos)){
			echo "el archivo no es una imagen";
		}else{
		

			$images_path = $path_images;//.basename($_FILES['inputMainImage']['name']);
			
			$extensionFile = explode(".", strtolower($_FILES['inputMainImage']['name']))[1];

			if (copy($_FILES['inputMainImage']['tmp_name'], $images_path.$nameMainImage.".".$extensionFile)){

					echo "el archivo ".$_FILES['inputMainImage']['name']."ah sido subido";

			}else{
				echo "Ocurrio un error y no se subio el archivo";
			}
			
		}
	}

	echo "<br>lo que tiene el editor es <br><br>";
	echo $_POST['editor'];

	

?>
