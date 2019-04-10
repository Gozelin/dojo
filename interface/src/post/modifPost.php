<?php
session_start();

include("../secure.php");

require_once("../../../public/src/defines.php");
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Post.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

header('Location: ../../pages/blog.php');

$id = $_POST["id"];
$title = $_POST["title"];
$type = $_POST["type"];
$desc = $_POST["desc"];
$descDelta = $_POST["descDelta"];

$descDelta = json_decode($descDelta);

$post = new cPost($id);

$post->setTitle($title);
$post->setType($type);
$post->setDesc($desc);
$post->setDescDelta($descDelta);

echo "<pre>";

if($_FILES == NULL)
{
	$noImage = array();
	$imageName = $post->setImage($noImage);
}
else
{
	$numberImg = count($_FILES["image"]["name"]);

	$imgCount = array();

	for($i=0;$i<$numberImg;$i++)
	{
		if($_FILES['image']["size"][$i] !== 0)
		{
			$imgCount[] = $i;
		}
	}

	var_dump($imgCount);

	$imageName = $post->getImage();

	var_dump($_POST["hidden-image"]);


	echo "avant";
	var_dump($imageName);

	for($i=0;$i<count($imageName);$i++)
	{
		if(!in_array ($i, $_POST["hidden-image"]))
		{
			$post->deleteImage($i);
			unset($imageName[$i]);
		}
	}

	echo "après";
	$imageName = array_values($imageName);
	var_dump($imageName);

	foreach ($imgCount as $key => $img) {

		echo "img :";
		var_dump($img);

		$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'][$img], '.')  ,1)  );

		$imageName[$img] = generateRandomString();

		$imageName[$img] = $imageName[$img].".".$extension_upload;

		$dest = "../../../public/pages/images/posts/".$imageName[$img];

		$res = move_uploaded_file($_FILES['image']['tmp_name'][$img], $dest);
	}

	$post->setImage(array_values($imageName));


}

$post->update();

$_SESSION["tab-click"] = "post";

exit();
echo "</pre>";

?>


