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
 
 
class AjaxquizControllerResult extends JControllerAdmin
{
	protected $text_prefix = 'COM_AJAXQUIZ_RESULT';
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function __construct($config = array())
        {
                parent::__construct($config);

        }

	public function getModel($name = 'Result', $prefix = 'AjaxquizModel',$config = array('ignore_request' => true)) 
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
	
	public function remove()	{


		$cid		= JRequest::getVar( 'cid', array(0), 'post', 'array' );

		if (!is_array( $cid ) || count( $cid ) < 1) {

			JError::raiseError(500, JText::_( 'Select an item to delete' ) );

		}

		$model = $this->getModel('result');

		$msg = $model->remove($cid);

		$cache = &JFactory::getCache('com_ajaxquiz');
		$cache->clean();

		$this->setRedirect( 'index.php?option=com_ajaxquiz&view=result', $msg );
	}



}
