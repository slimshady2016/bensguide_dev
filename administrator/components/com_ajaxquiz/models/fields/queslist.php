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

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');


class JFormFieldQuesList extends JFormFieldList
{
        /**
         * A flexible category list that respects access controls
         *
         * @var         string
         * @since       1.6
         */
        public $type = 'QuesList';

	/**
         * Method to get a list of categories that respects access controls and can be used for
         * either category assignment or parent category assignment in edit screens.
         * Use the parent element to indicate that the field will be used for assigning parent categories.
         *
         * @return      array   The field option objects.
         * @since       1.6
         */
        protected function getOptions()
        {

		$options = array();		
		$db             = JFactory::getDbo();
                $query  = $db->getQuery(true);

                $query->select('a.id AS value, a.title AS text, a.published');
                $query->from('#__ajaxquiz_question AS a');

		// Get the options.
                $db->setQuery($query);

                try
                {
                        $options = $db->loadObjectList();
                }
                catch (RuntimeException $e)
                {
                        JError::raiseWarning(500, $e->getMessage);
                }
				
		array_unshift($options, JHtml::_('select.option', '0', '- '.JText::_('Select Question').' -', 'value', 'text'));			

		return $options;
	}

}		

