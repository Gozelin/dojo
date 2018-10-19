<?php
require_once('../../../public/src/defines.php');
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
	$type = $post->getType();
	$time = $post->getTime();

	echo		"<div data-id=$id class='post-item'>
					<h1 class='post-type' >$type</h1>
					<div class='post-title'>
							<h2>$title</h2>
							<h3>$time</h3>
						</div>
						<div class='button-box button-post'>
							<h3 class='button-title modif-btn'>modif</h3>
							<form method='POST' action='../src/post/supprPost.php'>
								<input type='hidden' name='id' value=$id></input>
								<input type='submit' value='suppr' class='button-title suppr-btn	'></input>
							</form>
						</div>
					</div>";
}



?>