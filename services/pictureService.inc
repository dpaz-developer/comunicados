<?php
	require_once('../models/picture.inc');

	class PictureService{
		public $objPicture;

		function __construct(){
			$this->objPicture = new Picture();
		}
	}
?>
