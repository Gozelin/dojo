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
	protected $_video = array();

	//string
	protected $_categ = NULL;

	//array(int)
	protected $_profs = array();

	//string
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

	public function getVideo() { return $this->_video; }
	public function setVideo($value) { $this->_video = $value; }
	public function addVideo($value) { array_push($this->_video, $value); }
	public function deleteVideo($value) {
		if (($key = array_search($value, $this->_video)) !== false) {
			unset($this->_video[$key]);
		}
	}

	public function getCateg() { return $this->_categ; }
	public function setCateg($value) { $this->_categ = $value; }

	public function getProfs() { return $this->_profs; }
	public function setProfs(array $value) { $this->_profs = $value; }

	public function getImage() { return $this->_image; }
	public function setImage($value) { $this->_image = $value; }

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
						case "video":
							$this->_video = $detail;
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

		$this->_id =			$dataBase->unprotect($data["id"], _INT_);
		$this->_name =			$dataBase->unprotect($data["name"], _STRING_);
		$this->_desc =			$dataBase->unprotect($data["Ddesc"], _STRING_);
		$this->_descDelta = 	$dataBase->unprotect($data["Ddesc_delta"], _ARRAY_);
		$this->_video = 		$dataBase->unprotect($data["video"], _ARRAY_);
		$this->_categ = 		$dataBase->unprotect($data["categ"], _STRING_);
		$this->_profs =			$dataBase->unprotect($data["profs"], _ARRAY_);
		$this->_image = 		$dataBase->unprotect($data["image"], _STRING_);
		$this->_horaire = 		$dataBase->unprotect($data["horaire"], _STRING_);
		$this->_horaireDelta = 	$dataBase->unprotect($data["horaireDelta"], _ARRAY_);
		if (is_array($this->_image)) {
			for($i=0;$i<count($this->_image);$i++) {
				$this->_image[$i] = $dataBase->unprotect($this->_image[$i]);
			}
		}
		return (TRUE);
	}

	/*
	FUNCTION INSERT
	*/
	public function insert()
	{
		global $dataBase;

		//convert associative array to simple array
		$this->_video = array_values($this->_video);

		$di_id = 			$dataBase->protect($this->_id, _INT_);
		$di_name = 			$dataBase->protect($this->_name, _STRING_);
		$di_desc = 			$dataBase->protect($this->_desc, _STRING_);
		$di_descDelta = 	$dataBase->protect($this->_descDelta, _ARRAY_);
		$di_video = 		$dataBase->protect($this->_video, _ARRAY_);
		$di_categ = 		$dataBase->protect($this->_categ, _STRING_);
		$di_profs = 		$dataBase->protect($this->_profs, _ARRAY_);
		$di_image = 		$dataBase->protect($this->_image, _STRING_);
		$di_horaire = 		$dataBase->protect($this->_horaire, _STRING_);
		$di_horaireDelta = 	$dataBase->protect($this->_horaireDelta, _ARRAY_);

		if (!$this->checkBeforeUpload())
			return (0);

		$query = "INSERT INTO discipline (name, Ddesc, Ddesc_delta, video, categ, profs, image, horaire, horaireDelta)
		VALUES ($di_name, $di_desc, $di_descDelta, $di_video, $di_categ, $di_profs, $di_image, $di_horaire, $di_horaireDelta)";

		$dataBase->query($query);

		return ($dataBase->insert_id);
	}

	/*
	FUNCTION UPDATE
	*/
	public function update()
	{
		global $dataBase;

		//convert associative array to simple array
		$this->_video = array_values($this->_video);

		$di_id = 			$dataBase->protect($this->_id, _INT_);
		$di_name = 			$dataBase->protect($this->_name, _STRING_);
		$di_desc = 			$dataBase->protect($this->_desc, _STRING_);
		$di_descDelta = 	$dataBase->protect($this->_descDelta, _ARRAY_);
		$di_video = 		$dataBase->protect($this->_video, _ARRAY_);
		$di_categ = 		$dataBase->protect($this->_categ, _STRING_);
		$di_profs = 		$dataBase->protect($this->_profs, _ARRAY_);
		$di_image = 		$dataBase->protect($this->_image, _STRING_);
		$di_horaire = 		$dataBase->protect($this->_horaire, _STRING_);
		$di_horaireDelta =	$dataBase->protect($this->_horaireDelta, _ARRAY_);

		if (!$this->checkBeforeUpload())
			return (0);

		$query = "
		UPDATE discipline
		SET name = $di_name, Ddesc = $di_desc, Ddesc_delta = $di_descDelta, video = $di_video, categ =$di_categ, profs = $di_profs, image = $di_image, horaire = $di_horaire, horaireDelta = $di_horaireDelta
		WHERE id = $di_id";

		$dataBase->query($query);

		return (1);
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
	public function deleteImage()
	{
		if (isset($this->_image))
			unlink(PATH_IMAGES."discipline/".$this->_image);
	}

	public function deleteFromProfs()
	{
		if (isset($this->_profs) && !empty($this->_profs)) {
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

	/*
	PRIVATE FUNCTIONS
	*/

	private function checkBeforeUpload() {
		$ret = TRUE;
		if (!$this->_name)
			$ret = FALSE;
		return ($ret);
	}

	/*
	HTML GENERATION

	PUBLIC FUNCTIONS
	*/

	public function getForm($mod = 0) {
		$str = "";

		$action = ($mod) ? "../src/disc/modifDisc.php" : "../src/disc/addDisc.php";
		$str .= "<div id='disc-form-box' class='form-popup undisplayed'>
				<form id='disc-form' method='POST' enctype='multipart/form-data' action='".$action."'>
				<input type='hidden' name='id' value='".$this->_id."'>
				<input type='hidden' name='desc' class='quillInput'>
				<input type='hidden' name='descDelta' class='quillInput'>
				<input type='hidden' name='horaire' class='quillInput'>
				<input type='hidden' name='horaireDelta' class='quillInput'>
				<input type='text' name='name' placeholder='Intitulé' value='".$this->_name."' required>";
		$str .= getQuill("desc");
		$str .= getQuill("horaire");
		$str .= "<div class='info-input-container'>";
		$str .= $this->getCategForm($mod);
		$str .= $this->getProfForm($mod);
		$str .= $this->getFileForm($mod);
		$str .= "</div>";
		if ($mod)
			$str .= "<div id='upload-btn' class='update' >UPLOAD</div>";
		else
			$str .= "<div id='upload-btn' class='insert' >INSERT</div>";
		$str .=  "</form>
				<div class='close-btn'><img src='../../public/pages/images/icon/cross.svg'></div>
				</div>";
		$str .= "</div>";
		return ($str);
	}

	public function getBox() {
		$str = "";

		$str .= "<li data-id=".$this->_id." id='".$this->_name."' class='disc item-box ui-widget-content'>
					<h1 class='item-title'>".$this->_name."</h1>
					<div class='button-box'>
						<h3 class='button-title modif-btn'>modif</h3>
						<form method='POST' action='../src/disc/supprDisc.php'>
							<input type='hidden' name='id' value=".$this->_id."></input>
							<input type='submit' value='suppr' class='button-title suppr-btn'></input>
						</form>
					</div>
				</li>";
		return ($str);
	}

	public function getVideoForm($mod = 0) {
		$str = "";

		$str .= "<div class='dId' id='".$this->_id."'>";
		$str .= "<link rel='stylesheet' href='css/video.css'>";
		$str .= "<script src='./js/video.js'></script>";
		$str .= "<table id='video-input-container'>";
		$str .= "<tr class='single-input-container ui-state-disabled'>
					<th class='video-td'>Nom de la vidéo</th>
					<th class='video-td'>Lien youtube</th>
				</tr>";
		if (is_array($this->_video)) {
			foreach ($this->_video as $id) {
				$v = new cVideo($id);
				$str .= $v->getForm();
			}
		}
		$str .= "</table>";
		$str .= "<div id='video-popup'>";
		$str .= "<label class='video-file-label' for='add-video-file'><h4>Ajouter un fichier</h4></label>";
		$str .= "<input id='add-video-file' class='vfile' type='file' name='video-file'>";
		$str .= "<input class='vlink' type='text' name='video-link' placeholder='Ajouter un lien Youtube'>";
		$str .= "<div class='addVideo'></div>";
		$str .= "</div></div>";
		return ($str);
	}

	public function getVideoGallery() {
		$str = "";

		$str .= "<div id='videoGallery'>";
		foreach ($this->_video as $vId) {
			$v = new cVideo($vId);
			$str .= $v->getFrontHTML();
		}
		$str .= "</div>";
		return ($str);
	}

	public function getFrontVideo() {
		$str = "";

		if (is_array($this->_video) && isset($this->_video[0])) {
			$v = new cVideo($this->_video[0]);
			$str .= $v->getFrontHTML(1);
		}
		return ($str);
	}
	
	/*
	HTML GENERATION

	PRIVATE FUNCTIONS
	*/

	private function getCategForm($mod = 0) {
		$str = "";
		$categs = getAllCategs();

		$str .= "<div class='categ-input-box'><h3>Sections</h3>";
		foreach ($categs as $key => $categ) {
			$id = $categ->getId();
			$name = $categ->getName();
			$checked = "";
			$class = "";
			if ($mod && $id == $this->_categ) {
				$checked = "checked";
				$class = "label-radio-categ-activ";
			}
			$str .= "<label for=".$id."-radio class='label-radio-categ ".$class."'>".$name."</label>";
			$str .= "<input id=".$id."-radio class='undisplayed radio-categ' type='radio' name='categ' value=".$id." ".$checked.">"	;
		}
		$str .= "</div>";
		return ($str);
	}

	private function getProfForm($mod = 0) {
		$str = "";
		$profs = getAllProfs();

		$str .= "<div class='prof-input-box'>";
		$str .= "<h3>Profs</h3>";
		$str .= "<div class='prof-slider' >";
		if ($profs) {
			foreach ($profs as $key => $prof) {
				$id = $prof->getId();
				$name = $prof->getName();
				$surname = $prof->getSurname();
				$checked = "";
				$class = "";
				if ($mod) {
					foreach ($this->_profs as $key => $val) {
						if ($val == $id) {
							$checked = "checked";
							$class = "prof-label-activ";
							break;
						}
					}
				}
				$str .= "<label class='prof-label ".$class."' for='$id-prof'>$name $surname</label>";
				$str .= "<input class='prof-chkbox' value=$id type='checkbox' id='$id-prof' name='profs[]' $checked>";
				}
			}
		$str .= "</div></div>";
		return ($str);
	}

	private function getFileForm($mod) {
		$str = "";

		$path = "";
		if ($mod) {
			if (isset($this->_image))
				$path = "/dojo/public/pages/images/discipline/".$this->_image;
		}

		$str .= "<div class='file-input-container'>
					<div class='file-input-box'>
						<h3>image accueil</h3>
						<label for='disc-image-slider' class='label-file'>Choisir une image</label>
						<input id='disc-image-slider' class='input-file' type='file' name='image'/>
						<div class='image-preview'><img height='200px' width='200px' src='".$path."'></div>
					</div>
				</div>";
		return ($str);
	}
}

?>