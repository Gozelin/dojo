<?php
session_start();

include("../secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");
require_once(PATH_CLASS."Prof.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

header('Location: ../../pages/content.php');

$id = $_POST["id"];
$title = $_POST["title"];
$desc = $_POST["desc"];
$horaire = $_POST["horaire"];
$horaireDelta = $_POST["horaireDelta"];
$descDelta = $_POST["descDelta"];
$categ = $_POST["categ"];

// var_dump($categ);

$link = NULL;

if (!empty($_POST["link"][0])) {
	unset($_POST["link"][count($_POST["link"]) - 1]);
	$link = $_POST["link"];
}

if(isset($_POST["profs"]))
	$profs = $_POST["profs"];
else
	$profs = array();

$descDelta = json_decode($descDelta);
$horaireDelta = json_decode($horaireDelta);

$discipline = new cDiscipline($id);

$discipline->setName($title);
$discipline->setDesc($desc);
$discipline->setDescDelta($descDelta);
$discipline->setLink($link);
$discipline->setCateg($categ);
$discipline->setProfs($profs);
$discipline->setHoraire($horaire);
$discipline->setHoraireDelta($horaireDelta);

$image = $discipline->getImage();

$numberImg = count($_FILES["image"]["name"]);

$imgCount = array();

for($i=0;$i<$numberImg;$i++)
{
	if($_FILES['image']["size"][$i] !== 0)
	{
		$imgCount[] = $i;
	}
}


foreach ($imgCount as $key => $img) {

	$discipline->deleteImage($img);

	$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'][$img], '.')  ,1)  );

	$image[$img] = generateRandomString();

	$image[$img] = $image[$img].".".$extension_upload;

	$dest = "../../../public/pages/images/discipline/".$image[$img];

	$res = move_uploaded_file($_FILES['image']['tmp_name'][$img], $dest);
}

$discipline->setImage($image);

$discipline->update();

$_SESSION["tab-click"] = "disc";

exit();
?>