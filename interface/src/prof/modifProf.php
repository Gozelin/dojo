<?php
session_start();

include("../secure.php");

require_once("../../../public/src/defines.php");
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Prof.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

var_dump($_FILES);

if (isset($_POST["data"]))
	$_POST = $_POST["data"];

$id = $_POST["id"];
$name = $_POST["name"];
$surname = $_POST["surname"];
$desc = $_POST["desc"];
$descDelta = $_POST["descDelta"];

$descDelta = json_decode($descDelta);

$prof = new cProf($id);

$prof->setName($name);
$prof->setSurname($surname);
$prof->setDesc($desc);
$prof->setDescDelta($descDelta);

$numberImg = count($_FILES["image"]["name"]);

$imgCount = array();

for($i=0;$i<$numberImg;$i++)
{
	if($_FILES['image']["size"][$i] !== 0)
	{
		$imgCount[] = $i;
	}
}

if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "") {
	$prof->deleteImage();
	$extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
	$image = generateRandomString();
	$image = $image.".".$extension_upload;
	$dest = PATH_IMAGES."prof/".$image;
	$res = move_uploaded_file($_FILES['image']['tmp_name'], $dest);
	$prof->setImage($image);
}

echo $prof->update();
?>


