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

jimport('joomla.application.component.model');

/**
 * ajaxquiz Component ajaxquiz Model
 *

 * @author      notwebdesign
 * @package		Joomla
 * @subpackage	ajaxquiz
 * @since 1.5

 */

class AjaxquizModelAjaxquiz extends JModelLegacy
 {
    /**

	 * Constructor
	 */

	 var $_data = null;
	function __construct() {

		parent::__construct();

    	}

	protected function populateState()
        {
                $app = JFactory::getApplication('site');

                // Load state from the request.
                $pk = $app->input->getInt('id');
                $this->setState('ajaxquiz.id', $pk);

                $offset = $app->input->getUInt('limitstart');
                $this->setState('list.offset', $offset);

                // Load the parameters.
                $params = $app->getParams();
                $this->setState('params', $params);

                // TODO: Tune these values based on other permissions.
                $user           = JFactory::getUser();
                if ((!$user->authorise('core.edit.state', 'com_ajaxquiz')) &&  (!$user->authorise('core.edit', 'com_ajaxquiz'))){
                        $this->setState('filter.published', 1);
                        $this->setState('filter.archived', 2);
                }
        }



	function _buildQuery()
	{

	   		$cid		= JRequest::getVar('cid',1);
			$query = 'SELECT numques FROM #__ajaxquiz_category WHERE id = '.$cid;
			$this->_db->setQuery($query);
			$limit = intval($this->_db->loadResult());
			if($limit==0) {
		   	$query = 'SELECT a.*  '
				.'FROM #__ajaxquiz_question AS a'
				.' WHERE a.published = 1 AND a.cid='.$cid.' ORDER BY ordering';
			}
			else 
			{
			$query = 'SELECT a.*  '
				.'FROM #__ajaxquiz_question AS a'
				.' WHERE a.published = 1 AND a.cid='.$cid.' ORDER BY RAND() LIMIT '.$limit;
			}	

    	return $query;
	}
	
	function getData()

	{
		$db = $this->getDbo();
		$this->_data = array();
    		// Lets load the data if it doesn't already exist
    	 	if (empty( $this->_data ))
    	 		{

        			$query = $this->_buildQuery();
				$db->setQuery($query);
                                $datas = $db->loadObjectList();
				$k = 0;
				 foreach ( $datas as $data ) {
					// print_r($data);
					$data->params = clone $this->getState('params');
					$this->_data[$k] = $data;
					$k++;
  				}
        	 		// $data = $this->_getList( $query );
        	 		// $this->_data = $this->_getList( $query );
    			}
		// $data->params = clone $this->getState('params');
		// $this->_data = $data;
    	 	return $this->_data;

	}
}

?>
