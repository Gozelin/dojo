<?php
session_start();

include("../secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");
require_once(PATH_CLASS."Prof.Class.php");
require_once(PATH_CLASS."OrderManager.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$id = $_POST["id"];
$title = $_POST["name"];
$desc = $_POST["desc"];
$horaire = $_POST["horaire"];
$horaireDelta = $_POST["horaireDelta"];
$descDelta = $_POST["descDelta"];
$categ = $_POST["categ"];

//prof
if(isset($_POST["profs"]))
	$profs = $_POST["profs"];
else
	$profs = array();

$descDelta = json_decode($descDelta);
$horaireDelta = json_decode($horaireDelta);

$discipline = new cDiscipline($id);

$changeCateg = false;
$categ_old = $discipline->getCateg();
if ($categ != $categ_old) {
	$changeCateg = true;
}

$discipline->setName($title);
$discipline->setDesc($desc);
$discipline->setDescDelta($descDelta);
$discipline->setCateg($categ);
$discipline->setProfs($profs);
$discipline->setHoraire($horaire);
$discipline->setHoraireDelta($horaireDelta);

if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "") {
	$discipline->deleteImage();
	$extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
	$image = generateRandomString();
	$image = $image.".".$extension_upload;
	$dest = PATH_IMAGES."discipline/".$image;
	$res = move_uploaded_file($_FILES['image']['tmp_name'], $dest);
	$discipline->setImage($image);
}

echo $discipline->update();

//IN CASE THE CATEG HAS CHANGED: CHANGE CATEG IN ORDER.JSON
if ($changeCateg) {
	$om = new cOrderManager([	"action"=>"swapIndex",
								"file"=>"disc",
								"arg"=>["index"=>$categ,
										"id"=>$id]]);
	$om->execQuery();
}
?>