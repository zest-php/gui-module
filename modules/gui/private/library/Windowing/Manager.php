<?php

/**
 * @category Gui
 * @package Gui_Window
 */
class Gui_Windowing_Manager{
	
	/**
	 * @var Gui_Windowing_Manager
	 */
	protected static $_instance = null;
	
	/**
	 * @var Gui_Windowing_Window_Main
	 */
	protected $_mainWindow = null;
	
	/**
	 * @var array
	 */
	protected $_openedWindows = null;
	
	/**
	 * @var array
	 */
	protected $_sendedObjects = array();
	
	/**
	 * @var Gui_Manager
	 */
	protected $_manager = null;
	
	/**
	 * @return void
	 */
	protected function __construct(){
		$this->_manager = Gui_Manager::getInstance();
	}
	
	/**
	 * @return Gui_Windowing_Manager
	 */
	public static function getInstance(){
		if(is_null(self::$_instance)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * @return Gui_Windowing_Window_Main
	 */
	public function getMainWindow(){
		if(is_null($this->_mainWindow)){
			$this->_mainWindow = $this->_manager->get('Gui_Windowing_Window_Main');
		}
		return $this->_mainWindow;
	}
	
	/**
	 * @return array
	 */
	public function getOpenedWindows(){
		if(is_null($this->_openedWindows)){
			$this->_openedWindows = array();
			if($windows = $this->_manager->getSaver()->load('Gui_Windowing_Manager', 'open_windows')){
				foreach($windows as $key => $window){
					try{
						$this->_openedWindows[$window] = $this->_manager->get($window);
					}
					catch(Exception $e){
						unset($windows[$key]);
						$this->_manager->getSaver()->save('Gui_Windowing_Manager', 'open_windows', $windows);
					}
				}
			}
		}
		return $this->_openedWindows;
	}
	
	/**
	 * @params Gui_Windowing_Window|string $window
	 * @return Gui_Windowing_Manager
	 */
	public function openWindow($window){
		if(is_string($window)){
			$window = $this->_manager->get($window);
		}
		if(!$window instanceof Gui_Windowing_Window){
			throw new Zest_Exception('La fenêtre doit être une instance de Gui_Windowing_Window.');
		}
		
		$this->getOpenedWindows();
		$class = get_class($window);
		if(!isset($this->_openedWindows[$class])){
			$this->_openedWindows[$class] = $window;
			$this->_manager->getSaver()->save('Gui_Windowing_Manager', 'open_windows', array_keys($this->_openedWindows));
		}
		
		$this->send($window);
		
		return $this;
	}
	
	/**
	 * @params Gui_Windowing_Window|string $window
	 * @return Gui_Windowing_Manager
	 */
	public function closeWindow($window){
		if($window instanceof Gui_Windowing_Window){
			$window = get_class($window);
		}
		$this->getOpenedWindows();
		unset($this->_openedWindows[$window]);
		$this->_manager->getSaver()->save('Gui_Windowing_Manager', 'open_windows', array_keys($this->_openedWindows));
		return $this;
	}
	
	/**
	 * @params Gui_Object|string $window
	 * @return Gui_Windowing_Manager
	 */
	public function send($object){
		if(is_string($object)){
			$object = $this->_manager->get($object);
		}
		if(!$object instanceof Gui_Object){
			throw new Zest_Exception('L\'objet doit être une instance de Gui_Object.');
		}
		$this->_sendedObjects[$object->getId()] = $object;
		return $this;
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return string
	 */
	public function render(Zend_View_Interface $view = null){
		$request = Zest_Controller_Front::getInstance()->getRequest();
		
		$main = $this->getMainWindow();
		if(is_null($view)){
			$view = $main->getView();
		}
		else{
			$main->setView($view);
		}
		$view->jquery()->ui();
			
		if($request->isXmlHttpRequest()){
			$render = array('objects' => array());
			foreach($this->_sendedObjects as $id => $object){
				$className = get_class($object);
				$render['objects'][$id] = array(
					'render' => $object->render(),
					'options' => $object->getOptions(),
					'class_name' => $className,
					'is_window' => array_key_exists($className, $this->getOpenedWindows())
				);
			}
			
			// assets
			$render['assets'] = $view->head()->toString(array('headLink', 'headStyle', 'headScript'));
			
			$render = Zend_Json::encode($render);
		}
		else{
			$openedWindows = array();
			foreach($this->getOpenedWindows() as $class => $window){
				$openedWindows[] = array(
					'class_name' => $class,
					'id' => $window->getId(),
					'options' => $window->getOptions()
				);
			}
			
			$render = $main->render();
			$view->head()
				->js($this->_manager->getConfigUrl('url.gui.js', 'windowing/manager.js'))
				->jsInline('
					var windows = '.Zend_Json::encode($openedWindows).';
					var call_url = \''.$view->url(array('module' => 'gui', 'controller' => 'windowing', 'action' => 'call')).'\';
				');
				
			$plugins = new Zest_Dir($this->_manager->getConfigDirectory('url.gui.js', 'windowing/plugins/'));
			foreach($plugins as $plugin){
				$view->head()->js($this->_manager->getConfigUrl('url.gui.js', 'windowing/plugins/'.$plugin->getBasename()));
			}
		}
		
		return $render;
	}
	
}