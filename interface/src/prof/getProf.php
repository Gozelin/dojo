<?php

session_start();

include("../secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Prof.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);


$id = $_POST["id"];

$prof = new cProf($id);

$data = array(
	"id"=>$id,
	"name"=>$prof->getName(),
	"surname"=>$prof->getSurname(),
	"desc"=>$prof->getDesc(),
	"descDelta"=>$prof->getDescDelta(),
	"image"=>$prof->getImage()
	);

$send = json_encode($data);

echo $send;

?>