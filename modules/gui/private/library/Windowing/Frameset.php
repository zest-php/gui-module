<?php

/**
 * @category Gui
 * @package Gui_Frameset
 */
class Gui_Windowing_Frameset extends Gui_Object implements IteratorAggregate{
	
	/**
	 * @var array
	 */
	protected $_frames = array();
	
	/**
	 * @param Gui_Windowing_Frameset_Frame|array|string $frame
	 * @param array $options
	 * @return Gui_Windowing_Frameset
	 */
	public function addFrame($frame = null, array $options = array()){
		if(!$frame instanceof Gui_Windowing_Frameset_Frame){
			if(is_null($frame)){
				$frame = array();
			}
			if(is_array($frame)){
				$frame = new Gui_Windowing_Frameset_Frame($frame);
			}
			else if(is_string($frame)){
				$frame = $this->_manager->get($frame);
			}
			if(!$frame instanceof Gui_Windowing_Frameset_Frame){
				throw new Zest_Exception('La frame doit être une instance de Gui_Windowing_Frameset_Frame.');
			}
		}
		$frame->setOptions($options);
		$this->_frames[] = $frame;
		return $this;
	}
	
	/**
	 * @param array $frames
	 * @return Gui_Windowing_Frameset
	 */
	public function addFrames($frames){
		foreach($frames as $frame => $options){
			if(is_numeric($frame)){
				$this->addFrame($options);
			}
			else{
				$this->addFrame($frame, $options);
			}
		}
		return $this;
	}
	
	/**
	 * @param array $frames
	 * @return Gui_Windowing_Frameset
	 */
	public function setFrames($frames){
		$this->_frames = array();
		$this->addFrames($frames);
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function getFrames(){
		return $this->_frames;
	}
	
	/**
	 * @return ArrayIterator
	 */
	public function getIterator(){
		return new ArrayIterator($this->getFrames());
	}
	
}