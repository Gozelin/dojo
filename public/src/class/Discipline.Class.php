<?php

class cDiscipline {

	/*
	ATTRIBUTS
	*/

	//int
	protected $_id = NULL;

	//string
	protected $_name = NULL;

	//string
	protected $_desc = NULL;

	//array
	protected $_descDelta = NULL;

	//array
	protected $_link = array();

	//string
	protected $_categ = NULL;

	//array(int)
	protected $_profs = array();

	//array(string)
	protected $_image = array();

	//string
	protected $_horaire = NULL;

	//string
	protected $_horaireDelta = NULL;

	/*
	ACCESSORS
	*/

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

	public function getLink() { return $this->_link; }
	public function setLink($value) { $this->_link = $value; }

	public function getCateg() { return $this->_categ; }
	public function setCateg($value) { $this->_categ = $value; }

	public function getProfs() { return $this->_profs; }
	public function setProfs(array $value) { $this->_profs = $value; }

	public function getImage() { return $this->_image; }
	public function setImage(array $value) { $this->_image = $value; }

	public function getHoraire() { return $this->_horaire; }
	public function setHoraire($val) { $this->_horaire = $val; }

	public function getHoraireDelta() { return $this->_horaireDelta; }
	public function setHoraireDelta($val) { $this->_horaireDelta = $val; }

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
						case "desc":
							$this->_desc = $detail;
							break;
						case "descdelta":
							$this->_descDelta = $detail;
							break;
						case "link":
							$this->_link = $detail;
							break;
						case "categ":
							$this->_categ = $detail;
							break;
						case "profs":
							$this->_profs = $detail;
							break;
						case "image":
							$this->_image = $detail;
							break;
						case "horaire":
							$this->_horaire = $detail;
							break;
						case "horairedelta":
							$this->_horaireDelta = $detail;
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

		$query = "SELECT * FROM discipline WHERE id = $id";
		$data = $dataBase->query($query, FETCH_ARRAY);

		$this->_id = $dataBase->unprotect($data["id"], _INT_);
		$this->_name = $dataBase->unprotect($data["name"], _STRING_);
		$this->_desc = $dataBase->unprotect($data["Ddesc"], _STRING_);
		$this->_descDelta = $dataBase->unprotect($data["Ddesc_delta"], _ARRAY_);
		$this->_link = $dataBase->unprotect($data["link"], _ARRAY_);
		$this->_categ = $dataBase->unprotect($data["categ"], _STRING_);
		$this->_profs = $dataBase->unprotect($data["profs"], _ARRAY_);
		$this->_image = $dataBase->unprotect($data["image"], _ARRAY_);
		$this->_horaire = $dataBase->unprotect($data["horaire"], _STRING_);
		$this->_horaireDelta = $dataBase->unprotect($data["horaireDelta"], _ARRAY_);

		for($i=0;$i<count($this->_image);$i++) {
			$this->_image[$i] = $dataBase->unprotect($this->_image[$i]);
		}
	}

	/*
	FUNCTION INSERT
	*/
	public function insert()
	{
		global $dataBase;

		$di_id = 			$dataBase->protect($this->_id, _INT_);
		$di_name = 			$dataBase->protect($this->_name, _STRING_);
		$di_desc = 			$dataBase->protect($this->_desc, _STRING_);
		$di_descDelta = 	$dataBase->protect($this->_descDelta, _ARRAY_);
		$di_link = 			$dataBase->protect($this->_link, _ARRAY_);
		$di_categ = 		$dataBase->protect($this->_categ, _STRING_);
		$di_profs = 		$dataBase->protect($this->_profs, _ARRAY_);
		$di_image = 		$dataBase->protect($this->_image, _ARRAY_);
		$di_horaire = 		$dataBase->protect($this->_horaire, _STRING_);
		$di_horaireDelta = 	$dataBase->protect($this->_horaireDelta, _ARRAY_);

		$query = "INSERT INTO discipline (name, Ddesc, Ddesc_delta, link, categ, profs, image, horaire, horaireDelta)
		VALUES ($di_name, $di_desc, $di_descDelta, $di_link, $di_categ, $di_profs, $di_image, $di_horaire, $di_horaireDelta)";
		$dataBase->query($query);

		echo $query;

		$last_id = $dataBase->insert_id;

		return $last_id;
	}

	/*
	FUNCTION UPDATE
	*/
	public function update()
	{
		global $dataBase;

		$di_id = 			$dataBase->protect($this->_id, _INT_);
		$di_name = 			$dataBase->protect($this->_name, _STRING_);
		$di_desc = 			$dataBase->protect($this->_desc, _STRING_);
		$di_descDelta = 	$dataBase->protect($this->_descDelta, _ARRAY_);
		$di_link = 			$dataBase->protect($this->_link, _ARRAY_);
		$di_categ = 		$dataBase->protect($this->_categ, _STRING_);
		$di_profs = 		$dataBase->protect($this->_profs, _ARRAY_);
		$di_image = 		$dataBase->protect($this->_image, _ARRAY_);
		$di_horaire = 		$dataBase->protect($this->_horaire, _STRING_);
		$di_horaireDelta =	$dataBase->protect($this->_horaireDelta, _ARRAY_);

		$query = "
		UPDATE discipline
		SET name = $di_name, Ddesc = $di_desc, Ddesc_delta = $di_descDelta, link = $di_link, categ =$di_categ, profs = $di_profs, image = $di_image, horaire = $di_horaire, horaireDelta = $di_horaireDelta
		WHERE id = $di_id";
		$dataBase->query($query);
		echo $query;
	}

	/*
	FUNCTION DELETE
	*/
	public function delete()
	{
		global $dataBase;

		$di_id = $dataBase->protect($this->_id, _INT_);

		$query = "DELETE FROM discipline WHERE id = $di_id";

		$res = $dataBase->query($query);

		$this->deleteFromProfs();
		$this->deleteImage();

		return $res;
	}

	//supprime une image, si pas de param, supprime TOUTE les images
	public function deleteImage($imgNo = NULL)
	{
		if($imgNo !== NULL)
		{
			$imgName = $this->_image[$imgNo];
			unlink(PATH_DOJO."pages/images/discipline/$imgName");
		}
		else
		{
			foreach ($this->_image as $key => $img)
			{
				unlink(PATH_DOJO."pages/images/discipline/$img");
			}
		}
	}

	public function deleteFromProfs()
	{
		foreach ($this->_profs as $key => $profId) {
			$prof = new cProf($profId);
			$discs = $prof->getDisc();
			foreach ($discs as $key => $disc) {
				if($disc == $this->_id)
				{
					$key = array_search($disc, $discs);
					unset($discs[$key]);
				}
			}
			$prof->setDisc($discs);
			$prof->update();
		}
	}
}

?>