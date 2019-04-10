<?php

class cCategorie {

	//int
	protected $_id = NULL;

	//string
	protected $_name = NULL;

	//string
	protected $_desc = NULL;

	//array
	protected $_descDelta = NULL;

	//string
	protected $_color = NULL;

	//string
	protected $_image = NULL;


	public function getId() { return $this->_id; }
	public function setId(int $value) { $this->_id = $value; }

	public function getName() { return $this->_name; }
	public function setName($value) { $this->_name = $value; }

	public function getDesc() {
		return str_replace('"', "'", htmlspecialchars_decode($this->_desc));
	}
	public function setDesc($value) { $this->_desc = $value; }

	public function getDescDelta() { return $this->_descDelta; }
	public function setDescDelta($value) { $this->_descDelta = $value; }

	public function getColor() { return $this->_color; }
	public function setColor($value) { $this->_color = $value; }

	public function getImage() { return (!$this->_image) ? "default.jpg" : $this->_image; }
	public function setImage( $value) { $this->_image = $value; }

	public function __construct($details = NULL)
	{
		if(!is_array($details))
		{
			$details = intval($details);
			$this->import($details);
		} else {
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
						case "desc":
							$this->_desc = $detail;
							break;
						case "descdelta":
							$this->_descDelta = $detail;
							break;
						case "color":
							$this->_color = $detail;
							break;
						case "image":
							$this->_image = $detail;
							break;
					}
				}
			}
		}
	}


	public function import($id)
	{
		global $dataBase;

		$query = "SELECT * FROM categorie WHERE id = $id";
		$data = $dataBase->query($query, FETCH_ARRAY);

		$this->_id = $dataBase->unprotect($data["id"], _INT_);
		$this->_name = $dataBase->unprotect($data["name"], _STRING_);
		$this->_desc = $dataBase->unprotect($data["Ddesc"], _STRING_);
		$this->_descDelta = $dataBase->unprotect($data["Ddesc_delta"], _ARRAY_);
		$this->_color = $dataBase->unprotect($data["color"], _STRING_);
		$this->_image = $dataBase->unprotect($data["image"], _STRING_);

	}

	public function insert()
	{
		global $dataBase;

		$ca_id = 			$dataBase->protect($this->_id, _INT_);
		$ca_name = 			$dataBase->protect($this->_name, _STRING_);
		$ca_desc = 			$dataBase->protect($this->_desc, _STRING_);
		$ca_descDelta = 	$dataBase->protect($this->_descDelta, _ARRAY_);
		$ca_color = 		$dataBase->protect($this->_color, _STRING_);
		$ca_image = 		$dataBase->protect($this->_image, _STRING_);


		$query = "INSERT INTO categorie (name, Ddesc, Ddesc_delta, color, image)
		VALUES ($ca_name, $ca_desc, $ca_descDelta, $ca_color, $ca_image)";
		$dataBase->query($query);

		echo $query;

		$last_id = $dataBase->insert_id;

		return $last_id;
	}

	public function update()
	{
		global $dataBase;

		$ca_id = 			$dataBase->protect($this->_id, _INT_);
		$ca_name = 			$dataBase->protect($this->_name, _STRING_);
		$ca_desc = 			$dataBase->protect($this->_desc, _STRING_);
		$ca_descDelta = 	$dataBase->protect($this->_descDelta, _ARRAY_);
		$ca_color = 		$dataBase->protect($this->_color, _STRING_);
		$ca_image = 		$dataBase->protect($this->_image, _STRING_);

		$query = "
		UPDATE categorie
		SET name = $ca_name, Ddesc = $ca_desc, Ddesc_delta = $ca_descDelta, color = $ca_color, image = $ca_image
		WHERE $ca_id = id";
		$dataBase->query($query);
	}

	public function delete()
	{
		global $dataBase;

		$ca_id = $dataBase->protect($this->_id, _INT_);

		$query = "DELETE FROM categorie WHERE id = $ca_id";

		$res = $dataBase->query($query);

		$this->deleteDisciplines();
		$this->deleteImage();

		return $res;
	}

	public function getDisciplines() {
		$arr = [];
		$discs =  getAllDiscs();
		foreach($discs as $d) {
			if ($d->getCateg() == $this->_id)
				array_push($arr, $d);
		}
		return ($arr);
	}

	public function getDiscLink() {
		$discs = $this->getDisciplines();
		$str = "<div class='discLink-wrapper'>";
		foreach($discs as $d) {
			$str .= "<a class='disc-link' href='categ.php?id=".$this->getId()."&dId=".$d->getId()."'><h2>".$d->getName()."</h2></a>";
		}
		$str .= "</div>";
		return ($str);
	}

	private function deleteDisciplines()
	{
		$discs = getAllDiscs();
		foreach ($discs as $key => $disc) {
			$categ = $disc->getCateg();
			if($categ == $this->_id)
			{
				$disc->delete();
			}
		}
	}

	private function deleteImage()
	{
		$imgName = $this->_image[$imgNo];
		unlink(PATH_DOJO."pages/images/categorie/$imgName");
	}

	/*
		HTML GENERATION
	*/

	public function getForm($mod = NULL) {
		$str = "";

		$str .= "<div id='categ-form-box' class='form-popup undisplayed'>
		<form id='categ-form' method='POST' enctype='multipart/form-data'>
			<input type='hidden' name='id' value='".$this->_id."'>
			<input type='hidden' name='desc' class='quillInput'>
			<input type='hidden' name='descDelta' class='quillInput'>
			<input type='text' name='name' placeholder='Intitulé' value='".$this->_name."'/>";
		$str .= getQuill("desc");
		$str .= $this->getFileForm($mod);
		if ($mod)
			$str .= "<div id='upload-btn' class='update'>UPLOAD</div>";
		else
			$str .= "<div id='upload-btn' class='insert'>INSERT</div>";
		$str .= "</form>
				<div class='close-btn'><img src='../../public/pages/images/icon/cross.svg'></div>";
		return ($str);
	}

	public function getBox() {
		$str = "";

		$str .= "	<li data-id=".$this->_id." id='".$this->_name."' class='categ item-box ui-widget-content'>
						<h1 class='item-title'>".$this->_name."</h1>
						<div class='button-box'>
							<h3 class='button-title modif-btn'>modif</h3>
							<form method='POST' action='../src/categ/supprCateg.php'>
								<input type='hidden' name='id' value='".$this->_id."'></input>
								<input type='submit' value='suppr' class='button-title suppr-btn'></input>
							</form>
						</div>
					</li>";
		return ($str);
	}

	private function getFileForm($mod = NULL) {
		$str = "";
		$path = "";
		if ($mod)
			$path = "/dojo/public/pages/images/categ/".$this->_image;
		$str .= "<div class='file-input-container'>
					<div class='file-input-box'>
						<h3>image home</h3>
						<label for='categ-image-slider' class='label-file'>Choisir une image</label>
						<input id='categ-image-slider' class='input-file' type='file' name='image'/>
						<div class='image-preview'><img height='200px' width='200px' src='".$path."'></div>
					</div>
				</div>";
		return ($str);
	}
}