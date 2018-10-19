<?php
/*
RENVOI LE HTML DES BOX DES PROFS
*/

require_once('../../../public/src/defines.php');
require_once(PATH_SRC."function.php");
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Prof.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$profs = getAllProfs();

$send = ""; 

if ($profs) { 
	foreach ($profs as $key => $prof) {
		$name = $prof->getName();
		$surname = $prof->getSurname();
		$image = $prof->getImage();
		$id = $prof->getId();

		echo "<div data-id=$id id='$name' class='prof item-box'>
					<img class='prof-image' src='../../public/pages/images/profs/".$image[0]."'>
					<h1 class='item-title'>".$name." ".$surname."</h1>
					<div class='button-box'>
						<h3 class='button-title modif-btn'>modif</h3>
						<form method='POST' action='../src/prof/supprProf.php'>
							<input type='hidden' name='id' value=$id></input>
							<input type='submit' value='suppr' class='button-title suppr-btn'></input>
						</form>
					</div>
				</div>";
	}
}

echo "<div id='prof' class='item-box add-btn prof-add-btn'><h1 class='add-title'>ADD</h1></div>";

?>