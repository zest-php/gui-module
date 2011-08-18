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
	 * @var boolean
	 */
	protected $_jqueryuiAll = false;
	
	/**
	 * @var array
	 */
	protected $_js = array();
	
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
		$this->_js($this->_manager->getConfigUrl('url.jquery.core'), true);
		return $this;
	}
	
	/**
	 * @param string $plugin
	 * @return Gui_View_Helper_Jquery
	 */
	public function plugin($plugin){
		$this->_js($this->_manager->getConfigUrl('url.jquery.'.$plugin));
		return $this;
	}
	
	/**
	 * @param string $component
	 * @return Gui_View_Helper_Jquery
	 */
	public function ui($component = null){
		if($this->_jqueryuiAll){
			return $this;
		}
		if($component){
			$this->_js($this->_manager->getConfigUrl('url.jquery.ui.core'));
			
			if(substr($component, 0, 7) == 'effects'){
				$this->_js($this->_manager->getConfigUrl('url.jquery.ui.component', 'effects.core'));
			}
			else{
				if(in_array($component, $this->_dependencies['widget'])){
					$this->_js($this->_manager->getConfigUrl('url.jquery.ui.component', 'ui.widget'));
				}
				if(in_array($component, $this->_dependencies['mouse'])){
					$this->_js($this->_manager->getConfigUrl('url.jquery.ui.component', 'ui.mouse'));
				}
				if(in_array($component, $this->_dependencies['position'])){
					$this->_js($this->_manager->getConfigUrl('url.jquery.ui.component', 'ui.position'));
				}
			}
			
			$this->_js($this->_manager->getConfigUrl('url.jquery.ui.component', $component));
			if($component == 'ui.datepicker'){
				$this->_js($this->_manager->getConfigUrl('url.jquery.ui.i18n', $this->_getLanguage()));
			}
		}
		else{
			$headScript = $this->view->headScript();
			$iterator = (array) $headScript->getIterator();
			foreach($iterator as $offset => $script){
				if(isset($script->attributes['src']) && in_array($script->attributes['src'], $this->_js)){
					$headScript->offsetUnset($offset);
				}
			}
			
			$this->_jqueryuiAll = true;
			$this->_js($this->_manager->getConfigUrl('url.jquery.ui.i18n', $this->_getLanguage()), true);
			$this->_js($this->_manager->getConfigUrl('url.jquery.ui.all'), true);
			$this->core();
		}
		$this->_css($this->_manager->getConfigUrl('url.jquery.ui.css'));
		return $this;
	}
	
	/**
	 * @return Gui_View_Helper_Jquery
	 */
	public function reset(){
		$this->_js = array();
		$this->_jqueryuiAll = false;
		return $this;
	}
	
	/**
	 * @param string $js
	 * @param boolean $prepend
	 * @return void
	 */
	protected function _js($js, $prepend = false){
		$this->_js[] = $js;
		$this->view->head()->js($js, $prepend);
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
	
}