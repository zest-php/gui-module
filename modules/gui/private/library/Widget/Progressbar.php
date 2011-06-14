<?php

/**
 * @category Gui
 * @package Gui_Widget
 */
class Gui_Widget_Progressbar extends Gui_Widget{
	
	/**
	 * @var array
	 */
	protected $_availableWidgetOptions = array(
		'disabled', 'value'
	);

	/**
	 * @var array
	 */
	protected $_availableWidgetEvents = array(
		'change', 'complete', 'create'
	);
	
}