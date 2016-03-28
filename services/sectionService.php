<?php
	
	require_once('../models/dbTransactionalModel.inc');
	require_once('../models/section.php');

	class SectionService extends Transactional {

		public $obj_section;
		public $list_sections = array();
		
		public function __construct(){
			$this->obj_section = new Section();
		}

		function __destruct() {
			unset($this);
		}

		public function getAll(){

			$this->query = "CALL sp_get_sections ()";
			$this->getResultFromQuery();	
			if(count($this->rows) > 0){
					$list_sections = array();
					$index = 0;
					foreach ($this->rows as $registro){
						$this->obj_section = new Section();
						foreach ($registro as $propiedad => $valor) {
							$this->obj_section->$propiedad = $valor;							
						}
						$this->list_sections[$index] = ($this->obj_section);
						$index ++;						
					}
				$this->message = 'Registro encontrado';
			} else {
				$this->message = 'No existen el registro';
			}

		}

		public function get($sectionName=''){

			$this->query = "SELECT * FROM sections WHERE section = '$sectionName' ";
			$this->getResultFromQuery();	
			if(count($this->rows) == 1){
				foreach ($this->rows[0] as $propiedad => $valor) {
					$this->obj_section->$propiedad = $valor;
				}
				$this->message = 'Registro encontrado';
			} else {
				$this->message = 'No existen el registro';
			}

		}

		public function set(){

		}
		public function edit(){

		}
		public function delete(){

		}
	}

?>
