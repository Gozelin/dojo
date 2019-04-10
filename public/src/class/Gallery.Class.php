<?php

require_once("Image.Class.php");

class cGallery {

	/*
	ATTRIBUTS
	*/

	//int
	protected $_id = NULL;

	//string
	protected $_name = NULL;

	//object array
	protected $_image = [];

	/*
	ACCESSORS
	*/

	public function getId() { return $this->_id; }
	public function setId(int $value) { $this->_id = $value; }

	public function getName() { return $this->_name; }
	public function setName($value) { $this->_name = $value; }

	public function getImage() { return $this->_image; }
	public function setImage(array $value) { $this->_image = $value; }

	/*
	CONSTRUCTOR
	*/

	public function __construct($details = NULL) {
		if($details !== NULL && !is_array($details))
		{
			$details = intval($details);
			$this->import($details);
		}
		if(is_array($details))
		{
			if($details != NULL)
			{
				foreach($details as $key => $detail)
				{
					switch(strtolower($key))
					{
						case "id":
							$this->_id = $detail;
							break;
						case "name":
							$this->_name = $detail;
							break;
						case "image":
							$this->_image = $detail;
							break;
					}
				}
			}
		}
	}

	/*
	** DATABASE FUNCTIONS
	*/

	/*
	IMPORT
	*/

	public function import($id) {
		global $dataBase;

		$id = $dataBase->protect($id, _INT_);

		$query = "SELECT * FROM gallery WHERE id = $id";
		$data = $dataBase->query($query, FETCH_ARRAY);

		$this->_id =	$dataBase->unprotect($data["id"], _INT_);
		$this->_name =  $dataBase->unprotect($data["name"], _STRING_);
		$this->_image = $dataBase->unprotect($data["image"], _ARRAY_);

		if (is_array($this->_image)) {
			for($i=0;$i<count($this->_image);$i++) {
				$this->_image[$i] = $dataBase->unprotect($this->_image[$i]);
				$this->_image[$i] = new cImage($this->_image[$i]);
			}
		}
		return (TRUE);
	}

	/*
	INSERT
	*/

	public function insert() {
		global $dataBase;

		foreach ($this->_image as $key => $img) {
			$img->insert();
			$this->_image[$key] = $img->getId();
		}

		if (!$this->_name)
			$this->_name = "gallery";

		$ga_id =	$dataBase->protect($this->_id, _INT_);
		$ga_name =  $dataBase->protect($this->_name, _STRING_);
		$ga_image = $dataBase->protect($this->_image, _ARRAY_);

		$query = "INSERT INTO gallery (name, image) VALUES ($ga_name, $ga_image)";

		$dataBase->query($query);

		$this->_id = $dataBase->insert_id;

		return ($this->_id);
	}

	/*
	UPDATE
	*/

	public function update() {
		global $dataBase;

		foreach ($this->_image as $key => $img) {
			if (is_object($img)) {
				if ($img->getId() == NULL)
					$img->insert();
				else
					$img->update();
				$this->_image[$key] = $img->getId();
			}
		}

		$ga_id =	$dataBase->protect($this->_id, _INT_);
		$ga_name =  $dataBase->protect($this->_name, _STRING_);
		$ga_image = $dataBase->protect($this->_image, _ARRAY_);

		$query = "UPDATE gallery SET name = $ga_name, image = $ga_image WHERE id = $ga_id";
		$dataBase->query($query);
	}

	public function delete() {
		global $dataBase;

		$ga_id = $dataBase->protect($this->_id, _INT_);

		$query = "DELETE FROM gallery WHERE id = $ga_id";

		if (is_array($this->_image)) {
			foreach ($this->_image as $key => $img) {
				$img->delete();
			}
		}
		return ($dataBase->query($query));
	}

	/*
	** PUBLIC FUNCTIONS
	*/

	public function addImage($img = NULL) {
		if ($this->_image == NULL)
			$this->_image = array();
		if ($img != NULL && is_object($img) && get_class($img) == "cImage") {
			array_push($this->_image, $img);
		}
	}

	public function deleteImage($id) {
		if (is_array($this->_image)) {
			foreach ($this->_image as $key => $img) {
				if ($img->getId() == $id) {
					$this->_image[$key]->delete();
					unset($this->_image[$key]);
				}
			}
			$this->_image = array_values($this->_image);
		}
	}

	public function getForm() {
		$str = "";

		$str .= "<div class='gForm-wrapper'>";
		$str .= "<ul>";
		$str .= "<input class='g-id' value='".$this->_id."' type='hidden'>";
		$str .= "<input class='g-name' type='hidden' value='".$this->_name."'>";
		if (!is_numeric($this->_id)) {
			$str .= "<input id='addImage' class='fileInput' name='addImage' multiple type='file'>";
			$str .= "<label class='fileInputLabel' for='addImage'><h2>Ajouter</h2></label>";
		}
		else {
			foreach ($this->_image as $key => $img) {
				$str .= $img->getFormPreview();
			}
			$str .= "<input id='insertImage' class='fileInput' name='insertImage' multiple type='file'></label>";
			$str .= "<label class='fileInputLabel' for='insertImage'><h2>Ajouter</h2></label>";
		}
		$str .= "</ul>";
		$str .= "<div style='display: none' class='img-form'></div>"; // not displayed
		$str .= "</div>";
		return ($str);
	}

	public function getDisplay($mod = 0, $name = 'undefined') {
		$str = "";

		$hide = $mod ? "display: none;" : "";

		$str .= "<div class='g-displayWrapper' style='".$hide."'>";
		if (is_array($this->_image)) {
			foreach ($this->_image as $key => $img) {
				$str .= $img->getDisplay(0, $name);
			}
		}
		$str .= "</div>";
		return ($str);
	}
}

?>