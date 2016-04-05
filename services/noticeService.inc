<?php
	
	require_once('../models/dbTransactionalModel.inc');
	require_once('../models/notice.inc');

	class NoticeService extends Transactional {

		public $objNotice;
		public $listNotices;
		public $totalNotices;

		function __construct(){
			$this->objNotice = new Notice();
			$this->listNotices = array();
			$this->totalNotices = 0;
		}

		private function getTotalResults($sectionId, $status, $query){
			$this->query = "CALL sp_get_total_notices (".$sectionId.", '".$status."', '".$query."')";
			$this->getResultFromQuery();
			if(count($this->rows) == 1){
				foreach ($this->rows[0] as $propiedad=>$valor) {
					$this->totalNotices = $valor;
				}
			}
		}


		public function search($query, $sectionId, $status, $offset){
			
			$this->getTotalResults($sectionId, $status, $query);
			$this->rows = array();
			$this->query = "CALL sp_get_search_notice ('".$query."', ".$sectionId.", '".$status."', ".TAMANIO_DE_PAGINA.", ".$offset.")";
			$this->getResultFromQuery();

			$this->pushListNotice();
		}

		public function getNotice($idNotice){
			$this->rows = array();
			$this->objNotice = new Notice();
			$this->listNotices = array();

			$this->query = "CALL sp_get_nota (".$idNotice.")";
			$this->getResultFromQuery();

			$this->pushListNotice();

		}

		public function setNotice($seccionId, $title, $summary, $urlImgListado, $urlImgInterior, $status, $userId, $urlDocumentType, $documentType){
			$this->rows = array();
			$this->objNotice = new Notice();
			$this->listNotices = array();

			$this->query = "CALL sp_set_nota ('".$title."','','".$summary."', ".$seccionId.", '".$status."', ".$userId.", '".$urlImgListado."', '".$urlImgInterior."', '', '".$urlDocumentType."','".$documentType."')";
			
			$this->getResultFromQuery();

			$this->pushListNotice();
		}

		public function editNotice($id, $seccionId, $title, $summary, $urlImgListado, $urlImgInterior, $userId, $urlDocumentType, $documentType){
			
			$this->rows = array();
			$this->objNotice = new Notice();
			$this->listNotices = array();

			$this->query = "CALL sp_edit_nota (".$id.",'".$title."','','".$summary."', ".$seccionId.", ".$userId.", '".$urlImgListado."', '".$urlImgInterior."', '', '".$urlDocumentType."','".$documentType."')";
			
			$this->getResultFromQuery();

			$this->pushListNotice();
		}

		private function pushListNotice(){

			if(count($this->rows) > 0){
					$listNotices = array();
					$index = 0;
					foreach ($this->rows as $registro){
						$this->objNotice = new Notice();
						foreach ($registro as $propiedad => $valor) {
							$this->objNotice->$propiedad = $valor;							
						}
						$this->listNotices[$index] = ($this->objNotice);
						$index ++;						
					}
				$this->message = 'Registro encontrado';
			} else {
				$this->message = 'No existen el registro';
			}
		}

		public function get(){}
		public function set(){}
		public function edit(){}
		public function delete(){}
		
		function __destruct(){
			unset($this);
		}


	}
?>
