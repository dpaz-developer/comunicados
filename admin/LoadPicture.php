<?php
	//echo 'http://localhost/comunicados/2016/images/noticias/vestimenta.jpg';


	$path_images = '../2016/images/test/';
	$path_web = 'http://localhost/comunicados/2016/images/test';

	if (!is_dir($path_images)){
		if(!mkdir($path_images,0777, true)){
			die('Ocurrio un problema al crear el directorio');
		}
	}

	$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png",);
	$limite_kb = 1000000;
	$nameMainImage = "img_main_".rand(0, 1000);


	if($_FILES['inputMainImage']['size']>$limite_kb){
		die("El tamaño del archivo es mayor de 1MB");
	}else{
		/*if(!in_array($_FILES['inputMainImage']['type'], $permitidos)){
			echo "El formato del archivo no representa una imagen";
		}else{*/
		
			$images_path = $path_images;//.basename($_FILES['inputMainImage']['name']);			
			$extensionFile = explode(".", strtolower($_FILES['inputMainImage']['name']))[1];

			if (copy($_FILES['inputMainImage']['tmp_name'], $images_path.$nameMainImage.".".$extensionFile)){

					//echo "el archivo ".$_FILES['inputMainImage']['name']."ah sido subido";
					echo $path_web.'/'.$nameMainImage.".".$extensionFile;

			}else{
				echo "Ocurrio un error y no se subio el archivo";
			}
			
		//}
	}

?>
