<?php

session_start();

include("../secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Post.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);


$id = $_POST["id"];

$post = new cPost($id);

$data = array(
	"id"=>$id,
	"title"=>$post->getTitle(),
	"type"=>$post->getType(),
	"desc"=>$post->getDesc(),
	"descDelta"=>$post->getDescDelta(),
	"image"=>$post->getImage()
	);

$send = json_encode($data);

echo $send;

?>