<?php
session_start();

include("../secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$id = $_POST["id"];

$disc = new cDiscipline($id);

$data = array(
	"id"=>$id,
	"name"=>$disc->getName(),
	"desc"=>$disc->getDesc(),
	"descDelta"=>$disc->getDescDelta(),
	"image"=>$disc->getImage(),
	"link"=>$disc->getLink(),
	"categ"=>$disc->getCateg(),
	"profs"=>$disc->getProfs()
	);

$send = json_encode($data);

echo $send;

?>