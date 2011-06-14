<?php

/**
 * @category Gui
 * @package Gui_View
 * @subpackage Helper
 */
class Gui_View_Helper_Jquery extends Zend_View_Helper_Abstract{
	
	/**
	 * @var Gui_Manager
	 */
	protected $_manager = null;
	
	/**
	 * @var array
	 */
	protected $_dependencies = array(
		'widget' => array(
			'ui.draggable', 'ui.droppable', 'ui.resizable', 'ui.selectable', 'ui.sortable',
			'ui.accordion', 'ui.autocomplete', 'ui.button', 'ui.dialog', 'ui.progressbar', 'ui.slider', 'ui.tabs'
		),
		'mouse' => array(
			'ui.draggable', 'ui.droppable', 'ui.resizable', 'ui.selectable', 'ui.sortable',
			'ui.slider'
		),
		'position' => array(
			'ui.autocomplete', 'ui.dialog'
		)
	);
	
	/**
	 * @return void
	 */
	public function __construct(){
		$this->_manager = Gui_Manager::getInstance();
	}
	
	/**
	 * @return Gui_View_Helper_Jquery
	 */
	public function jquery(){
		return $this->core();
	}
	
	/**
	 * @return Gui_View_Helper_Jquery
	 */
	public function core(){
		$this->_js($this->_getUrl('url.jquery.core'));
		return $this;
	}
	
	/**
	 * @param string $plugin
	 * @return Gui_View_Helper_Jquery
	 */
	public function plugin($plugin){
		$this->_js($this->_getUrl('url.jquery.'.$plugin));
		return $this;
	}
	
	/**
	 * @param string $component
	 * @return Gui_View_Helper_Jquery
	 */
	public function ui($component = null){
		if($component){
			$this->_js($this->_getUrl('url.jquery.ui.core'));
			
			if(substr($component, 0, 7) == 'effects'){
				$this->_js($this->_getUrl('url.jquery.ui.component', 'effects.core'));
			}
			else{
				if(in_array($component, $this->_dependencies['widget'])){
					$this->_js($this->_getUrl('url.jquery.ui.component', 'ui.widget'));
				}
				if(in_array($component, $this->_dependencies['mouse'])){
					$this->_js($this->_getUrl('url.jquery.ui.component', 'ui.mouse'));
				}
				if(in_array($component, $this->_dependencies['position'])){
					$this->_js($this->_getUrl('url.jquery.ui.component', 'ui.position'));
				}
			}
			
			$this->_js($this->_getUrl('url.jquery.ui.component', $component));
			if($component == 'ui.datepicker'){
				$this->_js($this->_getUrl('url.jquery.ui.i18n', $this->_getLanguage()));
			}
		}
		else{
			$this->_js($this->_getUrl('url.jquery.ui.all'));
			$this->_js($this->_getUrl('url.jquery.ui.i18n', $this->_getLanguage()));
		}
		$this->_css($this->_getUrl('url.jquery.ui.css'));
		return $this;
	}
	
	/**
	 * @param string $js
	 * @return void
	 */
	protected function _js($js){
		$this->view->head()->js($js);
	}
	
	/**
	 * @param string $css
	 * @return void
	 */
	protected function _css($css){
		$this->view->head()->css($css);
	}
	
	/**
	 * @return string
	 */
	protected function _getLanguage(){
		if(Zend_Registry::isRegistered('Zend_Locale')){
			$locale = Zend_Registry::get('Zend_Locale')->getLanguage();
		}
		else{
			$locale = key(Zend_Locale::getDefault());
		}
		return $locale;
	}
	
	/**
	 * @param string $config
	 * @return void
	 */
	protected function _getUrl($config, $sprintf = null){
		$url = dirname($this->_manager->getUrl()).'/'.$this->_manager->getConfig($config);
		if($sprintf){
			$url = sprintf($url, $sprintf);
		}
		return $url;
	}
	
}