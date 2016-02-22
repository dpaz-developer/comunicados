<?php

  function calculateNumberPages($totalItems){
    return ceil($totalItems/TAMANIO_DE_PAGINA);
  }
  function calculateOffset($numPage){
    return $numPage*TAMANIO_DE_PAGINA;
  }

  function getNameSection($sectionId){
    $name = '';
    switch ($sectionId) {
    case 1:
        $name = 'Avisos';
        break;
    case 2:
        $name = 'Lo que tenemos que cumplir';
        break;
    case 3:
        $name = 'Lo que queremos comunicar';
        break;
    case 4:
        $name = 'Lo que queremos saber';
        break;
    default:
    	$name = 'Resultados';
    	break;
    }
    return $name;
  }


  function getVarsUrl(){
  	$result = '';
  	$numero = count($_GET);
  	if ($numero>0){
  		$tags = array_keys($_GET);
  		$values = array_values($_GET);
  		for ($i=0; $i<$numero; $i++){
  			if($i!=0 && $tags[$i] != 'offset' ){
  				$result = $result.'&';
  			}

  			if($tags[$i] != 'offset'){
  			 $result = $result.$tags[$i].'='.$values[$i];
  			}
  		} 
  	}
  	return $result;
  }

  function getPreviewPage($currentPage){
  	$resultOffset = 0;
  	if($currentPage > 1){
  		$resultOffset = (($currentPage-1)*TAMANIO_DE_PAGINA)-TAMANIO_DE_PAGINA;
  	}
  	return $resultOffset;
  }
  function getNextPage($currentPage){
  	$resultOffset = (($currentPage-1)*TAMANIO_DE_PAGINA)+TAMANIO_DE_PAGINA;;
  	return $resultOffset;
  }

  function createPagination($totalItems, $offset){

    $result = '';
    if ($totalItems>0) {
    	$numPages = calculateNumberPages($totalItems);
    	$currentPage = ($offset/TAMANIO_DE_PAGINA)+1;
    	$inicioResultados = $offset+1;
    	$finResultados = ($currentPage*TAMANIO_DE_PAGINA > $totalItems) ? $totalItems : $currentPage*TAMANIO_DE_PAGINA;
    

  	if ($numPages > 1){

        $result = '<div id="search_paginacion">'.
            '<div>  Mostrando <b>'.$inicioResultados.'</b>  - <b>'.$finResultados.'</b>  de <b>'.$totalItems.'</b> resultados encontrados. </div>';

      	$result = $result.'<nav>'.
  		  '<ul class="pagination pagination-sm">';

  		$result = $result.'<li';
  		if ($currentPage-1 == 0){
  		    $result = $result.' class="disabled" ';
  		}
  		$result = $result.'><a href="?'.getVarsUrl().'&offset='.getPreviewPage($currentPage).'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
  		    
  		for ($i=0; $i<$numPages; $i++){
  			if (($i+1) == $currentPage){
  				$result = $result.'<li class="active"><a href="?'.getVarsUrl().'&offset='.(TAMANIO_DE_PAGINA*$i).'">'.($i+1).'</a></li>';
  			}else{
  				$result = $result.'<li><a href="?'.getVarsUrl().'&offset='.(TAMANIO_DE_PAGINA*$i).'">'.($i+1).'</a></li>';
  			}
  		}

  		 $result = $result.'<li';
  		 if ($currentPage+1 > $numPages){
  		 	$result = $result.' class="disabled" ';
  		 }
  		 $result = $result.'>'.
  		    '<a href="?'.getVarsUrl().'&offset='.getNextPage($currentPage).'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
  		  
  		$result = $result.'</ul>'.
  		'</nav>' ;   

        $result = $result.'</div>';  

  	}

  
  }
	return $result;
  }

  function truncateString($texto, $numChar){
    $result = $texto;
    $lenTexto = strlen($texto);
    if ($lenTexto>0){

       if($lenTexto>$numChar){
         $result = substr($texto, 0, $numChar).' ...';
       }
    }
    return $result;
  }

  function getTimeDate($fecha){
    $result =  "S/F";

    try{
      $result = date($fecha);
      $hoy = date('Y-m-d');

      $segundos= strtotime('now') - strtotime($result);
      $diferencia_dias=intval($segundos/60/60/24);

      if ($diferencia_dias==0){
        $result = 'Hoy';
      }

      if ($diferencia_dias>0){
        $result = 'Hace '.$diferencia_dias.' dias';
      }

      if ($diferencia_dias >= 7){
        $result = 'Hace 1 semana';
      }

      if ($diferencia_dias >= 14 ){
        $result = 'Hace 2 semana';
      }

      if ($diferencia_dias >= 28 ){
        $result = 'Hace 3 semana';
      }

      if ($diferencia_dias >= 30){
        $result = 'Hace 1 mes';
      }

      if ($diferencia_dias > 40){
        $result = 'Hace mas de 1 mes';
      }
    }catch(Exception $e){
      $result="date_error";
    }

    return $result;
  }

?>
