<?php
require_once(PATH_CLASS.'DataBase.Class.php');
require_once(PATH_CLASS.'Discipline.Class.php');
require_once(PATH_CLASS.'Categorie.Class.php');
require_once(PATH_CLASS.'Home.Class.php');
require_once(PATH_CLASS.'Post.Class.php');
require_once(PATH_CLASS.'TextLog.Class.php');
require_once(PATH_CLASS.'OrderManager.Class.php');

/*
CLASS GET
*/

function getAllCategs() {
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

function getAllDiscs() {
	global $dataBase;

	$query = "SELECT id FROM discipline";

	$di_ids = $dataBase->query($query, FETCH_ALL);

	if ($di_ids == NULL)
		return (0);

	$disciplines = array();

	$tabSelected["disc"] = "tab-selected";

	foreach ($di_ids as $key => $id) {
		$disc = new cDiscipline($id[0]);
		if ($disc->getId() != NULL)
			$disciplines[] = $disc;
	}

	return $disciplines;
}

function disc($id) {
	$arr_f = json_decode(file_get_contents(PATH_INTER."/pages/utility/order.json"), true);

	if (!checkOrderArray($arr_f))
		$arr_f = json_decode(file_get_contents(PATH_INTER."/pages/utility/order.json"), true);

	$disciplines = array();

	if (isset($arr_f[$id]) && is_array($arr_f[$id])) {
		foreach ($arr_f[$id] as $key => $id) {
			$disc = new cDiscipline($id);
			if ($disc->getName() != NULL)
				$disciplines[] = $disc;
		}
	}
	return ($disciplines);
}

function getAllProfs() {
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

function getCategColor($id) {
	$disc = new cDiscipline($id);

	$categs = getAllCategs();
	foreach ($categs as $key => $categ) {
		if($categ->getId() == $disc->getCateg())
			$color = $categ->getColor();
	}
	return $color;
}

function getAllMails() {
	$path = PATH_I_PAGES."utility/cMail.db.json";

	$cont = file_get_contents($path);
	$cont = json_decode($cont, true);
	$mails = array();
	if (is_array($cont)) {
		foreach ($cont as $key => $obj) {
			array_push($mails, new cMail($obj["id"]));
		}
	}
	return ($mails);
}

function getAllSalles() {
	global $dataBase;

	$query = "SELECT id FROM salle";
	$sa_ids = $dataBase->query($query, FETCH_ALL);
	if ($sa_ids == NULL)
		return (0);
	$salles = array();
	foreach ($sa_ids as $key => $id) {
		$salle = new cSalle($id[0]);
		$salles[] = $salle;
	}
	return ($salles);
}

/*
MISC
*/

//lol ?
function send_file($fname, $ftmp_name, $folder) {
	$name = "";
	$extension_upload = strtolower(  substr(  strrchr($fname, '.') ,1) );
	$name = generateRandomString();
	$name = $name.".".$extension_upload;
	$dest = "../../../public/pages/images/".$folder."/".$name;
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

function getNavBar($light = 0) {
	$categs = getCategOrdered();
	$str ="";
	$str .= "<div id='nav-bar'>";
	foreach ($categs as $c) {
		$str .= "<div class='primary-tab'><h1>".strtoupper($c->getName())."</h1><div class='triangle no-opacity'></div></div>";
		$discs = getDiscOrdered($c->getId());
		$str .= "<div class='secondary-tab'>";
		if (is_array($discs)) {
			foreach($discs as $d) {
				$str .= "<a id='d-".$d->getId()."' class='disc-link' href='discipline.php?id=".$d->getId()."'><h3>".strtoupper($d->getName())."</h3></a>";
				if (!$light)
					$str .= "<img class='disc-img' src='/dojo/public/pages/images/discipline/".$d->getImage()."'>";
			}
		}
		$str .= "</div>";
	}
	$str .= "<div id='tab-display'></div>";
	$str .= "</div>";
	return ($str);
}

function getCategOrdered() {
	$om = new cOrderManager([	"action"=>"none",
								"file"=>"categ"]);
	$arr_f = $om->getOrder();
	$categ = array();
	foreach ($arr_f as $key => $id) {
		array_push($categ, new cCategorie($id));
	}
	return ($categ);
}

function getDiscOrdered($id){
	$om = new cOrderManager([	"action"=>"none",
								"file"=>"disc"]);
	$arr_f = $om->getOrder();
	if (!checkOrderArray($arr_f)) {
		$om = new cOrderManager([	"action"=>"none",
									"file"=>"disc"]);
		$arr_f = $om->getOrder();
	}
	$disciplines = array();
	if (isset($arr_f[$id]) && is_array($arr_f[$id])) {
		foreach ($arr_f[$id] as $key => $id) {
			$disc = new cDiscipline($id);
			if ($disc->getName() != NULL)
				$disciplines[] = $disc;
		}
	}
	return ($disciplines);
}

function getSalleOrdered() {
	$om = new cOrderManager([	"action"=>"none", 
								"file"=>"salle" ]);
	$arr_f = $om->getOrder();
	$salle = array();
	foreach ($arr_f as $key => $id) {
		array_push($salle, new cSalle($id));
	}
	return ($salle);
}

function checkOrderArray($arr_f)
{
	$ret = TRUE;
	if (!is_array($arr_f)) {
		resetDiscOrder();
		$ret = FALSE;
	} else {
		foreach ($arr_f as $key => $c_order) {
			if (!is_array($c_order)) {
				resetDiscOrder($key);
				$ret = FALSE;
				break;
			}
			foreach ($c_order as $key => $d_id) {
				if (!is_numeric($d_id)) {
					resetDiscOrder($key);
					$ret = FALSE;
					break;
				}
			}
		}
	}
	return ($ret);
}

function resetDiscOrder($id = -1)
{
	$arr_f = array();
	$disciplines = getAllDiscs();
	$i = array();
	foreach ($disciplines as $key => $d) {
		$c = strval($d->getCateg());
		if(!isset($i[$c]))
			$i[$c] = 0;
		if ($c != strval($id) && $id != -1)
			break;
		if (!isset($arr_f[$c]))
			$arr_f[$c] = array();
		array_push($arr_f[$c], $d->getId());
		$i[$c]++;
	}
	file_put_contents(PATH_INTER."/pages/utility/order/disc.order.json", json_encode((object)$arr_f));
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
		$str .= "<div class='prof-wrapper'>";
		$str .= "<img src=images/prof/".$p->getImage().">";
		$str .= "<div class='p-desc'><h2>".$p->getName()." ".$p->getSurname()."</h2></br>".$p->getDesc()."</div>";
		$str .= "</div>";
	}
	$str .= "</div>";
	return ($str);
}

/*
???
*/

function getFontJson() {
	$fonts = json_decode(file_get_contents(PATH_I_PAGES."utility/font.json"));
	foreach ($fonts as $key => $font) {
		$fonts[$key] = explode(".", $font)[0];
	}
	return (json_encode($fonts));
}


function getQuill($name) {
	$fonts = json_decode(getFontJson());
	$str_font = "";
	$sel = "selected";
	foreach ($fonts as $key => $font) {
		$str_font .= "<option ".$sel." value='".$font."'>".$font."</option>";
		$sel = ($sel) ? "" : $sel;
	}
	$str = "<div id='toolbar-".$name."'>
					<select class='ql-size'>
				    	<option value='15px'>small</option>
				    	<option value='20px'>normal</option>
				    	<option value='25px'>big</option>
				    	<option value='30px'>huge</option>
				  	</select>
					 <select class='ql-font'>
					 ".$str_font."
				  	</select>
				  	<button class='ql-bold'></button>
				  	<button class='ql-italic'></button>
				  	<button class='ql-underline'></button>
				  	<input readonly='true'  class='jscolor'></input>
					<select class='ql-color'></select>
				  	<button style='display:none' class='ql-color'></button>
				  	<img class='ql-anchor' src='./icon/big-anchor.svg' width='20px' height='20px'>
				</div>
				<div id='editor-".$name."' class='editor'></div>
				<input name='color' class='jscolor' value='#FFFFFF' type='hidden'></input>";
	return ($str);
}

function formatYTLink($str) {
	$ret = "";
	if (strpos($str, "watch?v=")) {
		$tmp = explode("watch?v=", $str);
		$id = end($tmp);
		if (strpos($id, "&t=")) {
			$id = explode("&", $id)[0];
		}
		$ret = "https://www.youtube.com/embed/".$id;
	} else if (strpos($str, "embed"))
		$ret = $str;
	return ($ret);
}
?>