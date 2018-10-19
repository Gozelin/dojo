<?php
session_start();

include("../secure.php");

header('Location: ../../pages/content.php');

require_once("../../../public/src/defines.php");
require_once(PATH_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Categorie.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$image = NULL;
$title = $_POST["title"];
$desc = $_POST["desc"];
$descDelta = $_POST["descDelta"];
$color = $_POST["color"];

$descDelta = json_decode($descDelta);

$name = "";
$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.') ,1) );
$name = generateRandomString();
$name = $name.".".$extension_upload;
$dest = "../../../public/pages/images/categorie/".$name;
$res = move_uploaded_file($_FILES['image']['tmp_name'], $dest);

$data = array(
	"name"=>$title,
	"desc"=>$desc,
	"descDelta"=>$descDelta,
	"color"=>$color,
	"image"=>$name,
	);


$categ = new cCategorie($data);
$categ->insert();

$_SESSION["tab-click"] = "categ";

exit();