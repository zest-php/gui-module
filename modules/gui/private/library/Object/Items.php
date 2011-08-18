<?php

/**
 * @category Gui
 * @package Gui_Object
 */
abstract class Gui_Object_Items extends Gui_Object implements IteratorAggregate{
	
	/**
	 * @var string
	 */
	protected $_itemClassName = null;
	
	/**
	 * @var array
	 */
	protected $_items = array();
	
	/**
	 * @param Gui_Object_Items_Item|array|string $item
	 * @param array $options
	 * @return Gui_Object_Items
	 */
	public function addItem($item = null, array $options = array()){
		if(!$item instanceof $this->_itemClassName){
			if(is_null($item)){
				$item = array();
			}
			if(is_array($item)){
				$item = new $this->_itemClassName($item);
			}
			else if(is_string($item)){
				$item = $this->_manager->get($item);
			}
			if(!$item instanceof $this->_itemClassName){
				throw new Zest_Exception(sprintf('L\'item doit être une instance de %s.', $this->_itemClassName));
			}
		}
		$item->setOptions($options);
		$this->_items[] = $item;
		return $this;
	}
	
	/**
	 * @param array $items
	 * @return Gui_Object_Items
	 */
	public function addItems($items){
		foreach($items as $item => $options){
			if(is_numeric($item)){
				$this->addItem($options);
			}
			else{
				$this->addItem($item, $options);
			}
		}
		return $this;
	}
	
	/**
	 * @param array $items
	 * @return Gui_Object_Items
	 */
	public function setItems($items){
		$this->_items = array();
		$this->addItems($items);
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function getItem($id){
		foreach($this->getItems() as $item){
			if($item->getId() == $id){
				return $item;
			}
		}
		return null;
	}
	
	/**
	 * @return array
	 */
	public function getItems(){
		return $this->_items;
	}
	
	/**
	 * @return ArrayIterator
	 */
	public function getIterator(){
		return new ArrayIterator($this->getItems());
	}
	
	/**
	 * @param string $property
	 * @return Gui_Object_Items
	 */
	public function sortBy($property){
		$method = 'get'.ucfirst($property);
		usort($this->_items, create_function('$a, $b', "return strcasecmp(\$a->{$method}(), \$b->{$method}());")); 
	}
	
	/**
	 * @param string $method
	 * @param array $args
	 * @return mixed
	 */
	public function __call($method, $args){
		if(substr($method, 0, 6) == 'sortBy'){
			return $this->sortBy(strtolower(substr($method, 6)));
		}
		throw new Zest_Exception(sprintf('La méthode "%s" n\'existe pas.', $method));
	}
	
}