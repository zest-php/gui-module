<pre><?php

// downloads at https://github.com/sebastianbergmann

if(version_compare(PHP_VERSION, '5.2.6') < 0){
	trigger_error(sprintf('pour utiliser PHPUnit, il faut au moins PHP 5.2.6 (actuellement %s)', PHP_VERSION), E_USER_ERROR);
}

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL | E_STRICT);
set_time_limit(600);

define('ROOT_PATH', dirname(dirname(dirname(dirname(__FILE__)))));

define('LIBRARIES_PATH', ROOT_PATH.'/libraries');
define('MODULE_PATH', ROOT_PATH.'/modules/gui/private');
define('PHPUNIT_PATH', LIBRARIES_PATH.'/PHPUnit');
define('TESTS_PATH', ROOT_PATH.'/tests/modules/gui');

set_include_path(implode(PATH_SEPARATOR, array(LIBRARIES_PATH, PHPUNIT_PATH, TESTS_PATH)));

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->registerNamespace(array('Zest', 'Gui', 'PHPUnit'));

new Zest_Application_Module_Autoloader(array(
	'namespace' => 'Gui',
	'basePath'  => MODULE_PATH
));

// define('PHPUnit_MAIN_METHOD', 'Gui_Windowing_AllTests::main');

require_once 'Gui/AllTests.php';