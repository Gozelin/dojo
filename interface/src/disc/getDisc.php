<?php
session_start();

include("../secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

if (isset($_POST["data"]) && is_array($_POST["data"]))
	$_POST = $_POST["data"];

$id = $_POST["id"];

$disc = new cDiscipline($id);

$data = array(
	"id"=>$id,
	"name"=>$disc->getName(),
	"desc"=>$disc->getDesc(),
	"descDelta"=>$disc->getDescDelta(),
	"horaire"=>$disc->getHoraire(),
	"horaireDelta"=>$disc->getHoraireDelta(),
	"image"=>$disc->getImage(),
	"video"=>$disc->getVideo(),
	"categ"=>$disc->getCateg(),
	"prof"=>$disc->getProfs(),
	"inputtype"=> [	"text"=>["id", "name"],
					"quill"=>["descDelta"=>"desc", "horaireDelta"=>"horaire"],
					"image"=>["image"],
					"checkbox"=>["prof"],
					"radio"=>["categ"]],
	"elemtype"=> "disc"
	);

$send = json_encode($data);

echo $send;

?>