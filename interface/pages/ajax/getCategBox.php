<?php
/*
RENVOI LE HTML DES BOX DE CATEGORIE
*/

require_once('../../../public/src/defines.php');
require_once(PATH_SRC."function.php");
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");
require_once(PATH_CLASS."Categorie.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$categs = getAllCategs();

$send = "";

foreach ($categs as $key => $categ) {
	$id = $categ->getId();
	$name = $categ->getName();
	$color = $categ->getColor();

	$send .= "<div style='background-color:#$color' data-id=$id id='$name' class='categ item-box'>
				<h1 class='item-title'>".$name."</h1>
				<div class='button-box'>
					<h3 class='button-title modif-btn'>modif</h3>
					<form method='POST' action='../src/categ/supprCateg.php'>
						<input type='hidden' name='id' value=$id></input>
						<input type='submit' value='suppr' class='button-title suppr-btn'></input>
					</form>
				</div>
			</div>";
}

$send .= "<div id='categ' class='item-box add-btn'><h1 class='add-title'>ADD</h1></div>";

echo $send;
?>