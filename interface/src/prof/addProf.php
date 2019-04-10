<?php
session_start();

include("../secure.php");

require_once("../../../public/src/defines.php");
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Prof.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

header('Location: ../../pages/content.php');

$name = $_POST["name"];
$surname = $_POST["surname"];
$desc = $_POST["desc"];
$descDelta = $_POST["descDelta"];

$descDelta = json_decode($descDelta);

$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );

$imageName = generateRandomString();

$imageName = $imageName.".".$extension_upload;

$dest = PATH_IMAGES."prof/".$imageName;

$res = move_uploaded_file($_FILES['image']['tmp_name'], $dest);


$data = array(
	"name"=>$name,
	"surname"=>$surname,
	"desc"=>$desc,
	"descDelta"=>$descDelta,
	"image"=>$imageName,
	);

$prof = new cProf($data);
echo $prof->insert();

exit();