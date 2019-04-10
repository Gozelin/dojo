<?php

class cProf {

	/*
	ATTRIBUTS
	*/
	
	//int
	protected $_id = NULL;
	
	//string
	protected $_name = NULL;

	//string
	protected $_surname = NULL;
	
	//string
	protected $_desc = NULL;

	//array(int)
	protected $_descDelta = array();

	//string
	protected $_image = array();
	
	/*
	ACCESSORS
	*/
	
	public function getId() { return $this->_id; }
	public function setId(int $value) { $this->_id = $value; }
	
	public function getName() { return $this->_name; }
	public function setName($value) { $this->_name = $value; }

	public function getSurname() { return $this->_surname; }
	public function setSurname($value) { $this->_surname = $value; }
	
	public function getDesc() {
		return str_replace('"', "'", htmlspecialchars_decode($this->_desc));
	}
	public function setDesc($value) { $this->_desc = $value; }

	public function getDescDelta() { return $this->_descDelta; }
	public function setDescDelta($value) { $this->_descDelta = $value; }

	public function getImage() { return $this->_image; }
	public function setImage($value) { $this->_image = $value; }
	
	/*
	CONSTRUCTOR
	*/
	
	public function __construct($details = NULL)
	{
		//importe l'objet depuis la BDD grâce à l'ID
		if(!is_array($details))
		{
			$details = intval($details);
			$this->import($details);
		}
	
		//ou créé l'objet à partir des données en array
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
						case "surname":
							$this->_surname = $detail;
							break;
						case "desc":
							$this->_desc = $detail;
							break;
						case "descdelta":
							$this->_descDelta = $detail;
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
	FUNCTION IMPORT
	*/
	public function import($id)
	{
		global $dataBase;

		$id = $dataBase->protect($id, _INT_);

		$query = "SELECT * FROM prof WHERE id = $id";
		$data = $dataBase->query($query, FETCH_ARRAY);

		$this->_id = $dataBase->unprotect($data["id"], _INT_);
		$this->_name = $dataBase->unprotect($data["name"], _STRING_);
		$this->_surname = $dataBase->unprotect($data["surname"], _STRING_);
		$this->_desc = $dataBase->unprotect($data["Pdesc"], _STRING_);
		$this->_descDelta = $dataBase->unprotect($data["Pdesc_delta"], _ARRAY_);
		$this->_image = $dataBase->unprotect($data["image"],_STRING_);
	}

	/*
	FUNCTION INSERT
	*/
	public function insert()
	{
		global $dataBase;

		$pr_id = 			$dataBase->protect($this->_id, _INT_);
		$pr_name = 			$dataBase->protect($this->_name, _STRING_);
		$pr_surname = 		$dataBase->protect($this->_surname, _STRING_);
		$pr_desc = 			$dataBase->protect($this->_desc, _STRING_);
		$pr_descDelta = 	$dataBase->protect($this->_descDelta, _ARRAY_);
		$pr_image = 		$dataBase->protect($this->_image, _STRING_);

		$query = "INSERT INTO prof (name, surname, Pdesc, Pdesc_Delta, image)
		VALUES ($pr_name, $pr_surname, $pr_desc, $pr_descDelta, $pr_image)";
		echo $dataBase->query($query);
	}

	/*
	FUNCTION UPDATE
	*/
	public function update()
	{
		global $dataBase;

		$pr_id = 			$dataBase->protect($this->_id, _INT_);
		$pr_name = 			$dataBase->protect($this->_name, _STRING_);
		$pr_surname = 		$dataBase->protect($this->_surname, _STRING_);
		$pr_desc = 			$dataBase->protect($this->_desc, _STRING_);
		$pr_descDelta = 	$dataBase->protect($this->_descDelta, _ARRAY_);
		$pr_image = 		$dataBase->protect($this->_image, _STRING_);

		$query = "
			UPDATE prof
			SET name = $pr_name, surname = $pr_surname, Pdesc = $pr_desc, Pdesc_Delta = $pr_descDelta, image = $pr_image
			WHERE id = $pr_id ";

		$dataBase->query($query);
			
		echo $query;	
	}

	/*
	FUNCTION DELETE
	*/
	public function delete()
	{
		global $dataBase;

		$pr_id = $dataBase->protect($this->_id, _INT_);

		$query = "DELETE FROM prof WHERE id = $pr_id";

		$dataBase->query($query);

		$this->deleteFromDisc();

		$this->deleteImage();

	}

	//supprime une image, si pas de param, supprime TOUTE les images
	public function deleteImage($imgNo = NULL)
	{
		if(isset($this->_image))
			unlink(PATH_DOJO."pages/images/profs/$this->_image");
	}

	public function deleteFromDisc()
	{
		$discs = getAllDiscs();
		foreach ($discs as $key => $disc) {
			$profs = $disc->getProfs();
			foreach ($profs as $key => $prof) {
				if($prof == $this->_id)
				{
					$key = array_search($prof, $profs);
					unset($profs[$key]);
				}
			}
			$disc->setProfs($profs);
			$disc->update();
		}
	}

	/*
	HTML GENERATION FUNCTIONS
	*/

	public function getForm($mod = NULL) {
		$str = "";

		$str .= "<div id='prof-form-box' class='form-popup undisplayed'>
				<form id='prof-form' method='POST' enctype='multipart/form-data'>
					<input type='hidden' name='id' value=".$this->_id.">
					<input type='hidden' name='desc' class='quillInput'>
					<input type='hidden' name='descDelta' class='quillInput'>
					<input type='text' name='name' placeholder='prénom' value='".$this->_name."' />
					<input type='text' name='surname' placeholder='nom' value='".$this->_surname."'/>";
		$str .= getQuill('desc');
		$str .=		"<div class='file-input-container'>
						<div class='file-input-box'>
							<label for='prof-image' class='label-file'>Choisir une image</label>
							<input id='prof-image' class='input-file' type='file' name='image'/>
							<div class='image-preview'><img width='200px' height='200px' src='/dojo/public/pages/images/prof/".$this->_image."'></div>
						</div>
					</div>";
		if ($mod)
			$str .= "<div id='upload-btn' class='update'>UPLOAD</div>";
		else
			$str .= "<div id='upload-btn' class='insert'>INSERT</div>";
		$str .=	"</form>
				<div class='close-btn'><img src='../../public/pages/images/icon/cross.svg'></div>
				</div>";
		return ($str);
	}

	public function getBox() {
		$str = "";

		$str .= "<div data-id='".$this->_id."' id='".$this->_name."' class='prof item-box'>
					<img class='prof-image' src='../../public/pages/images/prof/".$this->_image."'>
					<h1 class='item-title'>".$this->_name." ".$this->_surname."</h1>
					<div class='button-box'>
						<h3 class='button-title modif-btn'>modif</h3>
						<form method='POST' action='../src/prof/supprProf.php'>
							<input type='hidden' name='id' value='".$this->_id."'></input>
							<input type='submit' value='suppr' class='button-title suppr-btn'></input>
						</form>
					</div>
				</div>";

		return ($str);
	}
}

?>