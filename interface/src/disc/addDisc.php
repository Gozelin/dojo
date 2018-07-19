<?php
session_start();

include("../secure.php");

require_once("../../../public/src/defines.php");
require_once(PATH_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");
require_once(PATH_CLASS."Prof.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

// header('Location: ../../pages/content.php');

$link = NULL;
$title = $_POST["title"];
$desc = $_POST["desc"];
$descDelta = ($_POST["descDelta"] != NULL) ? $_POST["descDelta"] : "none";
$link = $_POST["link"];
$categ = $_POST["categ"];

if(isset($_POST["profs"]))
	$profs = $_POST["profs"];
else
	$profs = array();

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

$name = array();

$name[] = "";

foreach ($imgCount as $key => $img) {

	$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'][$img], '.')  ,1)  );

	$name[$img] = generateRandomString();

	$name[$img] = $name[$img].".".$extension_upload;

	$dest = "../../../public/pages/images/discipline/".$name[$img];

	$res = move_uploaded_file($_FILES['image']['tmp_name'][$img], $dest);
}

$data = array(
	"name"=>$title,
	"desc"=>$desc,
	"descDelta"=>$descDelta,
	"link"=>$link,
	"image"=>$name,
	"categ"=>$categ,
	"profs"=>$profs
	);

$discipline = new cDiscipline($data);
$dId = $discipline->insert();
$dId = strval($dId);

$_SESSION["tab-click"] = "disc";

// exit();

?>

