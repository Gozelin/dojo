<?php

class cVideo {

	/*
	ATTRIBUT
	*/

	//int
	protected $_id = NULL;

	//string
	protected $_path = NULL;

	//string
	protected $_link = NULL;

	//string
	protected $_title = NULL;

	/*
	ACCESSORS
	*/

	public function getPath() { return($this->_path); }
	public function setPath($value) { $this->_path = $value; }

	public function getLink() { return($this->_link); }
	public function setLink($value) { $this->_link = $value; }

	public function getTitle() { return($this->_title); }
	public function setTitle($value) { $this->_title = $value; }

	/*
	CONSTRUCTOR
	*/

	public function __construct($details = NULL) {
		if (is_array($details)) {
			foreach ($details as $key => $detail) {
				$key = "_".$key;
				if (property_exists("cVideo", $key)) {
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

		$query = "SELECT * FROM video WHERE id = $id";
		$data = $dataBase->query($query, FETCH_ARRAY);

		$this->_id = $dataBase->unprotect($data["id"], _INT_);
		$this->_path = $dataBase->unprotect($data["path"], _STRING_);
		$this->_link = $dataBase->unprotect($data["link"], _STRING_);
		$this->_title = $dataBase->unprotect($data["title"], _STRING_);
				
		return (1);
	}

	public function insert() {
		global $dataBase;

		if ($this->_title == NULL)
			$this->_title = "";
		if ($this->_link == NULL)
			$this->_link = "";
		if ($this->_path == NULL)
			$this->_path = "";

		$v_path = $dataBase->protect($this->_path, _STRING_);
		$v_title = $dataBase->protect($this->_title, _STRING_);
		$v_link = $dataBase->protect($this->_link, _STRING_);

		$query = "INSERT INTO video (path, link, title) VALUES ($v_path, $v_link, $v_title)";

		$dataBase->query($query);
		
		return ($dataBase->insert_id);
	}

	public function update() {
		global $dataBase;

		$v_id = $dataBase->protect($this->_id, _INT_);
		$v_path = $dataBase->protect($this->_path, _STRING_);
		$v_title = $dataBase->protect($this->_title, _STRING_);
		$v_link = $dataBase->protect($this->_link, _STRING_);

		$query = "UPDATE video SET id = $v_id, path = $v_path, title = $v_title, link = $v_link WHERE id = $v_id";

		$dataBase->query($query);

		return (1);
	}

	public function delete() {
		global $dataBase;

		$v_id = $dataBase->protect($this->_id, _INT_);

		$query = "DELETE FROM video WHERE id = $v_id";

		$dataBase->query($query);
		
		if ($this->_path != NULL) {
			unlink(PATH_P_PAGES."video/".$this->_path);
		}
		return (1);
	}

	/*
	HTML GENERATION
	*/

	public function getForm() {
		$str = "";
		$str .= "<tr class='single-input-container'>";
		$str .= "<input type='hidden' name='vId' value='".$this->_id."'>";
		$str .= "<td class='sort-icon'><img src='/dojo/public/pages/images/icon/doublearrow.svg' height='25px'></td>";
		if ($this->_link != NULL) {
			$str .= "<td class='video-td'><input class='vInput' type='text' name='video-title' value='".$this->_title."'></td>";
			$str .= "<td class='video-td'><input class='vInput' type='text' name='video-link' value='".$this->_link."'></td>";
		} else if (isset($this->_path)) {
			$str .= "<td class='video-td'><input class='vInput' type='text' name='video-file-title' class='videoFileInput' value='".$this->_title."'></td>";
			$str .= "<td class='video-td'></td>";
		}
		$str .= "<td class='del-btn'></td>";
		$str .= "<td style='margin:auto'><img src='../../public/pages/images/icon/watch.png' width='35px' height='25px' class='watch-btn'></td>";
		$str .= "</tr>";
		return ($str);
	}

	public function getPreview() {
		$str = "";
		$str .= "<div id='vPreview-popup'>";
		$str .= "<div class='closePreview-btn'></div>";
		var_dump($this->_link);
		if ($this->_link == NULL || $this->_link == "") {
			$str .= "
			<video id='my-video' class='video-js' controls preload='auto' width='640' height='264'data-setup='{}'>
			<source src='/dojo/public/pages/video/".$this->_path."' type='video/mp4'>
			<p class='vjs-no-js'>
				To view this video please enable JavaScript, and consider upgrading to a web browser that
				<a href='https://videojs.com/html5-video-support/' target='_blank'>supports HTML5 video</a>
			</p>
			</video>
			";
		} else {
			$link = $this->formatLink($this->_link);
			$str .= "
			<iframe id='ytplayer' type='text/html' width='640' height='360'
				src='".$link."'
				frameborder='0'/>
			";
		}
		$str .= "</div>";
		return ($str);
	}

	public function getFrontHTML($mod = 0) {
		$str = "";

		if (!$mod)
			$str .= "<div class='vPreview'>";
		else
			$str .= "<div class='vPreview' style='width: 100%; margin-bottom: 20px'>";
		if ($this->_link == NULL) {
			$str .= "
			<video id='my-video' class='video-js' controls preload='auto' width='640' height='360'data-setup='{}'>
			<source src='/dojo/public/pages/video/".$this->_path."' type='video/mp4'>
			</video>
			";
		} else {
			$link = $this->formatLink($this->_link);
			$str .= "
			<iframe id='ytplayer' type='text/html' width='100%' height='360'
				src='".$link."'
				frameborder='0'/></iframe>
			";
		}
		$str .= "</div>";
		return ($str);
	}

	/*
		PRIVATE FUNCTIONS
	*/

	private function formatLink($str) {
		$ret = "";
		if (strpos($str, "watch?v=")) {
			$tmp = explode("watch?v=", $str);
			$id = end($tmp);
			if (strpos($id, "&t=")) {
				$id = explode("&", $id)[0];
			}
			$ret = "https://www.youtube.com/embed/".$id;
		} else if (strpos($str, "embed"))
			$ret = $str;
		return ($ret);
	}
}

?>