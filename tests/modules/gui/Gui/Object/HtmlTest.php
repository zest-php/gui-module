<?php

/**
 * @category Gui
 * @package Gui_Object
 * @subpackage UnitTests
 */
class Gui_Object_HtmlTest extends Gui_AbstractTest{

	/**
	 * @var Gui_Object_Html
	 */
	protected $_html = null;
	
	protected function setUp(){
		parent::setUp();
		$this->_html = new Gui_Object_Html();
	}
	
	public function testContent(){
		$this->_html->setContent('testContent');
		$this->assertEquals('testContent', $this->_html->getContent());
	}
	
	public function testContentViewScript(){
		$this->_html->setContentViewScript('testContentViewScript');
		$this->assertEquals('testContentViewScript', $this->_html->getContentViewScript());
	}
	
	public function testContentViewScriptDefault(){
		$html = new Ns_Object_HtmlTest_Html();
		$this->assertEquals('gui/ns/object/htmltest/html-content.phtml', $html->getContentViewScript());
	}
	
	public function testContentViewScriptException(){
		$this->setExpectedException('Zest_Exception');
		$this->_html->getContentViewScript();
	}
	
	public function testRenderContentNoContentNoContentViewScript(){
		$this->setExpectedException('Zest_Exception');
		$this->_html->renderContent();
	}
	
	public function testRenderContentWithContentNoContentViewScript(){
		$this->_html->setContent('testRenderContentWithContentNoContentViewScript');
		$this->assertEquals('testRenderContentWithContentNoContentViewScript', $this->_html->renderContent());
	}
	
	public function testRenderContentWithContentWithContentViewScript(){
		$this->_html->setContent('testRenderContentWithContentWithContentViewScript');
		$this->_html->setContentViewScript('object/html/testRenderContentWithContentWithContentViewScript.phtml');
		$this->assertEquals('testRenderContentWithContentWithContentViewScript', $this->_html->renderContent(self::$_view));
	}
	
	public function testRenderContentNoContentWithContentViewScript(){
		$this->_html->setContentViewScript('object/html/testRenderContentNoContentWithContentViewScript.phtml');
		$this->assertEquals('data/object/html/testRenderContentNoContentWithContentViewScript.phtml', $this->_html->renderContent());
	}
	
}

class Ns_Object_HtmlTest_Html extends Gui_Object_Html{
}