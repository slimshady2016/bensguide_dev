<?php  
/*------------------------------------------------------------------------
# YEEditor - independent
# ------------------------------------------------------------------------
# author    YEEDEEN
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;

class yeeDocument
{  
	/**
	 * Array of linked scripts
	 *
	 * @var    array
	 * @since  11.1
	 */
	public static $_scripts = array();

	/**
	 * Array of scripts placed in the header
	 *
	 * @var    array
	 * @since  11.1
	 */
	public static $_script = array();

	/**
	 * Array of linked style sheets
	 *
	 * @var    array
	 * @since  11.1
	 */
	public static $_styleSheets = array();

	/**
	 * Array of included style declarations
	 *
	 * @var    array
	 * @since  11.1
	 */
	public static $_style = array();
	
	/**
	 * Adds a linked script to the page
	 *
	 * @param   string   $url    URL to the linked script
	 * @param   string   $type   Type of script. Defaults to 'text/javascript'
	 * @param   boolean  $defer  Adds the defer attribute.
	 * @param   boolean  $async  Adds the async attribute.
	 *
	 * @return  JDocument instance of $this to allow chaining
	 *
	 * @since   11.1
	 */
	public function __construct(){
		$this->_scripts = array();
		$this->_script = array();
		$this->_styleSheets = array();
		$this->_style = array();
	} 
	 
	public function addScript($url, $type = "text/javascript", $defer = false, $async = false)
	{
		$this->_scripts[$url]['mime'] = $type;
		$this->_scripts[$url]['defer'] = $defer;
		$this->_scripts[$url]['async'] = $async;

		return $this;
	}
	
	/**
	 * Adds a script to the page
	 *
	 * @param   string  $content  Script
	 * @param   string  $type     Scripting mime (defaults to 'text/javascript')
	 *
	 * @return  JDocument instance of $this to allow chaining
	 *
	 * @since   11.1
	 */
	public function addScriptDeclaration($content, $type = 'text/javascript')
	{
		if (!isset($this->_script[strtolower($type)]))
		{
			$this->_script[strtolower($type)] = $content;
		}
		else
		{
			$this->_script[strtolower($type)] .= chr(13) . $content;
		}

		return $this;
	}
	
	/**
	 * Adds a linked stylesheet to the page
	 *
	 * @param   string  $url      URL to the linked style sheet
	 * @param   string  $type     Mime encoding type
	 * @param   string  $media    Media type that this stylesheet applies to
	 * @param   array   $attribs  Array of attributes
	 *
	 * @return  JDocument instance of $this to allow chaining
	 *
	 * @since   11.1
	 */
	public function addStyleSheet($url, $type = 'text/css', $media = null, $attribs = array())
	{
		$this->_styleSheets[$url]['mime'] = $type;
		$this->_styleSheets[$url]['media'] = $media;
		$this->_styleSheets[$url]['attribs'] = $attribs;

		return $this;
	}

	/**
	 * Adds a stylesheet declaration to the page
	 *
	 * @param   string  $content  Style declarations
	 * @param   string  $type     Type of stylesheet (defaults to 'text/css')
	 *
	 * @return  JDocument instance of $this to allow chaining
	 *
	 * @since   11.1
	 */
	public function addStyleDeclaration($content, $type = 'text/css')
	{
		if (!isset($this->_style[strtolower($type)]))
		{
			$this->_style[strtolower($type)] = $content;
		}
		else
		{
			$this->_style[strtolower($type)] .= chr(13) . $content;
		}

		return $this;
	}
	
	public function getDocument(){
		$document = array(
			"_scripts" =>  $this->_scripts,
			"_script" =>  $this->_script,
			"_styleSheets" =>  $this->_styleSheets,
			"_style" =>  $this->_style
		);
		return $document;
	}
	
}