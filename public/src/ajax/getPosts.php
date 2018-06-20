<?php
require_once('../defines.php');
require_once(PATH_SRC."function.php");
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");
require_once(PATH_CLASS."Categorie.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

global $dataBase;

$limit0 = $_POST["limit"];
$limit1 = $limit0+4;
$type = $_POST["type"];

if($type == "")
	$query = "SELECT id FROM post ORDER BY id DESC limit $limit0, $limit1";
else
	$query = "SELECT id FROM post WHERE type = '$type' ORDER BY id DESC limit $limit0, $limit1";

$po_ids = $dataBase->query($query, FETCH_ALL);

$posts = array();

foreach ($po_ids as $key => $id) {
	$post = new cPost($id[0]);
	$posts[] = $post;
}

if($posts == NULL)
	echo 0;

foreach ($posts as $key => $post) {
	$id = $post->getId();
	$title = $post->getTitle();
	$desc = $post->getDesc();

	$desc = htmlspecialchars_decode($desc);
	$desc = str_replace('"', "'", $desc);

	$images = $post->getImage();

	$time = $post->getTime();
	echo 	"<div class='post-item'>
				<div class='post-header'>
					<h2 class='post-title'>$title</h2>
					<h3 class='post-time'>$time</h3>
				</div>
				<div class='post-desc'>$desc</div>
				<div class='post-image-container'> <div class='arrow left-arrow'><img class='arrow-img' src='./images/icon/arrow_left.svg'></div><div class='post-image'>";
		foreach ($images as $key => $image) {
			echo "<a data-lightbox=$id href='./images/posts/$image'><img data-lightbox=$image class='post-img' src='./images/posts/$image'></a>";
		}
	echo "</div><div class='arrow right-arrow'><img class='arrow-img' src='./images/icon/arrow_right.svg'></div></div></div>";
}

?>