<?php
session_start();

require_once("../../../public/src/defines.php");
require_once(PATH_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Prof.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

header('Location: ../../pages/content.php');

$name = $_POST["name"];
$surname = $_POST["surname"];
$desc = $_POST["desc"];
$descDelta = $_POST["descDelta"];

$descDelta = json_decode($descDelta);

$numberImg = count($_FILES["image"]["name"]);

$imgCount = array();

for($i=0;$i<$numberImg;$i++)
{
	if($_FILES['image']["size"][$i] !== 0)
	{
		$imgCount[] = $i;
	}
}

$imageName = array();

$imageName[] = "";

foreach ($imgCount as $key => $img) {
	
	$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'][$img], '.')  ,1)  );

	$imageName[$img] = generateRandomString();

	$imageName[$img] = $imageName[$img].".".$extension_upload;

	$dest = "../../../public/pages/images/profs/".$imageName[$img];

	$res = move_uploaded_file($_FILES['image']['tmp_name'][$img], $dest);
}

$data = array(
	"name"=>$name,
	"surname"=>$surname,
	"desc"=>$desc,
	"descDelta"=>$descDelta,
	"image"=>$imageName,
	);

$prof = new cProf($data);
$prof->insert();

$_SESSION["tab-click"] = "prof";

exit();