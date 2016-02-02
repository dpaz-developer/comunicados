<?php
	require_once('../services/sectionService.php');

	class SectionController {

		public $obj_section_service;

		public function __construct(){
			$this->obj_section_service = new SectionService();
		}

		public function getSection(){
			$this->obj_section_service->get('avisosss');
			
		}

		public function getAllSections(){
			$this->obj_section_service->getAll();
		}
	}

	$obj_section_controller = new SectionController();

	$obj_section_controller->getSection();
	echo "Las propiedades son: <br>".$obj_section_controller->obj_section_service->message;
	echo "<br>-".$obj_section_controller->obj_section_service->obj_section->id;
	echo "<br>-".$obj_section_controller->obj_section_service->obj_section->section;
	echo "<br>-".$obj_section_controller->obj_section_service->obj_section->status;
	echo "<br>-".$obj_section_controller->obj_section_service->obj_section->dateRegistration;

	$obj_section_controller->getAllSections();

	echo "<br> Los datos son ".count($obj_section_controller->obj_section_service->list_sections);
	foreach ($obj_section_controller->obj_section_service->list_sections as $section){
						#echo ",".$registro->id;
						echo "<br>".count($section);
						foreach ($section as $propiedad => $valor) {
							echo "<br>****desdeController--".$propiedad."-".$valor;
						}
	}
   
	#foreach ($sectionService->data as $clave=>$valor){
	#	echo "<br>".$clave."-".$valor;
	#}
?>

