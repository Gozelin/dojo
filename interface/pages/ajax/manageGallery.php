<?php

session_start();

require_once('../../../public/src/defines.php');
require_once(PATH_INTER."src/secure.php");
require_once('../../../public/src/function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Gallery.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$action = NULL;
$file = NULL;

if (isset($_POST["action"]))
	$action = $_POST["action"];

if (isset($action)) {
	switch ($action) {
		case "insert":
			insertGallery();
		break;
		case "getForm":
			if (isset($_POST["id"]))
				$g = new cGallery($_POST["id"]);
				echo $g->getForm();
		break;
		case "updateImage":
			updateImage();
		break;
		case "supprImage":
			supprImage();
		break;
		case "addImage":
			addNew();
		break;
		default:
			echo "this action isn't registered";
		break;
	}
}

function addNew() {
	$up_path = PATH_IMAGES."gallery/";
	if (isset($_FILES["uploads"]) && isset($_POST["id"])) {
		$file = $_FILES["uploads"];
		$g = new cGallery($_POST["id"]);
		addImage($g, $file);
		echo $g->update();
	}
}

function supprImage() {
	if (isset($_POST["id"]) && isset($_POST["imgId"])) {
		$g = new cGallery($_POST["id"]);
		$g->deleteImage($_POST["imgId"]);
		$g->update();
	}
}

function insertGallery() {
	if (isset($_FILES["uploads"])) {
		$file = $_FILES["uploads"];
		$g = new cGallery();
		addImage($g, $file);
		$g->setName($_POST["name"]);
		echo $g->insert();
	}
}

function updateImage() {
	if (isset($_POST["id"]) && isset($_POST["image"])) {
		$image = json_decode($_POST["image"]);
		$g = new cGallery($_POST["id"]);
		$g->setImage($image);
		$g->update();
	}
}

function addImage(&$g, $file) {
	$db_path = "/dojo/public/pages/images/gallery/";
	if ($file) {
		$nfile = count($file["name"]);
		for($i=0; $i < $nfile; $i++) {
			$img = new cImage(["name"=>$file["name"][$i], "path"=>$db_path, "tmppath"=>$file["tmp_name"][$i]]);
			if ($img->upload()) {
				$g->addImage($img);
			}
		}
	}
}

?>