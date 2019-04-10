<?php

require_once('../../../public/src/defines.php');
require_once(PATH_P_SRC."function.php");
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");
require_once(PATH_CLASS."Categorie.Class.php");
require_once(PATH_CLASS."Salle.Class.php");
require_once(PATH_CLASS."Prof.Class.php");
require_once(PATH_CLASS."OrderManager.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

if (isset($_POST) && isset($_POST["action"]))
{
	$html = "";
	switch ($_POST["action"]) {
		case "disc":
			getDiscBox();
		break;
		case "categ":
			getCategBox();
		break;
		case "prof":
			getProfBox();
		break;
		case "salle":
			getSalleBox();
		break;
	}
	$html .= "<div id='".$_POST["action"]."' class='item-box add-btn'><h1 class='add-title'>ADD</h1></div>";
	echo $html;
}

function getDiscBox() {
	global $html;
	$categs = getAllCategs();

	if ($categs) {
		foreach ($categs as $key => $categ) {
			$categName = $categ->getName();
			$categId = $categ->getId();
			$disciplines = getDiscOrdered(strval($categId));
			$html .= "<h1 class='categ-title'>$categName</h1>";
			$html .= "<ul id='$categId' class='categ-box'>";
			if (is_array($disciplines)) {
				foreach ($disciplines as $key => $disc) {
					$html .= $disc->getBox();
				}
			}
			$html .= "</ul>";
		}
	}
}

function getCategBox() {
	global $html;
	$categs = getCategOrdered();
	
	if ($categs) {
		$html .= "<ul class='categBox-wrapper'>";
		foreach ($categs as $key => $categ)
			$html .= $categ->getBox();
		$html .= "</ul>";
	}
}

function getProfBox() {
	global $html;
	$profs = getAllProfs();

	if ($profs) {
		foreach ($profs as $key => $prof) {
			$html .= $prof->getBox();
		}
	}
}

function getSalleBox() {
	global $html;
	$salles = getSalleOrdered();

	$html .= "<ul class='salleBox-wrapper'>";
	if ($salles) {
		foreach ($salles as $key => $salle) {
			$html .= $salle->getBox();
		}
	}
	$html .= "</ul>";
}

?>