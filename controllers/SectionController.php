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

?>

