<?php

require_once('../../public/src/defines.php');
require_once('../../public/src/function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Video.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

?>

<script src="../../public/pages/js/jquery-3.1.1.min.js"></script>
<script src="./js/function.js"></script>
<script src="./js/jquery-ui.min.js"></script>
<script src="../../public/pages/js/jscolor.js"></script>
<script src="./js/form.js"></script>
<script src="./js/video.js"></script>
<script src="//cdn.quilljs.com/1.3.2/quill.min.js"></script>
<script src="https://vjs.zencdn.net/7.3.0/video.js"></script>
<html>
	<head>
		<link href="//cdn.quilljs.com/1.3.2/quill.snow.css" rel="stylesheet">
		<link href="//cdn.quilljs.com/1.3.2/quill.bubble.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/shared.css">
		<link rel="stylesheet" href="css/jquery-ui.css">
		<link href="https://vjs.zencdn.net/7.3.0/video-js.css" rel="stylesheet">
	</head>
	<body>
		<form enctype="multipart/form-data" method="POST" action="./action_page.php">
			<input name='test' type="file">
			<input type="submit">
		</form>
	</body>
</html>

<script>
// $(document).ready(function() {
// 	getVideoForm(2, 1);
// });
</script>