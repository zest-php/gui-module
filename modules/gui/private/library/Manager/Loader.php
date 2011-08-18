<?php

/**
 * @category Gui
 * @package Gui_Manager
 * @subpackage Loader
 */
class Gui_Manager_Loader{
	
	/**
	 * @var array
	 */
	protected $_moduleResourceType = array();
	
	/**
	 * @var array
	 */
	protected $_overrideClasses = array();
	
	/**
	 * @var array
	 */
	protected $_finalClasses = array();
	
	/**
	 * @var Gui_Manager
	 */
	protected $_manager = null;
	
	/**
	 * @return void
	 */
	public function __construct(Gui_Manager $manager){
		$this->_manager = $manager;
	}
	/**
	 * @param string $module
	 * @param string $resourceType
	 * @return Gui_Manager_Loader
	 */
	public function addModuleResourceType($module, $resourceType){
		$this->_moduleResourceType[] = array(
			'module' => $module,
			'resourceType' => $resourceType
		);
		return $this;
	}
	
	/**
	 * @param string $class
	 * @return string
	 */
	public function getClass($class){
		if($classTree = $this->getClassTree($class)){
			return $classTree[0];
		}
		return $class;
	}
	
	/**
	 * @param string $class
	 * @return array
	 */
	public function getClassTree($class){
		if(gettype($class) != 'string'){
			throw new Zest_Exception('$class doit être une chaîne de caractères.');
		}
		$dev = $this->_manager->isEnvironmentDev();
		
		// load
		if(!$dev){
			$this->_overrideClasses = (array) $this->_manager->getSaver()->load('Gui_Manager_Loader', 'overrideClasses');
			$this->_finalClasses = (array) $this->_manager->getSaver()->load('Gui_Manager_Loader', 'finalClasses');
		}
		
		// overrideClasses
		$overrideClasses = $this->_overrideClasses;
		$this->_initOverrideClasses();
		if(!$dev && $overrideClasses != $this->_overrideClasses){
			$this->_manager->getSaver()->save('Gui_Manager_Loader', 'overrideClasses', $this->_overrideClasses);
		}
		foreach($this->_overrideClasses as $classes){
			if(in_array($class, $classes)){
				return $classes;
			}
		}
		
		// finalClasses
		if(!isset($this->_finalClasses[$class])){
			$this->_finalClasses[$class] = $this->_getClassTree($class);
			if(!$dev){
				$this->_manager->getSaver()->save('Gui_Manager_Loader', 'finalClasses', $this->_finalClasses);
			}
		}
		return $this->_finalClasses[$class];
	}
	
	/**
	 * @param string $class
	 * @param array $options
	 * @return Gui_Object
	 */
	public function getObject($class, array $options = array()){
		$namespace = substr($class, 0, strpos($class, '_'));
		if($namespace == 'Gui' && strpos($class, 'Gui_Windowing_Window_Main') === false){
			throw new Zest_Exception('Impossible d\'utiliser le loader pour créer un objet avec le namespace "Gui".');
		}
		
		$class = $this->getClass($class);
		$object = new $class($options);
		
		if($object instanceof Gui_Object){
			if($options = $this->_manager->getSaver()->load('Gui_Manager_Loader', $class)){
				$object->setOptions($options);
				$new_options = $object->getOptions();
				if($new_options != $options){
					$this->saveObject($object);
				}
			}
			else{
				$this->saveObject($object);
			}
		}
		
		return $object;
	}
	
	/**
	 * @param Gui_Object $object
	 * @return Gui_Manager_Loader
	 */
	public function saveObject(Gui_Object $object){
		$this->_manager->getSaver()->save('Gui_Manager_Loader', get_class($object), $object->getOptions());
		return $this;
	}
	
