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


class JFormFieldAssignUser extends JFormFieldList
{
        /**
         * A flexible category list that respects access controls
         *
         * @var         string
         * @since       1.6
         */
        public $type = 'AssignUser';

	    protected function getOptions()
        {


			$options     =  array

							  (

							  "0"=>array

							  (

							  "value"=>"Not Assign",

							  "text"=>"Select for Assign User"

							  ),

							  "1"=>array

							  (

							  "value"=>"User",

							  "text"=>"user"

							  ),

							  "2"=>array

							  (

							  "value"=>"Administrator",

							  "text"=>"admin"

							  )

							  ); 

							  	

		return $options;
	}

}		

