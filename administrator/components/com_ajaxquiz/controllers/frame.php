<?php
/*------------------------------------------------------------------------
# component_Ajax_quiz - Ajax Quiz 
# ------------------------------------------------------------------------
# author    WebKul
# copyright Copyright (C) 2010 webkul.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.webkul.com
# Technical Support:  Forum - http://www.webkul.com/index.php?Itemid=86&option=com_kunena
-----------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
 
class AjaxquizControllerFrame extends JControllerAdmin
{


	protected $text_prefix = 'COM_AJAXQUIZ_FRAME';
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function __construct($config = array())
        {
                parent::__construct($config);

        }

	public function getModel($name = 'Frame', $prefix = 'AjaxquizModel',$config = array('ignore_request' => true)) 
	{

		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}



}
