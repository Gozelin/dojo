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

	//array(string)
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
	public function setImage(array $value) { $this->_image = $value; }
	
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
		$this->_image = $dataBase->unprotect($data["image"],_ARRAY_);
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
		$pr_image = 		$dataBase->protect($this->_image, _ARRAY_);

		$query = "INSERT INTO prof (name, surname, Pdesc, Pdesc_Delta, image)
		VALUES ($pr_name, $pr_surname, $pr_desc, $pr_descDelta, $pr_image)";
		$dataBase->query($query);
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
		$pr_image = 		$dataBase->protect($this->_image, _ARRAY_);

		$query = "
		UPDATE prof
		SET name = $pr_name, surname = $pr_surname, Pdesc = $pr_desc, Pdesc_Delta = $pr_descDelta, image = $pr_image
		WHERE $pr_id = id";

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
		if($imgNo !== NULL)
		{
			$imgName = $this->_image[$imgNo];
			unlink(PATH_DOJO."pages/images/profs/$imgName");
		}
		else
		{
			foreach ($this->_image as $key => $img) 
			{
				unlink(PATH_DOJO."pages/images/profs/$img");
			}
		}
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
}

?>