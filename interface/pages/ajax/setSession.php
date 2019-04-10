<?php

session_start();

if (isset($_POST["index"]) && isset($_POST["data"])) {
    $_SESSION[$_POST["index"]] = $_POST["data"];
}

?>