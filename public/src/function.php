<?php

require_once(PATH_CLASS.'DataBase.Class.php');
require_once(PATH_CLASS.'Discipline.Class.php');
require_once(PATH_CLASS.'Categorie.Class.php');
require_once(PATH_CLASS.'Home.Class.php');
require_once(PATH_CLASS.'Post.Class.php');
require_once(PATH_CLASS.'TextLog.Class.php');

/*
CLASS GET
*/

function getAllCategs()
{
	global $dataBase;

	$query = "SELECT id FROM categorie";

	$ca_ids = $dataBase->query($query, FETCH_ALL);

	if ($ca_ids == NULL)
		return (0);

	$categs = array();

	foreach ($ca_ids as $key => $id) {
		$categ = new cCategorie($id[0]);
		$categs[] = $categ;
	}

	return $categs;
}

function getAllDiscs()
{
	global $dataBase;

	$query = "SELECT id FROM discipline";

	$di_ids = $dataBase->query($query, FETCH_ALL);

	if ($di_ids == NULL)
		return (0);

	$disciplines = array();

	$tabSelected["disc"] = "tab-selected";

	foreach ($di_ids as $key => $id) {
		$disc = new cDiscipline($id[0]);
		$disciplines[] = $disc;
	}

	return $disciplines;
}

function getAllProfs()
{
	global $dataBase;

	$query = "SELECT id FROM prof";

	$pr_ids = $dataBase->query($query, FETCH_ALL);

	if ($pr_ids == NULL)
		return (0);

	$profs = array();

	foreach ($pr_ids as $key => $id) {
		$prof = new cProf($id[0]);
		$profs[] = $prof;
	}

	return $profs;
}

function getCategColor($id)
{
	$disc = new cDiscipline($id);

	$categs = getAllCategs();

	foreach ($categs as $key => $categ) {
		if($categ->getId() == $disc->getCateg())
			$color = $categ->getColor();
	}

	return $color;
}

/*
MISC
*/

function send_file($fname, $ftmp_name) {
	$name = "";
	$extension_upload = strtolower(  substr(  strrchr($fname, '.') ,1) );
	$name = generateRandomString();
	$name = $name.".".$extension_upload;
	$dest = "../../../public/pages/images/categorie/".$name;
	$res = move_uploaded_file($ftmp_name, $dest);
	return ($name);
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/*
HTML GENERATING FUNCTION
*/
function getAdress() {
	$str = 	"<div id='adressInfo'>";
	$str .= "<h2>
				69 rue Audibert et Lavirotte<br>
				69008 Lyon<br>
				<a href='tel:0472732894'>0472732894</a><br>
				<a href='tel:0614833181'>0614833181</a><br>
				</h2>";
	$str .= "</div>";
	return ($str);
}

function getAccroche() {
	$home = new cHome();
	$str = "<div id='accroche'><h3>";
	$str .= $home->getDesc();
	$str .= "</h3></div>";
	return ($str);
}

function getNavBar() {
	$categs = getAllCategs();
	$str = "";
	$str .= "<div id='nav-bar'>";
	foreach ($categs as $c) {
		$str .= "<div class='primary-tab'><h1>".strtoupper($c->getName())."</h1><div class='triangle no-opacity'></div></div>";
		$discs = $c->getDisciplines();
		$str .= "<div class='secondary-tab'>";
		foreach($discs as $d) {
			$str .= "<a id='d-".$d->getId()."' class='disc-link' href='discipline.php?id=".$d->getId()."'><h3>".strtoupper($d->getName())."</h3></a>";
			$str .= "<img class='disc-img' src='../pages/images/discipline/".$d->getImage()[0]."'>";
		}
		$str .= "</div>";
	}
	$str .= "<div id='tab-display'></div>";
	$str .= "</div>";
	return ($str);
}

function getCategInfo($categ) {
	$str = "";
	$disciplines = getAllDiscs();
	$aprof = array();
	foreach ($disciplines as $disc) {
		if ($disc->getCateg() == $categ->getId()) {
			foreach ($disc->getProfs() as $prof) {
				if (!in_array($prof, $aprof)) {
					array_push($aprof, $prof);
				}
			}
		}
	}
	$margin_top = "";
	foreach ($aprof as $proftmp) {
		$profobj = new cProf($proftmp);
		$str .= "	<div $margin_top class='prof-widget'>
						<img src=images/profs/".$profobj->getImage()[0].">
						<div class='prof-info'>
							<h2>".$profobj->getName()."</h2>
							<h2>".$profobj->getSurname()."</h2>
							<p>".$profobj->getDesc()."</p>
						</div>
					</div>";
		$margin_top = "style='margin-top: 15px'";
	}
	return ($str);
}

function getProfHTML($profs) {
	$str = "<div class='prof-info'>";
	foreach($profs as $p) {
		$str .= "<img src=images/profs/".$p->getImage()[0].">";
		$str .= "<div class='p-desc'><h2>".$p->getName()." ".$p->getSurname()."</h2></br>".$p->getDesc()."</div>";
	}
	$str .= "</div>";
	return ($str);
}

/*
???
*/

function getQuill($name) {
	$str = "<div id='toolbar-".$name."'>
					<select class='ql-size'>
				    	<option value='15px'>small</option>
				    	<option value='20px'>normal</option>
				    	<option value='25px'>big</option>
				    	<option value='30px'>huge</option>
				  	</select>
				 	<select class='ql-font'>
				  		<option selected value='Comfortaa'>Comfortaa</option>
				  		<option value='Jura'>Jura</option>
				  	</select>
				  	<button class='ql-bold'></button>
				  	<button class='ql-italic'></button>
				  	<button class='ql-underline'></button>
				  	<input readonly='true'  class='jscolor'></input>
					<select class='ql-color'></select>
				  	<button style='display:none' class='ql-color'></button>
				</div>
				<div id='editor-".$name."' class='editor'></div>
				<input name='color' class='jscolor' value='#FFFFFF' type='hidden'></input>";
	return ($str);
}
?>