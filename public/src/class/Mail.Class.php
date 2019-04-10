<?php

require_once("JsonHelper.Class.php");

class cMail extends cJsonHelper {

	/*
	ATTRIBUTS
	*/

	//string
	protected $_name = NULL;

	//string
	protected $_usermail = NULL;

	//string
	protected $_object = NULL;

	//string
	protected $_mail = NULL;

	//string
	protected $_date = NULL;

	//int
	protected $_read = 0;

	public function getName() { return($this->_name); }

	public function __construct($details) {
		if (is_array($details)) {
			foreach ($details as $key => $detail) {
				$key = "_".$key;
				if (property_exists("cMail", $key))
					$this->$key = htmlspecialchars(htmlentities($detail));
			}
			$this->_date = date("Y/m/d H:i:s");
		} else if (is_numeric($details)) {
			$this->importJson($details);
			$arr = get_object_vars($this);
			foreach ($arr as $key => $attr) {
				$this->$key = html_entity_decode($attr);
			}
		}
	}

	public function getHTML() {
		$str = "";

		$str .= "<div id='".$this->getJsonId()."' class='mailWrapper'>";
		$str .= 	"<div class='mail-del-btn'></div>";
		$str .= 	"<div class='mail-preview'>";
		$str .= 		"<h3 class='mail-date'>".$this->_date."<h3>";
		$str .= 		"<h3 class='mail-usermail'>".$this->_usermail."</h3>";
		$str .= 		"<h3 class='mail-object'>".$this->_object."</h3>";
		$str .= 		"<h3 class='mail-name'>".$this->_name."</h3>";
		$str .=		"</div>";
		$str .= 	"<div class='mail-content'>";
		$str .= 		"<p class='mail-mail'>".$this->_mail."</p>";
		$str .= 	"</div>";
		$str .= "</div>";

		return ($str);
	}
}

?>