<?php

/**
 * @category Gui
 * @package Gui_Manager
 * @subpackage UnitTests
 */
class Gui_Manager_LoaderTest extends PHPUnit_Framework_TestCase{
	
	/**
	 * @var Gui_Manager_Loader
	 */
	protected $_loader = null;
	
	protected function setUp(){
		$this->_loader = new Gui_Manager_Loader(Gui_Manager::getInstance());
		
		new Zest_Application_Module_Autoloader(array(
			'namespace' => 'Loader',
			'basePath'  => Gui_AllTests::getDataDir().'/manager/loader'
		));
	}
	
	public function testAddModuleResourceType(){
		$this->_loader->addModuleResourceType('loader', 'model');
		$this->assertEquals(2, count($this->_loader->getClassTree('Loader_Model_TestAddModuleResourceType', true)));
	}
	
	public function testGetClass(){
		$this->_loader->addModuleResourceType('loader', 'model');
		$this->_loader->getClass('Loader_Model_TestGetClass', true);
	}
	
	public function testGetClassOverride(){
		$this->_loader->addModuleResourceType('loader', 'model');
		
		$class = $this->_loader->getClass('Loader_Model_TestGetClassOverride1', true);
		$this->assertEquals('Loader_Model_TestGetClassOverride2', $class);
		
		$class = $this->_loader->getClass('Loader_Model_TestGetClassOverride2', true);
		$this->assertEquals('Loader_Model_TestGetClassOverride2', $class);
	}
	
	public function testGetClassOverrideInverse(){
		$this->_loader->addModuleResourceType('loader', 'model');
		
		$class = $this->_loader->getClass('Loader_Model_TestGetClassOverrideInverse2', true);
		$this->assertEquals('Loader_Model_TestGetClassOverrideInverse1', $class);
		
		$class = $this->_loader->getClass('Loader_Model_TestGetClassOverrideInverse1', true);
		$this->assertEquals('Loader_Model_TestGetClassOverrideInverse1', $class);
	}
	
	public function testGetClassOverrideMultiple(){
		$this->_loader->addModuleResourceType('loader', 'model');
		
		$class = $this->_loader->getClass('Loader_Model_TestGetClassOverrideMultiple1', true);
		$this->assertEquals('Loader_Model_TestGetClassOverrideMultiple3', $class);
		
		$class = $this->_loader->getClass('Loader_Model_TestGetClassOverrideMultiple2', true);
		$this->assertEquals('Loader_Model_TestGetClassOverrideMultiple3', $class);
		
		$class = $this->_loader->getClass('Loader_Model_TestGetClassOverrideMultiple3', true);
		$this->assertEquals('Loader_Model_TestGetClassOverrideMultiple3', $class);
	}
	
	public function testGetClassOverrideMultipleInverse(){
		$this->_loader->addModuleResourceType('loader', 'model');
		
		$class = $this->_loader->getClass('Loader_Model_TestGetClassOverrideMultipleInverse3', true);
		$this->assertEquals('Loader_Model_TestGetClassOverrideMultipleInverse1', $class);
		
		$class = $this->_loader->getClass('Loader_Model_TestGetClassOverrideMultipleInverse2', true);
		$this->assertEquals('Loader_Model_TestGetClassOverrideMultipleInverse1', $class);
		
		$class = $this->_loader->getClass('Loader_Model_TestGetClassOverrideMultipleInverse1', true);
		$this->assertEquals('Loader_Model_TestGetClassOverrideMultipleInverse1', $class);
	}
	
	public function testGetClassTreeFinal(){
		$class = $this->_loader->getClass('Loader_Model_TestGetClassTreeFinal');
		$this->assertEquals('Loader_Model_TestGetClassTreeFinal', $class);
	}
	
//	public function testGetClassTreeFinalException(){
//		// exception lancée par getClassTree : Impossible de trouver la classe "Loader_Model_TestGetClassTreeFinal" à partir du tableau moduleResourceType.
//		$this->setExpectedException('Zest_Exception');
//		$this->_loader->getClass('Loader_Model_TestGetClassTreeFinal', true);
//	}
//	
//	public function testGetClassTreeExceptionNoOverride(){
//		// exception lancée par getClassTree : Impossible de trouver la classe "Loader_Model_TestGetClassTreeExceptionNoOverride" à partir du tableau moduleResourceType.
//		$this->setExpectedException('Zest_Exception');
//		$this->_loader->getClassTree('Loader_Model_TestGetClassTreeExceptionNoOverride', true);
//	}
	
	public function testGetClassTreeExceptionNoOverrideContreTest(){
		$this->_loader->addModuleResourceType('loader', 'model');
		$this->_loader->getClassTree('Loader_Model_TestGetClassTreeExceptionNoOverride', true);
	}
	
	public function testGetClassTreeExceptionNotGui(){
		// exception lancée par _getClassTree : La classe "Loader_Model_TestGetClassTreeExceptionNotGui" doit hériter d'une classe dont l'espace est "Gui".
		$this->setExpectedException('Zest_Exception');
		$this->_loader->getClassTree('Loader_Model_TestGetClassTreeExceptionNotGui');
	}
	
	public function testGetClassTreeExceptionNotGuiWithModuleResourceType(){
		// exception lancée par getClassTree : Impossible de trouver la classe "Loader_Model_TestGetClassTreeExceptionNotGuiWithModuleResourceType" à partir du tableau moduleResourceType.
		$this->setExpectedException('Zest_Exception');
		$this->_loader->addModuleResourceType('loader', 'model');
		$this->_loader->getClassTree('Loader_Model_TestGetClassTreeExceptionNotGuiWithModuleResourceType', true);
	}
	
	public function testGetClassTreeExceptionNoResourceType(){
		// exception lancée par _initOverrideClasses : La ressource "testGetClassTreeExceptionNoResourceType" n'a pas été trouvée dans le module "loader".
		$this->setExpectedException('Zest_Exception');
		$this->_loader->addModuleResourceType('loader', 'testGetClassTreeExceptionNoResourceType');
		$this->_loader->getClassTree('Loader_Model_TestGetClass', true);
	}
	
	public function testGetObject(){
		$object = $this->_loader->getObject('Loader_Model_TestGetObject');
		$this->assertInstanceOf('Loader_Model_TestGetObject', $object);
		$this->assertNull($object->getArg());
	}
	
	public function testGetObjectSaver(){
		$object = $this->_loader->getObject('Loader_Model_TestGetObjectSaver');
		$object->setParam('testGetObjectSaver', true);
		$this->_loader->saveObject($object);
		
		$object = $this->_loader->getObject('Loader_Model_TestGetObjectSaver');
		$this->assertTrue($object->getParam('testGetObjectSaver'));
	}
	
	public function testGetObjectException(){
		$this->setExpectedException('Zest_Exception');
		$this->_loader->getObject('Gui_Object');
	}
	
	public function testGetObjectArgs(){
		$object = $this->_loader->getObject('Loader_Model_TestGetObject', array('arg' => 'testGetObjectArgs'));
		$this->assertInstanceOf('Loader_Model_TestGetObject', $object);
		$this->assertEquals('testGetObjectArgs', $object->getArg());
	}
	
}