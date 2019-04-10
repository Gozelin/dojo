<?php

include("../../public/src/defines.php");
include(PATH_P_SRC."function.php");
include(PATH_CLASS."Salle.Class.php");
include(PATH_CLASS."Gallery.Class.php");

$s = new cSalle();

// var_dump($s);

echo $s->getForm();

?>
<link href="//cdn.quilljs.com/1.3.2/quill.snow.css" rel="stylesheet">
<link href="//cdn.quilljs.com/1.3.2/quill.bubble.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/shared.css">
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="../../public/pages/js/jquery-3.1.1.min.js"></script>
<script src="//cdn.quilljs.com/1.3.2/quill.min.js"></script>
<script src="./js/function.js"></script>
<script src="./js/gallery.js"></script>
<script src="./js/jquery-ui.min.js"></script>
<script>
	aQuill = [];
	quillSetup("desc");
</script>