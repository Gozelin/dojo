<?php

require_once('../../../public/src/defines.php');
// require_once(PATH_INTER."src/secure.php");
require_once('../../../public/src/function.php');
require_once(PATH_CLASS."Discipline.Class.php");
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Video.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

if (isset($_POST) && isset($_POST["action"])) {
	switch($_POST["action"]) {
		case "getVideoForm":
			if (isset($_POST["id"])) {
				$d = new cDiscipline($_POST["id"]);
				echo $d->getVideoForm();
			}
		break;
		case "getPreview":
			getPreview();
		break;
		case "insert":
			vInsert();
		break;
		case "update":
			vUpdate();
		break;
		case "delete":
			vDelete();
		break;
		case "updateOrder":
			updateOrder();
		break;
	}
}

function updateOrder() {
	if (isset($_POST["id"])) {
		$id = $_POST["id"];
		$d = new cDiscipline($id);
		if (isset($_POST["order"])) {
			$order = json_decode($_POST["order"]);
			$d->setVideo($order);
			$d->update();
		}	
	}
}

function getPreview() {
	if (isset($_POST["id"])) {
		$id = $_POST["id"];
		$v = new cVideo($id);
		echo $v->getPreview();
	}
}

function vInsert() {
	if (isset($_POST["id"])) {
		$id = $_POST["id"];
		$d = new cDiscipline($id);
		//file
		if (isset($_FILES) && isset($_FILES["video-file"])) {
			echo "inserting file...\n";
			$f = $_FILES["video-file"];
			$fn = generateRandomString();
			$ext = strtolower(substr(strrchr($f['name'], '.'), 1));
			$path = $fn.".".$ext;
			$arr = [
				"title"=>$f["name"],
				"path"=>$path
			];
			if (move_uploaded_file($f["tmp_name"], PATH_P_PAGES."video/".$path)) {
				$video = new cVideo($arr);
				$id = $video->insert();
				$d->addVideo($id);
				$d->update();
			}
		}
		//link
		if (isset($_POST["video-link"]) && isset($_POST["video-title"])) {
			echo "inserting link...\n";
			$link = $_POST["video-link"];
			$title = $_POST["video-title"];
			for($i=0; $i < count($link); $i++) {
				$arr = [
					"title"=>$title,
					"link"=>$link
				];
				$video = new cVideo($arr);
				$id = $video->insert();
				$d->addVideo($id);
				$d->update();
			}
		}
	}
}

function vUpdate() {
	if (isset($_POST["dId"]) && isset($_POST["vId"])) {
		$dId = $_POST["dId"];
		$vId = $_POST["vId"];
		$d = new cDiscipline($dId);
		$v = new cVideo($vId);
		if (isset($_POST["video-file-title"])) {
			$v->setTitle($_POST["video-file-title"]);
		} else if (isset($_POST["video-link"])) {
			$v->setLink($_POST["video-link"]);
		} else if (isset($_POST["video-title"])) {
			$v->setTitle($_POST["video-title"]);
		}
		$v->update();
	}
}

function vDelete() {
	if (isset($_POST["dId"]) && isset($_POST["vId"])) {
		$dId = $_POST["dId"];
		$vId = $_POST["vId"];
		$d = new cDiscipline($dId);
		$v = new cVideo($vId);
		$d->deleteVideo($vId);
		$d->update();
		$v->delete();
	}
}

?>