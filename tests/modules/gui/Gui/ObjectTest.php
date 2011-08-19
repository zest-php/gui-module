<?php

/**
 * @category Gui
 * @subpackage UnitTests
 */
class Gui_ObjectTest extends Gui_AbstractTest{
	
	/**
	 * @var Gui_Object
	 */
	protected $_object = null;
	
	protected function setUp(){
		parent::setUp();
		$this->_object = new Ns_ObjectTest_Object();
	}
	
	public function testSetOptions(){
		$this->_object = new Gui_Object_Html();
		
		$this->_object->setOptions(array('contentViewScript' => 'testSetOptions 1'));
		$this->assertEquals('testSetOptions 1', $this->_object->getContentViewScript());
		
		$this->_object->setOptions(array('content_view_script' => 'testSetOptions 2'));
		$this->assertEquals('testSetOptions 2', $this->_object->getContentViewScript());
		
		$this->_object->setOptions(array('content view script' => 'testSetOptions 3'));
		$this->assertEquals('testSetOptions 3', $this->_object->getContentViewScript());
	}
	
	public function testGetId(){
		$this->_object = new Gui_ObjectTest_Object();
		$this->assertRegExp('/gui-object-[0-9]+/', $this->_object->getId());
	}
	
	public function testGetIdNs(){
		$this->assertEquals('ns-objecttest-object', $this->_object->getId());
	}
	
	public function testAssign(){
		$this->_object->assign('var_name1', 'var_value1');
		$this->_object->assign(array('var_name2' => 'var_value2'));
		$this->assertEquals(array('var_name1' => 'var_value1', 'var_name2' => 'var_value2'), $this->_object->getVars());
		$this->_object->setViewScript('object/testAssign.phtml');
		$this->assertEquals('var_value1 var_value2', $this->_object->render());
	}
	
	public function testClearVars(){
		$this->_object->assign('var_name', 'var_value');
		$this->assertEquals(array('var_name' => 'var_value'), $this->_object->getVars());
		$this->_object->clearVars();
		$this->assertEmpty($this->_object->getVars());
	}
	
	public function testGetViewScript(){
		$this->assertEquals('gui/ns/objecttest/object.phtml', $this->_object->getViewScript());
	}
	
	public function testGetViewScriptGuiNamespace(){
		$this->_object = new Gui_ObjectTest_Object();
		$this->assertEquals('gui/objecttest/object.phtml', $this->_object->getViewScript());
	}
	
	public function testGetSetView(){
		// Zest_View::getStaticView()
		$this->assertTrue($this->_object->getView() === self::$_view);
		
		// new
		$view = new Zest_View();
		$this->_object->setView($view);
		$this->assertFalse($this->_object->getView() === self::$_view);
		
		// render
		$this->_object->setView(null);
		$this->assertTrue($this->_object->getView() === self::$_view);
		foreach(Zest_View::getStaticView()->getScriptPaths() as $path){
			$view->addScriptPath($path);
		}
		$this->_object->setViewScript('object/testAssign.phtml');
		$this->_object->render($view);
		$this->assertFalse($this->_object->getView() === self::$_view);		
	}
	
	public function testRender(){
		$this->_object->setViewScript('object/testRender.phtml');
		$this->_object->assign('une_variable', 'testRender');
		$this->assertEquals('testRender getTestRender', $this->_object->render());
	}
	
	public function testXhrMethods(){
		$this->assertTrue($this->_object->isXhrMethod('testXhrMethods'));
		$this->assertFalse($this->_object->isXhrMethod('getTestRender'));
	}
	
	public function testGetSetParams(){
		$this->assertNull($this->_object->getParam('testGetSetParams'));
		$this->_object->setParam('testGetSetParams', 1);
		$this->assertEquals(1, $this->_object->getParam('testGetSetParams'));
		$this->_object->setParams(array());
		$this->assertNull($this->_object->getParam('testGetSetParams'));
		$this->_object->setParams(array('testGetSetParams' => 1));
		$this->assertEquals(1, $this->_object->getParam('testGetSetParams'));
	}
	
	public function testGetOptions(){
		$this->_object->setParam('object_id', 1);
		$this->assertEquals(array('params' => array('object_id' => 1)), $this->_object->getOptions());
	}
	
	public function testInit(){
		$this->assertTrue($this->_object->testInit);
	}
	
	public function testPreRender(){
		$this->assertFalse($this->_object->testPreRender);
		$this->_object->setViewScript('object/testRender.phtml');
		$this->_object->render(self::$_view);
		$this->assertTrue($this->_object->testPreRender);
	}
	
	public function testPostRender(){
		$this->assertFalse($this->_object->testPostRender);
		$this->_object->setViewScript('object/testRender.phtml');
		$this->_object->render(self::$_view);
		$this->assertTrue($this->_object->testPostRender);
	}
	
}

class Gui_ObjectTest_Object extends Gui_Object{
}

class Ns_ObjectTest_Object extends Gui_Object{
	protected $_xhrMethods = array('testXhrMethods');
	public $testInit = false;
	public $testPreRender = false;
	public $testPostRender = false;
	public function init(){
		$this->testInit = true;
	}
	public function preRender(){
		$this->testPreRender = true;
	}
	public function postRender(){
		$this->testPostRender = true;
	}
	public function getTestRender(){
		return 'getTestRender';
	}
}