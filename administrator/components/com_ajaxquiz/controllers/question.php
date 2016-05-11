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

defined('_JEXEC') or die;

/**
 * The Categories List Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_categories
 * @since       1.6
 */
class AjaxquizControllerQuestion extends JControllerForm
{


	protected $text_prefix = 'COM_AJAXQUIZ_QUESTION';
	/**
	 * Method override to check if you can add a new record.
	 *
	 * @param   array  $data  An array of input data.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowAdd($data = array())
	{
	
	
		$user = JFactory::getUser();
		$categoryId = JArrayHelper::getValue($data, 'id', $this->input->getInt('id'), 'int');
		$allow = null;

		if ($allow === null)
		{
			// In the absense of better information, revert to the component permissions.
			return parent::allowAdd();
		}
		else
		{
			return $allow;
		}
	}

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{

		$user           = JFactory::getUser();
                $recordId       = (int) isset($data[$key]) ? $data[$key] : 0;
                $categoryId = 0;

                if ($recordId)
                {
                        $categoryId = (int) $this->getModel()->getItem($recordId)->catid;
                }

                // if ($categoryId)
                // {
                        // The category has been set. Check the category permissions.
                //        return $user->authorise('core.edit', $this->option . '.category.' . $categoryId);
                // }
                // else
                // {
                        // Since there is no asset tracking, revert to the component permissions.
                        return parent::allowEdit($data, $key);
                // }




	}
	
	/**
	 * Method to run batch operations.
	 *
	 * @param   string  $model  The model
	 *
	 * @return	boolean  True on success.
	 *
	 * @since	2.5
	 */
	public function batch($model = null)
	{
	
	
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Set the model
		$model	= $this->getModel('Question', '', array());

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_ajaxquiz&view=questions' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}
	
//	public function cancel($key = NULL)
//        {
          // Check for request forgeries
//                JRequest::checkToken() or die( 'Invalid Token' );

 //               $this->setRedirect( JRoute::_( 'index.php?option=com_ajaxquiz&view=questions', false ) );
//        }
		

	
}