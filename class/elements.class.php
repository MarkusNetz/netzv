<?php
class HtmlObjectProperties {
	public $btnDeleteNonSmallScreen;
	public $btnDeleteSmallScreen;
	
	// Constructor
	function __construct(){
		$this -> setBtnDeleteNonSmallScreen("w3-hide-small w3-button w3-circle w3-right w3-white");
		$this -> setBtnDeleteSmallScreen("w3-mobile w3-hide-medium w3-hide-large w3-button w3-red");
	}
	
	/*
	*	Delete button, used mainly in CV presentation
	*	NON-small screens 
	*/
	public function setBtnDeleteNonSmallScreen( $newVal ){
		$this -> btnDeleteNonSmallScreen = $newVal;
	}
	public function getBtnDeleteNonSmallScreen(){
		return $this -> btnDeleteNonSmallScreen;
	}
	
	// Small screens.
	public function setBtnDeleteSmallScreen( $newVal ){
		$this -> btnDeleteSmallScreen = $newVal;
	}
	public function getBtnDeleteSmallScreen(){
		return $this -> btnDeleteSmallScreen;
	}
}