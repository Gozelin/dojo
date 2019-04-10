<?php

require_once("../../../public/src/defines.php");
require_once(PATH_CLASS."Mail.Class.php");
require_once(PATH_P_SRC."function.php");

if (isset($_POST["action"])) {
	$action = $_POST["action"];

	$action();
}

function insert() {
	if (isset($_POST["name"]) && isset($_POST["usermail"]) && isset($_POST["object"]) && isset($_POST["mail"])) {
		$name = $_POST["name"];
		$usermail = $_POST["usermail"];
		$object = $_POST["object"];
		$mail = $_POST["mail"];
		$m = new cMail($_POST);
		$m->insertJson();
		header("location: /dojo/public/pages/contact.php");
		exit();
	}
}

function get() {
	$str = "";
	$mails = getAllMails();
	
	$str .= "<div id='inbox'>";
	foreach ($mails as $key => $mail) {
		$str .= $mail->getHTML();
	}
	$str .= "</div>";

	echo $str;
}

function delete() {
	if (isset($_POST["id"])) {
		$m = new cMail($_POST["id"]);
		echo $m->deleteJson();
	}
}

?>