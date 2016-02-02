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

		function __destruct(){
			unset($this);
		}


	}	

?>
