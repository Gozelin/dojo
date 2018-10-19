<?php

class cPost {

	/*
	ATTRIBUTS
	*/
	
	//int
	protected $_id = NULL;
	
	//string
	protected $_title = NULL;

	//string
	protected $_type = NULL;

	//string
	protected $_time = NULL;
	
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
	
	public function getTitle() { return $this->_title; }
	public function setTitle($value) { $this->_title = $value; }

	public function getType() { return $this->_type; }
	public function setType($value) { $this->_type = $value; }

	public function getTime() { return $this->_time; }
	public function setTime($value) { $this->_time = $value; }
	
	public function getDesc() { return $this->_desc; }
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
						case "title":
							$this->_title = $detail;
							break;
						case "type":
							$this->_type = $detail;
							break;
						case "time":
							$this->_time = $detail;
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

		$query = "SELECT * FROM post WHERE id = $id";
		$data = $dataBase->query($query, FETCH_ARRAY);

		$this->_id = 			$dataBase->unprotect($data["id"], _INT_);
		$this->_title = 		$dataBase->unprotect($data["title"], _STRING_);
		$this->_type = 			$dataBase->unprotect($data["type"], _STRING_);
		$this->_time = 			$dataBase->unprotect($data["Ptime"], _STRING_);
		$this->_desc = 			$dataBase->unprotect($data["Pdesc"], _STRING_);
		$this->_descDelta =		$dataBase->unprotect($data["Pdesc_delta"], _ARRAY_);
		$this->_image = 		$dataBase->unprotect($data["image"],_ARRAY_);
	}

	/*
	FUNCTION INSERT
	*/
	public function insert()
	{
		global $dataBase;

		$po_id = 			$dataBase->protect($this->_id, _INT_);
		$po_title = 		$dataBase->protect($this->_title, _STRING_);
		$po_type = 			$dataBase->protect($this->_type, _STRING_);
		$po_time = 			$dataBase->protect($this->_time, _STRING_);
		$po_desc = 			$dataBase->protect($this->_desc, _STRING_);
		$po_descDelta = 	$dataBase->protect($this->_descDelta, _ARRAY_);
		$po_image = 		$dataBase->protect($this->_image, _ARRAY_);

		$query = "INSERT INTO post (title, type, Ptime, Pdesc, Pdesc_Delta, image)
		VALUES ($po_title, $po_type, $po_time, $po_desc, $po_descDelta, $po_image)";
		$dataBase->query($query);
		echo $query;
	}

	/*
	FUNCTION UPDATE
	*/
	public function update()
	{
		global $dataBase;

		$po_id = 			$dataBase->protect($this->_id, _INT_);
		$po_title = 		$dataBase->protect($this->_title, _STRING_);
		$po_type = 			$dataBase->protect($this->_type, _STRING_);
		$po_time = 			$dataBase->protect($this->_time, _STRING_);
		$po_desc = 			$dataBase->protect($this->_desc, _STRING_);
		$po_descDelta = 	$dataBase->protect($this->_descDelta, _ARRAY_);
		$po_image = 		$dataBase->protect($this->_image, _ARRAY_);

		$query = "
		UPDATE post
		SET title = $po_title, type = $po_type, Ptime = $po_time, Pdesc = $po_desc, Pdesc_Delta = $po_descDelta, image = $po_image
		WHERE $po_id = id";

		$dataBase->query($query);
			
		echo $query;	
	}

	/*
	FUNCTION DELETE
	*/
	public function delete()
	{
		global $dataBase;

		echo $this->_id;

		$po_id = $dataBase->protect($this->_id, _INT_);

		$query = "DELETE FROM post WHERE id = $po_id";

		echo $query;

		$dataBase->query($query);

		$this->deleteImage();

	}

	//supprime une image, si pas de param, supprime TOUTE les images
	public function deleteImage($imgNo = NULL)
	{
		if($imgNo !== NULL)
		{
			$imgName = $this->_image[$imgNo];
			unlink(PATH_DOJO."pages/images/posts/$imgName");
		}
		else
		{
			foreach ($this->_image as $key => $img)
			{
				unlink(PATH_DOJO."pages/images/posts/$img");
			}
		}
	}
}

?>