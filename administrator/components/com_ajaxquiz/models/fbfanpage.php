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



// no direct access

defined('_JEXEC') or die('Restricted access');



// Import Joomla! libraries

jimport('joomla.application.component.model');



class AjaxquizModelFbfanpage extends JModelList {









/**

 * Ajaxquiz data

 *

 * @var array

 */

	var $_data = null;

	

	var $_total = null;

	

	var $_pagination = null;

    

	var $_id = null;



    function __construct() {

		parent::__construct();



		global $option;

                $app = JFactory::getApplication();	

		

		$limit =JRequest::getInt( 'limit', $app->getCfg('list_limit') );

                $limitstart = JRequest::getInt( 'limitstart', 0 );	



		$this->setState('limit', $limit);

		$this->setState('limitstart', $limitstart);

		

		$array = JRequest::getVar('cid',  0, '', 'array');

		$this->setId((int)$array[0]);

		

    }

	

	

	/**

	 * Method to set the category identifier

	 *

	 * @access	public

	 * @param	int Category identifier

	 */

	function setId($id)

	{

		// Set id and wipe data

		$this->_id	 = $id;

		$this->_data = null;

	}



	/**

	* Returns the query

	* @return string The query to be used to retrieve the rows from the database

	*/

}
?>