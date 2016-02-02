<?php
	
	function getTemplate($nameTemplate='index'){
		$file = '../site_media/html/'.$nameTemplate.'.html';
		return file_get_contents($file);
	}

	function renderDinamicData($html, $data){
		foreach ($data as $key => $value) {
			$html  = str_replace('{'.$key.'}', $value, $html);
		}
		return $html;
	}

	function retornarVista($vista, $data=array()) {		
		$html = getTemplate($vista);
		$html = renderDinamicData($html, $data);
		print $html;
	}

?>
