<?php

require_once(PATH_CLASS.'DataBase.Class.php');
require_once(PATH_CLASS.'Discipline.Class.php');
require_once(PATH_CLASS.'Categorie.Class.php');
require_once(PATH_CLASS.'Home.Class.php');
require_once(PATH_CLASS.'Post.Class.php');
require_once(PATH_CLASS.'TextLog.Class.php');

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

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function get_header($categs) {
	$str = "";
	$str .= "<div id='nav-container'>";
	foreach ($categs as $categ) {
		$str .= "<div class='tab-wrapper'><a style='width:100%;height:100%;display:flex;' id='".$categ->getId()."'><h3 style='margin:auto'>".strtoupper($categ->getName())."</h3></a>";
		$str .= "<div class='list-wrapper'>";
		$discs = $categ->getDisciplines();
		foreach ($discs as $d) {
			$str .= "<a class='list-tab' href='categ.php?id=".$categ->getId()."&dId=".$d->getId()."'><h4>".$d->getName()."</h4></a>";
		}
		$str .= "</div></div>";
	}
	$str .= "<a class='tab tab2' href='horaire.php'><h3>HORAIRE</h3></a>";
	$str .= "<a class='tab tab2' href='contact.php'><h3>CONTACT</h3></a>";
	$str .= "</div>";
	return ($str);
}

function get_header_light() {
	$str = "";
	$str .= "<div id='nav-container'>";
	$str .= "<a id='return-link' href='home.php'><h2>Retour</h2></a>";
	$str .= "<a class='tab tab2' href='horaire.php'><h3>HORAIRE</h3></a>";
	$str .= "<a class='tab tab2' href='contact.php'><h3>CONTACT</h3></a>";
	$str .= "</div>";
	return ($str);
}

function getHomeCateg() {
	$str = "";
	$categs = getAllCategs();
	$i = 0;
	foreach ($categs as $categ) {
		if ($i % 2 == 0) {
			$content0 = "<div class='categ-content'>
							<h1>".strtoupper($categ->getName())."</h1>
							".$categ->getDesc()."
							".$categ->getDiscLink()."
						</div>";
			$content1 = "";
			$attr = "";
		} else {
			$content1 = "<div class='categ-content'>
							<h1>".strtoupper($categ->getName())."</h1>
							".$categ->getDesc()."
							".$categ->getDiscLink()."
						</div>";
			$content0 = "";
			$attr = "style='right: 50%'";
		}
		$str .= "<div class='categ-box'>
						$content0
						<div class='categ-slider'>
							<div class='categ-cover' ".$attr."></div>
							<img src=./images/categorie/".$categ->getImage().">
							<a href='categ.php?id=".$categ->getId()."'>
							<div class='more-btn'>
								<h1>Decouvrir</h1>
							</div></a>
						</div>
						$content1
					</div>";
		$margin_top = "";
		// $i++; //DECOMMENT POUR ALTERNER
	}
	return ($str);
}

function send_file($fname, $ftmp_name) {
	$name = "";
	$extension_upload = strtolower(  substr(  strrchr($fname, '.') ,1) );
	$name = generateRandomString();
	$name = $name.".".$extension_upload;
	$dest = "../../../public/pages/images/categorie/".$name;
	$res = move_uploaded_file($ftmp_name, $dest);
	return ($name);
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

function GetDiscWidget($categ, &$nd) {
	$content = getContentWidget($categ, $nd);
	$str = "<div class='widget-wrapper'>
	<div class='categ-boxu categ-disc-box'>
		<div id='disc-content-box' style='display:none'>".$content."</div>
		<div class='disc-widget'>
			<div class='widg-content wc-displayed'></div>
		</div>
	</div>
	</div>";
	return ($str);
}

function getContentWidget($categ, &$nd) {
	$str = "";
	$nd = -1;
	$discs = $categ->getDisciplines();
	foreach($discs as $d) {
		$nd++;
		$str .= "	<div id='disc-content-".$nd."' class='disc-content'>
						<h1 class='disc-title'>".$d->getName()."</h1>
						<img src=images/discipline/".$d->getImage()[0].">
						<div class='disc-desc'>".$d->getDesc()."</div>
					</div>";
	}
	return ($str);
}

?>