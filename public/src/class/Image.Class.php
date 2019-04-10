<?php

class cImage {

	/*
	ATTRIBUTS
	*/

	//int
	protected $_id;

	//string
	protected $_name;

	//string
	protected $_path;

	//string
	protected $_tmppath;

	/*
	ACCESSORS
	*/

	public function getId() { return ($this->_id); }
	public function setId($val) { $this->_id = $val; }

	public function getName() { return ($this->_name); }
	public function setName($val) { $this->_name = $val; }

	public function getPath($abs = 0) {
		$path = ($abs) ? $_SERVER['DOCUMENT_ROOT'].$this->_path : $this->_path;
		return ($path);
	}
	public function setPath($val) { $this->_path = $val; }

	public function getTmppath() { return($this->_tmppath); }
	public function setTmppath($val) { $this->_tmppath = $val; }

	/*
	CONSTRUCTOR
	*/

	public function __construct($details = NULL) {
		if(!is_array($details))
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
						case "path":
							$this->_path = $detail;
						break;
						case "tmppath":
							$this->_tmppath = $detail;
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

		$query = "SELECT * FROM image WHERE id = $id";
		$data = $dataBase->query($query, FETCH_ARRAY);

		$this->_id =		$dataBase->unprotect($data["id"], _INT_);
		$this->_name =	$dataBase->unprotect($data["name"], _STRING_);
		$this->_path =	$dataBase->unprotect($data["path"], _STRING_);

		return (TRUE);
	}

	/*
	INSERT
	*/

	public function insert() {
		global $dataBase;

		$im_id =		$dataBase->protect($this->_id, _INT_);
		$im_name =	$dataBase->protect($this->_name, _STRING_);
		$im_path =	$dataBase->protect($this->_path, _STRING_);

		$query = "INSERT INTO image (name, path) VALUES($im_name, $im_path)";
		$dataBase->query($query);
		$this->_id = $dataBase->insert_id;
		return ($this->_id);
	}

	/*
	UPDATE
	*/

	public function update() {
		global $dataBase;

		$im_id =		$dataBase->protect($this->_id, _INT_);
		$im_name =	$dataBase->protect($this->_name, _STRING_);
		$im_path =	$dataBase->protect($this->_path, _STRING_);

		$query = "UPDATE image
		SET name = $im_name, path = $im_path, WHERE id = $im_id";
		$dataBase->query($query);
	}

	/*
	DELETE
	*/

	public function delete() {
		global $dataBase;

		$im_id = $dataBase->protect($this->_id, _INT_);

		$query = "DELETE FROM image WHERE id = $im_id";

		unlink($this->getPath(1));

		return ($dataBase->query($query));
	}

	/*
	** PUBLIC FUNCTIONS
	*/

	public function upload() {
		if (isset($this->_name) && isset($this->_path) && isset($this->_tmppath)) {
			$ext = explode('.', $this->_name);
			$ext = strtolower(end($ext));
			$fn = generateRandomString().".".$ext;
			$this->_path .= $fn;
			$abs_path = PATH_IMAGES."gallery/".$fn;
			if (!(move_uploaded_file($this->_tmppath, $abs_path)))
				return (FALSE);
			return (TRUE);
		}
	}

	public function getFormPreview() {
		$str = "";
		$str .= "<li id='img-".$this->_id."' class='img-wrapper ui-state-default'>";
		$str .= "<img src='".$this->_path."'>";
		$str .= "</li>";
		return ($str);
	}

	public function getForm() {
		$str = "";
		$str .= "<form id='imgForm-".$this->_id."' class='img-form'>";
		$str .= "<img src=".$this->getPath()." width='100%' height='30%'>";
		$str .= "</form>";
		return ($str);
	}

	public function getDisplay($mode, $name) {
		$str = "";
		switch ($mode) {
			case 0: {
				$str = $this->getDispGallery($name);
			break;
			}
		}
		return ($str);
	}

	/*
	** PRIVATE FUNCTIONS
	*/

	private function getDispGallery($name) {
		$str = "";
		$str .= "<a href='".$this->_path."' data-lightbox='$name'>";
		$str .= "<img class='gImage' src=".$this->_path.">";
		$str .= "</a>";
		return ($str);
	}
}

?>