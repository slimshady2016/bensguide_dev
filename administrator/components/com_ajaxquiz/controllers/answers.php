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
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Olas Controller
 */
class AjaxquizControllerAnswers extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_AJAXQUIZ_ANSWERS';

	public function getModel($name = 'Answer', $prefix = 'AjaxquizModel',$config = array('ignore_request' => true)) 
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
	
        public function saveOrderAjax()
        {
                $pks = $this->input->post->get('cid', array(), 'array');
                $order = $this->input->post->get('order', array(), 'array');

                // Sanitize the input
                JArrayHelper::toInteger($pks);
                JArrayHelper::toInteger($order);

                // Get the model
                $model = $this->getModel();

                // Save the ordering
                $return = $model->saveorder($pks, $order);

                if ($return)
                {
                        echo "1";
                }

                // Close the application
                JFactory::getApplication()->close();
        }


	

}
