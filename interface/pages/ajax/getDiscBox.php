<?php
/*
RENVOI LE HTML DES BOX DE DISCIPLINE
*/

require_once('../../../public/src/defines.php');
require_once(PATH_SRC."function.php");
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");
require_once(PATH_CLASS."Categorie.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$disciplines = getAllDiscs();
$categs = getAllCategs();

$send = "";

if ($categs && $disciplines) {
	foreach ($categs as $key => $categ) {
		$categName = $categ->getName();
		$categId = $categ->getId();
		echo "<h1 class='categ-title'>$categName</h1>";
		echo "<div id='$categId' class='categ-box'>";
		foreach ($disciplines as $key => $disc) {
			$discCategId = $disc->getCateg();
			if($categId == $discCategId)
			{
				$name = $disc->getName();
				$id = $disc->getId();
				$categ = $disc->getCateg();
				$categ = new cCategorie($categ);
				$color = $categ->getColor();

				echo "<div style='background-color:$color' data-id=$id id='$name' class='disc item-box'>
							<h1 class='item-title'>".$name."</h1>
							<div class='button-box'>
								<h3 class='button-title modif-btn'>modif</h3>
								<form method='POST' action='../src/disc/supprDisc.php'>
									<input type='hidden' name='id' value=$id></input>
									<input type='submit' value='suppr' class='button-title suppr-btn'></input>
								</form>
							</div>
						</div>";
			}
		}
		echo "</div>";
	}
}

echo "<div id='disc' class='item-box add-btn disc-add-btn'><h1 class='add-title'>ADD</h1></div>";

?>

