<?php
session_start();

include("../secure.php");

require_once("../../../public/src/defines.php");
require_once(PATH_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");
require_once(PATH_CLASS."Prof.Class.php");
require_once(PATH_CLASS."Post.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

header('Location: ../../pages/blog.php');

$title = $_POST["title"];
$type = $_POST["type"];
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

$name = array();

foreach ($imgCount as $key => $img) {
	
	$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'][$img], '.')  ,1)  );

	$name[$img] = generateRandomString();

	$name[$img] = $name[$img].".".$extension_upload;

	$dest = "../../../public/pages/images/posts/".$name[$img];

	$res = move_uploaded_file($_FILES['image']['tmp_name'][$img], $dest);
}

$time = new DateTime("now");
$time = $time->format('d-m-Y H:i');

$data = array(
	"title"=>$title,
	"type"=>$type,
	"time"=>$time,
	"desc"=>$desc,
	"descDelta"=>$descDelta,
	"image"=>$name
	);

$post = new cPost($data);
echo "<pre>";
var_dump($post);
echo "</pre>";
$dId = $post->insert();
$dId = strval($dId);

$_SESSION["tab-click"] = "post";

exit();

?>

