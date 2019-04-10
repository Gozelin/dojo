<?php
define("PATH_DOJO", $_SERVER['DOCUMENT_ROOT']."/dojo/");
/*
** PUBLIC
*/

// - - - - - - - - - - - - - - - - - - - - - - - - - - dojo/public/
define("PATH_PUBLIC", PATH_DOJO."public/");

// - - - - - - - - - - - - - - - - - - - - - - - - - - dojo/public/pages/
define("PATH_P_PAGES", PATH_PUBLIC."pages/");

// - - - - - - - - - - - - - - - - - - - - - - - - - - dojo/public/pages/images
define("PATH_IMAGES", PATH_P_PAGES."images/");

// - - - - - - - - - - - - - - - - - - - - - - - - - - dojo/public/src/
define("PATH_P_SRC", PATH_PUBLIC."src/");

// - - - - - - - - - - - - - - - - - - - - - - - - - - dojo/src/class/
define("PATH_CLASS", PATH_P_SRC."class/");

/*
** INTERFACE
*/

// - - - - - - - - - - - - - - - - - - - - - - - - - - dojo/interface/
define("PATH_INTER", PATH_DOJO."interface/");

// - - - - - - - - - - - - - - - - - - - - - - - - - - dojo/interface/src/
define("PATH_I_SRC", PATH_INTER."src/");

// - - - - - - - - - - - - - - - - - - - - - - - - - - dojo/interface/pages/
define("PATH_I_PAGES", PATH_INTER."pages/");

// - - - - - - - - - - - - - - - - - - - - - - - - - - dojo/interface/pages/ajax/
define("PATH_AJAX", PATH_I_PAGES."ajax/");

// - - - - - - - - - - - - - - - - - - - - - - - - - - dojo/interface/pages/form/
define("PATH_FORM", PATH_I_PAGES."form/");

include(PATH_DOJO.'config/log.php.sample');
?>

