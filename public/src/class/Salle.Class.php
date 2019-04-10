<?php

require_once("Gallery.Class.php");

class cSalle {

	/*
	ATTRIBUT
	*/

	//int
	protected $_id = NULL;

	//string
	protected $_name = NULL;

	//string
	protected $_desc = NULL;

	//array
	protected $_descDelta = NULL;

	//int
	protected $_gal = NULL;

	/*
	ACCESSORS
	*/

	public function getName() { return ($this->_name); }
	public function setName($val) { $this->_name = $val; } 
	public function getDesc() { return str_replace('"', "'", htmlspecialchars_decode($this->_desc)); }
	public function setDesc($val) { $this->_desc = $val; }
	public function getDescDelta() { return ($this->_descDelta); }
	public function setDescDelta($val) { $this->_descDelta = $val; }

	/*
	CONSTRUCTOR
	*/

	public function __construct($details = NULL)
	{
		if (is_array($details)) {
			foreach ($details as $key => $detail) {
				$key = "_".$key;
				if (property_exists("cSalle", $key)) {
					$this->$key = $detail;
				}
			}
		} else if (is_numeric($details))
			$this->import($details);
	}

	/*
	DATABASE FUNCTIONS
	*/

	public function import($id) {
		global $dataBase;

		$id = $dataBase->protect($id, _INT_);

		$query = "SELECT * FROM salle WHERE id = $id";
		$data = $dataBase->query($query, FETCH_ARRAY);

		$this->_id = $dataBase->unprotect($data["id"], _INT_);
		$this->_name = $dataBase->unprotect($data["Sname"], _STRING_);
		$this->_desc = $dataBase->unprotect($data["Sdesc"], _STRING_);
		$this->_descDelta = $dataBase->unprotect($data["Sdesc_delta"], _ARRAY_);
		$this->_gal = $dataBase->unprotect($data["gal"], _INT_);

		return(TRUE);
	}

	public function insert() {
		global $dataBase;

		$sa_name = $dataBase->protect($this->_name, _STRING_);
		$sa_desc = $dataBase->protect($this->_desc, _STRING_);
		$sa_descDelta = $dataBase->protect($this->_descDelta, _ARRAY_);
		$sa_gal = $dataBase->protect($this->_gal, _INT_);

		$query = "INSERT INTO salle (Sname, Sdesc, Sdesc_delta, gal) VALUES ($sa_name, $sa_desc, $sa_descDelta, $sa_gal)";

		if (!$dataBase->query($query))
			echo $query;

		return ($dataBase->insert_id);
	}

	public function update() {
		global $dataBase;

		$sa_name = $dataBase->protect($this->_name, _STRING_);
		$sa_id = $dataBase->protect($this->_id, _INT_);
		$sa_desc = $dataBase->protect($this->_desc, _STRING_);
		$sa_descDelta = $dataBase->protect($this->_descDelta, _ARRAY_);
		$sa_gal = $dataBase->protect($this->_gal, _INT_);

		$query = "  UPDATE salle
					SET Sname = $sa_name, Sdesc = $sa_desc, Sdesc_delta = $sa_descDelta, gal = $sa_gal
					WHERE id = $sa_id";

		$dataBase->query($query);

		return (TRUE);
	}

	public function delete() {
		global $dataBase;

		$g = new cGallery($this->_gal);
		$g->delete();

		$sa_id = $dataBase->protect($this->_id, _INT_);
		$query = "DELETE FROM salle WHERE id = $sa_id";

		echo $query;

		$dataBase->query($query);

		return (TRUE);
	}

	/*
	HTML GENERATION FUNCTIONS
	*/

	public function getForm($mod = 0) {
		$str = "";

		if (isset($this->_gal))
			$g = new cGallery($this->_gal);

		$str .= "<div id='salle-form-box' class='form-popup undisplayed'>";
		$str .= "<form id='salle-form'>";
		if ($mod == 1)
			$str .= "<input type='hidden' name='id' value='".$this->_id."'>";
		$str .= "<input type='hidden' name='desc' class='quillInput'>";
		$str .= "<input type='hidden' name='descDelta'>";
		$str .= "<input type='text' name='name' value='" . (($mod) ? $this->_name : "") . "'>";
		$str .= getQuill('desc');
		if ($mod)
			$str .= "<div id='upload-btn' class='update'>UPLOAD</div>";
		else
			$str .= "<div id='upload-btn' class='insert'>INSERT</div>";
		$str .= "</form>";
		$str .=  "<div class='close-btn'><img src='../../public/pages/images/icon/cross.svg'></div>";
		if ($mod)
			$str .= $g->getForm();
		$str .= "</div>";
		return ($str);
	}

	public function getBox() {
		$str = "";

		$str .= "<li data-id='".$this->_id."' id='".$this->_name."' class='salle item-box ui-widget-content'>
					<h1 class='item-title'>".$this->_name."</h1>
					<div class='button-box'>
						<h3 class='button-title modif-btn'>modif</h3>
						<form method='POST' action='../src/salle/supprSalle.php'>
							<input type='hidden' name='id' value='".$this->_id."'></input>
							<input type='submit' value='suppr' class='button-title suppr-btn'></input>
						</form>
					</div>
				</li>";

		return ($str);
	}

	public function getFront($color = "white") {
		$str = "";

		$g = new cGallery($this->_gal);
		$frontImg = $g->getImage();
		if (is_array($frontImg) && isset($frontImg[0]))
			$frontImg = $frontImg[0];
		else
			$frontImg = new cImage();
		$str .= "<div class='salle-wrapper' style='background-color: ".$color."'>";
		$str .= "<h2 class='salle-title'>".$this->_name."</h2>";
		$str .= "<div class='loc-content'>";
		$str .= "<img class='loc-frontImg' src='".$frontImg->getPath()."'>";
		$str .= "<div class='salle-desc'>".$this->getDesc()."<h3 class='pic-link'>Voir les photos</h3></div>";
		$str .= $g->getDisplay(1, $this->_name);
		$str .= "</div></div>";

		return ($str);
	}
}

?>