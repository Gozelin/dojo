<?php
include("../../../public/src/defines.php");
if ($_POST["name"])
{
	$fonts = json_decode(file_get_contents("../utility/font.json"), true);
	foreach ($fonts as $key => $font) {
		if ($font == $_POST["name"])
		{
			unset($fonts[$key]);
			$fonts = array_values($fonts);
			file_put_contents("../utility/font.json", json_encode($fonts));
			unlink(PATH_PAGE."fonts/".$_POST["name"]);
			break;
		}
	}
	delete_font_face($_POST["name"]);
	delete_ql_class($_POST["name"]);
}

function delete_ql_class($name) {
	$f = file_get_contents("../css/shared.css");
	$name = explode(".", $name)[0];
	$str = 
".ql-font-".$name." {
	font-family: '".$name."';
}\n";
	$f = str_replace($str, "", $f);
	file_put_contents("../css/shared.css", $f);
}

function delete_font_face($name) {
	$f = file_get_contents("../css/shared.css");
	$del = true;
	while ($del)
	{
		$del = false;
		if ($p = strpos($f, "@font-face"))
			$del = true;
		$to_replace = check_delete($f, $p, $name);
		if ($to_replace) {
			$f = str_replace($to_replace, "", $f);
			file_put_contents("../css/shared.css", $f);
		}
	}
}

function check_delete($hay, $p, $needle) {
	$i = $p;
	while ($hay[++$i] != '}') {}
	$str = substr($hay, $p, $i + 2);
	if (strpos($str, $needle))
		return ($str);
	return (false);
}
?>