	/**
	 * @param string $class
	 * @return string
	 */
	protected function _initOverrideClasses(){		
		foreach($this->_moduleResourceType as $key => $infos){
			if(isset($infos['init'])) continue;
			
			$resourceTypeInfos = $this->_resourceTypeInfos($infos['module'], $infos['resourceType']);
			if(is_null($resourceTypeInfos)){
				throw new Zest_Exception(sprintf('La ressource "%s" n\'a pas été trouvée dans le module "%s".', $infos['resourceType'], $infos['module']));
			}
				
			if(is_int(strpos($resourceTypeInfos['namespace'], '_Library'))){
				$resourceTypeInfos['namespace'] = str_replace('_Library', '', $resourceTypeInfos['namespace']);
			}
			
			$dir = new Zest_Dir($resourceTypeInfos['path']);
			if(!$dir->isReadable()){
				throw new Zest_Exception(sprintf('Impossible d\'accéder au dossier "%s".', $dir->getPathname()));
			}
			
			// récupération de tous les fichiers PHP
			$files = $dir->recursiveGlob('*.php');
			
			$i = 0;
			foreach($files as $file){
				// chemin relatif au dossier
				$class = str_replace($dir->getPathname(), '', $file->getPathname());
				
				// nom de la classe
				$class = str_replace('/', '_', trim($class, '/'));
				$class = $resourceTypeInfos['namespace'].'_'.basename($class, '.'.$file->getExtension());
				
				// récupération des parents
				$classTree = $this->_getClassTree($class, false);
				if(!$classTree){
					continue;
				}
				
				/*
				 * si une des classes a déjà chargée et
				 * si l'arbre de classes déjà chargé est PLUS important que l'arbre de classe de la classe
				 * on ne conserve que l'arbre de classes déjà chargé
				 * 
				 * si une des classes a déjà chargée et
				 * si l'arbre de classes déjà chargé est MOINS important que l'arbre de classe de la classe
				 * on supprime l'arbre de classes déjà chargé
				 */
				foreach($this->_overrideClasses as $key => $loadedClassTree){
					foreach($classTree as $classInTree){
						if(strpos($classInTree, 'Gui_') === 0) continue;
						
						if(in_array($classInTree, $loadedClassTree)){
							if(count($loadedClassTree) > count($classTree)){
								$classTree = null;
							}
							else{
								unset($this->_overrideClasses[$key]);
							}
							break 2;
						}
					}
				}
				
				if($classTree){
					array_splice($this->_overrideClasses, $i, 0, array($classTree));
					$i++;
				}
			}
			
			$this->_moduleResourceType[$key]['init'] = true;
		}
	}
	
	/**
	 * @return array
	 */
	protected function _resourceTypeInfos($module, $resourceType){
		$module = strtolower($module);
		$resourceType = strtolower($resourceType);
		
		$autoloaders = Zend_Loader_Autoloader::getInstance()->getAutoloaders();
		foreach($autoloaders as $autoloader){
			if($autoloader instanceof Zend_Loader_Autoloader_Resource){
				if($module == strtolower($autoloader->getNamespace())){
					$resourceTypes = $autoloader->getResourceTypes();
					if(isset($resourceTypes[$resourceType])){
						return $resourceTypes[$resourceType];
					}
					break;
				}
			}
		}
		return null;
	}
	
	/**
	 * @param string $class
	 * @param boolean $throwExceptions
	 * @return array
	 */
	protected function _getClassTree($class, $throwExceptions = true){		
		if(!class_exists($class)){
			throw new Zest_Exception(sprintf('La classe "%s" n\'existe pas.', $class));
		}
		
		$classTree = class_parents($class);
		array_unshift($classTree, $class);
		$classTree = array_values($classTree);
		
		$lastParent = end($classTree);
		$pos = strpos($lastParent, '_');
		$namespace = substr($lastParent, 0, $pos);
		
		if($namespace != 'Gui'){
			if($throwExceptions){
				throw new Zest_Exception(sprintf('La classe "%s" doit hériter d\'une classe dont l\'espace est "Gui".', $class));
			}
			return null;
		}
		
		return $classTree;
	}
	
}