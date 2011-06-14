<?php

/**
 * @category Gui
 * @package Gui_View
 * @subpackage Helper
 */
class Gui_View_Helper_Head extends Zest_View_Helper_Head{
	
	/**
	 * @var Gui_Manager
	 */
	protected $_manager = null;
	
	/**
	 * @var boolean
	 */
	protected $_initSessionReferersRequestUri = true;
	
	/**
	 * @return void
	 */
	public function __construct(){
		$this->_manager = Gui_Manager::getInstance();
	}
	
	/**
	 * @param string $href
	 * @param string|array $media
	 * @param boolean $prepend
	 * @return Zest_View_Helper_Head|array
	 */
	public function css($href = null, $media = null, $prepend = false){
		if($href = $this->_sessioned('css', $href)){
			parent::css($href, $media, $prepend);
		}
	}
	
	/**
	 * @param string $src
	 * @param boolean $prepend
	 * @return Zest_View_Helper_Head|array
	 */
	public function js($src = null, $prepend = false){
		if($src = $this->_sessioned('js', $src)){
			parent::js($src, $prepend);
		}
	}
	
	/**
	 * @param string $type
	 * @param array $args
	 * @return void
	 */
	protected function _sessioned($type, $file){
		
		$add = true;
		
		$request = Zest_Controller_Front::getInstance()->getRequest();
		$referers = (array) $this->_manager->getSession()->Gui_View_Helper_Jquery;
		
		if($request->isXmlHttpRequest()){
			$referer = $request->getHeader('referer');
			
			if(!isset($referers[$referer])){
				$referers[$referer] = array();
			}
			if(!isset($referers[$referer][$type])){
				$referers[$referer][$type] = array();
			}
			$add = !in_array($file, $referers[$referer][$type]);
			
			if($add){
				$referers[$referer][$type][] = $file;
				$this->_manager->getSession()->Gui_View_Helper_Jquery = $referers;
			}
		}
		else{
			$requestUri = $this->view->serverUrl($request->getRequestUri());
			
			if($this->_initSessionReferersRequestUri || !isset($referers[$requestUri])){
				$this->_initSessionReferersRequestUri = false;
				$referers[$requestUri] = array();
			}
			if(!isset($referers[$requestUri][$type])){
				$referers[$requestUri][$type] = array();
			}
			if(!in_array($file, $referers[$requestUri][$type])){
				$referers[$requestUri][$type][] = $file;
			}
			
			$this->_manager->getSession()->Gui_View_Helper_Jquery = $referers;
		}
		
		if($add){
			return $file;
		}
		return null;
	}
	
}