<?php
session_start();

include("../secure.php");

require_once("../../../public/src/defines.php");
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");
require_once(PATH_CLASS."Prof.Class.php");
require_once(PATH_CLASS."OrderManager.Class.php");
require_once(PATH_CLASS."Video.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$title = $_POST["name"];
$desc = $_POST["desc"];
$horaire = $_POST["horaire"];
$categ = $_POST["categ"];

if(isset($_POST["profs"]))
	$profs = $_POST["profs"];
else
	$profs = array();

if (isset($_POST["descDelta"])) {
	if ($_POST["descDelta"] != NULL)
		$descDelta = json_decode($_POST["descDelta"]);
	else
		$descDelta = [];
}

if (isset($_POST["horaireDelta"])) {
	if ($_POST["horaireDelta"] != NULL)
		$horaireDelta = json_decode($_POST["horaireDelta"]);
	else
		$horaireDelta = [];
}

$image = "";

if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "") {
	$extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
	$image = generateRandomString();
	$image = $image.".".$extension_upload;
	$dest = PATH_IMAGES."discipline/".$image;
	$res = move_uploaded_file($_FILES['image']['tmp_name'], $dest);
}

//array
$data = array(
	"name"=>$title,
	"desc"=>$desc,
	"descDelta"=>$descDelta,
	"horaire"=>$horaire,
	"horaireDelta"=>$horaireDelta,
	"image"=>$image,
	"categ"=>$categ,
	"profs"=>$profs
);

$discipline = new cDiscipline($data);

$dId = $discipline->insert();

echo $dId;

$dId = strval($dId);

// adding to order.json
$om = new cOrderManager([	"action"=>"addOrder",
							"file"=>"disc",
							"arg"=>["id"=>$dId,"index"=>$categ]]);
$om->execQuery();

?>

