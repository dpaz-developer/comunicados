<?php
	require_once('../services/noticeService.inc');
	require_once('../views/procesaViews.inc');

	class NoticeController {
		public $objNoticeService;

		function __construct(){
			$this->objNoticeService = new NoticeService();
		}

		public function searchBySection($query, $sectionId, $offset){
			$this->objNoticeService->search($query,$sectionId, 'active',$offset);
		}
		
		public function getNotice($noticeId){
			$this->objNoticeService->getNotice($noticeId);
		}

		public function setNotice($seccionId, $title, $summary, $urlImgListado, $urlImgInterior, $status, $userId){
			$this->objNoticeService->setNotice($seccionId, $title, $summary, $urlImgListado, $urlImgInterior, $status, $userId);
		}
		public function  editNotice($id, $seccionId, $title, $summary, $urlImgListado, $urlImgInterior, $userId){
			$this->objNoticeService->editNotice($id, $seccionId, $title, $summary, $urlImgListado, $urlImgInterior, $userId);
		}

		

		function __destruct(){
			unset($this);
		}


	}	

?>
