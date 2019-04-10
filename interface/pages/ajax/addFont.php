<?php
	include("../../../public/src/defines.php");
	if ($_POST["upload_file"])
	{
		$nospace_name = str_replace(" ", "_", $_FILES["file"]["name"]);
		$curr = $_FILES["file"]["tmp_name"];
		$dest = PATH_PAGE."fonts/".$nospace_name;
		$res = move_uploaded_file($curr, $dest);
		$fonts = json_decode(file_get_contents("../utility/font.json"), true);
		foreach ($fonts as $font) {
			if ($font == $nospace_name)
				exit(0);
		}
		array_push($fonts, $nospace_name);
		file_put_contents("../utility/font.json", json_encode($fonts));
		$f = file_get_contents("../css/shared.css");
		$name = explode('.', $nospace_name)[0];
		$str =
"@font-face {
	font-family: '".$name."';
	src: url('../../../public/pages/fonts/".$nospace_name."');
}\n\n";
		$str .=
".ql-font-".$name." {
	font-family: '".$name."';
}\n\n";
		file_put_contents("../css/shared.css", $str.$f);
	}
?>