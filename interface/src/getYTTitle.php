<?php

if (isset($_POST["link"])) {
	$link = $_POST["link"];

	$id = explode('/', $link);

	$id = end($id);

	echo file_get_contents($link);
} else {
	echo "link missing in \$_POST";
}
?>